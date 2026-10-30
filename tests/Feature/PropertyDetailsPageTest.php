<?php

namespace Tests\Feature;

use App\Models\Language;
use App\Models\Property;
use App\Models\User;
use App\Services\OwnerSubscriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Tests\TestCase;

class PropertyDetailsPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    public function test_property_details_show_a_responsive_detail_page_and_active_language_options(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        app(OwnerSubscriptionService::class)->ensureBasicPlan($owner);
        $property = Property::create([
            'user_id' => $owner->id,
            'title' => 'Sunny family home',
            'description' => 'A spacious family home.',
            'city' => 'Damascus',
            'neighborhood' => 'Central',
            'purpose' => 'rent',
            'category' => 'residential',
            'price' => 450,
            'currency' => 'USD',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Language::create([
            'code' => 'ar',
            'name' => 'Arabic',
            'native_name' => 'العربية',
            'direction' => 'rtl',
            'is_active' => true,
            'is_default' => true,
        ]);
        $english = Language::create([
            'code' => 'en',
            'name' => 'English',
            'native_name' => 'English',
            'direction' => 'ltr',
            'is_active' => true,
            'is_default' => false,
        ]);
        $inactive = Language::create([
            'code' => 'fr',
            'name' => 'French',
            'native_name' => 'Français',
            'direction' => 'ltr',
            'is_active' => false,
            'is_default' => false,
        ]);

        $detailsUrl = route('properties.show', $property);
        $this->get($detailsUrl)
            ->assertOk()
            ->assertSee('property-gallery-grid', false)
            ->assertSee('property-contact-form', false)
            ->assertSee('اكتشف العقارات')
            ->assertSee(route('language.switch', $english), false)
            ->assertDontSee(route('language.switch', $inactive), false)
            ->assertDontSee('purpose=rent')
            ->assertDontSee('purpose=sale');

        $this->from($detailsUrl)
            ->get(route('language.switch', $english))
            ->assertRedirect($detailsUrl);

        $this->get($detailsUrl)
            ->assertOk()
            ->assertSee('<html lang="en" dir="ltr">', false);
    }

    public function test_property_contact_and_report_requests_are_validated_and_saved(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        app(OwnerSubscriptionService::class)->ensureBasicPlan($owner);
        $property = Property::create([
            'user_id' => $owner->id,
            'title' => 'Sunny family home',
            'description' => 'A spacious family home.',
            'city' => 'Damascus',
            'neighborhood' => 'Central',
            'purpose' => 'rent',
            'category' => 'residential',
            'price' => 450,
            'currency' => 'USD',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->post(route('properties.contact', $property), [
            'phone' => '0991234567',
            'message' => 'I would like to view this property.',
        ])->assertRedirect();

        $this->assertDatabaseHas('inquiries', [
            'property_id' => $property->id,
            'phone' => '0991234567',
            'message' => 'I would like to view this property.',
        ]);

        $this->post(route('properties.report', $property), [
            'type' => 'old',
            'details' => 'The listing may be out of date.',
        ])->assertRedirect();

        $this->assertDatabaseHas('reports', [
            'property_id' => $property->id,
            'type' => 'old',
            'details' => 'The listing may be out of date.',
        ]);
    }

    public function test_property_search_rejects_invalid_filters(): void
    {
        $this->getJson(route('properties.search', ['sort' => 'unsupported']))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('sort');
    }
}
