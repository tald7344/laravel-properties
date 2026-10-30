<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnerSubscriptionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    public function test_owner_registration_receives_a_free_two_month_basic_plan_but_renters_do_not(): void
    {
        $this->post(route('auth.register'), [
            'name' => 'New owner',
            'phone' => '0991234567',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'owner',
        ])->assertRedirect(route('owner.dashboard'));

        $owner = User::where('phone', '0991234567')->firstOrFail();
        $basic = $owner->subscriptions()->firstOrFail();
        $this->assertSame('basic', $basic->plan);
        $this->assertSame(1, $basic->property_limit);
        $this->assertSame(0.0, (float) $basic->amount);
        $this->assertTrue($basic->ends_at->equalTo($basic->starts_at->copy()->addMonths(2)));

        $this->post(route('auth.register'), [
            'name' => 'New renter',
            'phone' => '0771234567',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'tenant',
        ])->assertRedirect(route('renter.dashboard'));

        $this->assertSame(0, User::where('phone', '0771234567')->firstOrFail()->subscriptions()->count());
    }

    public function test_basic_plan_allows_one_property_and_blocks_a_second(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $this->actingAs($owner)->get(route('owner.dashboard'))->assertOk();

        $payload = $this->propertyPayload();
        $this->post(route('owner.properties.store'), $payload)->assertRedirect(route('owner.dashboard'));
        $this->post(route('owner.properties.store'), $payload)->assertForbidden();

        $this->assertSame(1, $owner->properties()->count());
    }

    public function test_expired_owner_is_locked_except_for_renewal_and_cannot_receive_renter_messages(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $property = $this->createProperty($owner, 'published');
        Subscription::create([
            'user_id' => $owner->id,
            'plan' => 'basic',
            'property_limit' => 1,
            'amount' => 0,
            'status' => 'approved',
            'starts_at' => now()->subMonths(3),
            'ends_at' => now()->subMonth(),
        ]);

        $this->actingAs($owner)
            ->get(route('owner.dashboard'))
            ->assertRedirect(route('owner.subscription'));
        $this->get(route('owner.profile.edit'))->assertRedirect(route('owner.subscription'));

        $this->get(route('owner.subscription'))
            ->assertOk()
            ->assertSee(__('owner-dashboard.plan_basic'))
            ->assertSee(__('owner-dashboard.plan_premium'))
            ->assertSee('subscription-plans', false)
            ->assertSee('data-property-capacity', false)
            ->assertSee(__('owner-dashboard.owner_phone_hidden'))
            ->assertSee(__('owner-dashboard.listings_remain_visible'));

        $this->post(route('owner.subscribe'), [
            'property_limit' => 1,
            'reference' => 'RENEW-123',
        ])->assertRedirect();
        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $owner->id,
            'plan' => 'premium',
            'status' => 'pending',
            'sham_cash_reference' => 'RENEW-123',
        ]);

        $this->get(route('properties.show', $property))
            ->assertOk()
            ->assertSee(__('property-details.owner_unavailable'))
            ->assertDontSee('properties.contact');

        $this->post(route('properties.contact', $property), [
            'phone' => '0771234567',
            'message' => 'Please contact me.',
        ])->assertForbidden();

        $this->assertDatabaseHas('properties', ['id' => $property->id, 'status' => 'published']);
    }

    public function test_premium_request_is_billed_for_selected_capacity_at_the_configured_monthly_rate(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $this->createProperty($owner);
        $this->createProperty($owner);
        $this->createProperty($owner);
        Setting::updateOrCreate(
            ['key' => 'premium_monthly_price_per_property'],
            ['value' => '3.00', 'type' => 'decimal']
        );
        Subscription::create([
            'user_id' => $owner->id,
            'plan' => 'basic',
            'property_limit' => 1,
            'amount' => 0,
            'status' => 'approved',
            'starts_at' => now()->subMonth(),
            'ends_at' => now()->addMonth(),
        ]);

        $this->actingAs($owner)->post(route('owner.subscribe'), [
            'property_limit' => 3,
            'reference' => 'PAYMENT-123',
        ])->assertRedirect();

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $owner->id,
            'plan' => 'premium',
            'property_limit' => 3,
            'amount' => 9,
            'sham_cash_reference' => 'PAYMENT-123',
            'status' => 'pending',
        ]);

        $basic = $owner->subscriptions()->where('plan', 'basic')->firstOrFail();
        $premium = $owner->subscriptions()->where('plan', 'premium')->firstOrFail();
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.subscriptions.approve', $premium))
            ->assertRedirect();

        $premium->refresh();
        $this->assertSame('approved', $premium->status);
        $this->assertTrue($premium->starts_at->equalTo($basic->ends_at));
        $this->assertTrue($premium->ends_at->equalTo($premium->starts_at->copy()->addMonth()));
    }

    private function propertyPayload(): array
    {
        return [
            'title' => 'A test property',
            'description' => 'A property used in a subscription test.',
            'city' => 'Damascus',
            'neighborhood' => 'Central',
            'purpose' => 'rent',
            'category' => 'residential',
            'price' => 500,
            'currency' => 'USD',
        ];
    }

    private function createProperty(User $owner, string $status = 'pending'): Property
    {
        return Property::create($this->propertyPayload() + [
            'user_id' => $owner->id,
            'status' => $status,
            'published_at' => $status === 'published' ? now() : null,
        ]);
    }
}
