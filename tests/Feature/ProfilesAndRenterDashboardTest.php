<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfilesAndRenterDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    public function test_owner_can_update_profile_and_upload_documents(): void
    {
        Storage::fake('public');
        Storage::fake('local');
        $owner = User::factory()->create(['role' => 'owner']);

        $response = $this->actingAs($owner)->put(route('owner.profile.update'), [
            'name' => 'Updated Owner',
            'email' => $owner->email,
            'phone' => '0991234567',
            'location' => 'Damascus',
            'profile_image' => UploadedFile::fake()->image('owner.png'),
            'documents' => [UploadedFile::fake()->create('ownership.pdf', 20, 'application/pdf')],
        ]);

        $response->assertRedirect(route('owner.profile.edit'));
        $owner->refresh();
        $this->assertSame('Updated Owner', $owner->name);
        $this->assertSame('Damascus', $owner->location);
        $this->assertNotNull($owner->profile_image);
        $this->assertCount(1, $owner->profile_documents);
        Storage::disk('public')->assertExists($owner->profile_image);
        Storage::disk('local')->assertExists($owner->profile_documents[0]);

        $this->actingAs($owner)
            ->get(route('owner.profile.documents.download', ['document' => $owner->profile_documents[0]]))
            ->assertOk();

        $anotherOwner = User::factory()->create(['role' => 'owner']);
        $this->actingAs($anotherOwner)
            ->get(route('owner.profile.documents.download', ['document' => $owner->profile_documents[0]]))
            ->assertNotFound();
    }

    public function test_renter_can_update_contact_details_and_profile_image(): void
    {
        Storage::fake('public');
        $renter = User::factory()->create(['role' => 'renter']);

        $response = $this->actingAs($renter)->put(route('renter.profile.update'), [
            'name' => 'Updated Renter',
            'email' => 'updated-renter@example.test',
            'phone' => '0771234567',
            'location' => 'Jaramana',
            'profile_image' => UploadedFile::fake()->image('renter.png'),
        ]);

        $response->assertRedirect(route('renter.profile.edit'));
        $renter->refresh();
        $this->assertSame('Updated Renter', $renter->name);
        $this->assertSame('updated-renter@example.test', $renter->email);
        $this->assertSame('0771234567', $renter->phone);
        $this->assertSame('Jaramana', $renter->location);
        Storage::disk('public')->assertExists($renter->profile_image);
    }

    public function test_renter_can_submit_and_view_only_their_own_person_complaints(): void
    {
        $renter = User::factory()->create(['role' => 'tenant']);
        $otherRenter = User::factory()->create(['role' => 'renter']);
        $reportedProperty = Property::create([
            'user_id' => User::factory()->create(['role' => 'owner'])->id,
            'title' => 'Reported property',
            'description' => 'A property reported by this renter.',
            'city' => 'Damascus',
            'neighborhood' => 'Central',
            'purpose' => 'rent',
            'category' => 'residential',
            'price' => 500,
            'currency' => 'USD',
            'status' => 'published',
            'published_at' => now(),
        ]);
        Report::create([
            'reporter_id' => $renter->id,
            'subject_type' => 'owner',
            'subject_name' => 'My complaint',
            'type' => 'other',
            'details' => 'My complaint details.',
        ]);
        Report::create([
            'property_id' => $reportedProperty->id,
            'reporter_id' => $renter->id,
            'type' => 'old',
            'details' => 'This property is no longer available.',
        ]);
        Report::create([
            'reporter_id' => $otherRenter->id,
            'subject_type' => 'tenant',
            'subject_name' => 'Private complaint',
            'type' => 'other',
            'details' => 'This belongs to another renter.',
        ]);

        $this->actingAs($renter)
            ->get(route('renter.dashboard'))
            ->assertOk()
            ->assertSee('My complaint')
            ->assertSee('Reported property')
            ->assertDontSee('Private complaint');

        $response = $this->post(route('renter.complaints.store'), [
            'subject_type' => 'owner',
            'subject_name' => 'Reported owner',
            'subject_contact' => 'owner@example.test',
            'type' => 'fraud',
            'details' => 'The owner provided misleading information.',
        ]);

        $response->assertRedirect(route('renter.dashboard') . '#complaints');
        $this->assertDatabaseHas('reports', [
            'property_id' => null,
            'reporter_id' => $renter->id,
            'subject_type' => 'owner',
            'subject_name' => 'Reported owner',
            'type' => 'fraud',
            'status' => 'open',
        ]);
    }

    public function test_properties_page_and_search_api_show_eight_properties_per_page(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);

        for ($number = 1; $number <= 9; $number++) {
            Property::create([
                'user_id' => $owner->id,
                'title' => "Listing {$number}",
                'description' => 'A published test property.',
                'city' => 'Damascus',
                'neighborhood' => 'Central',
                'purpose' => 'rent',
                'category' => 'residential',
                'price' => 500,
                'currency' => 'USD',
                'status' => 'published',
                'published_at' => now(),
            ]);
        }

        $this->get(route('properties.index'))
            ->assertOk()
            ->assertSee('Listing 8', false)
            ->assertDontSee('Listing 9', false);

        $this->get(route('properties.search'))
            ->assertOk()
            ->assertJsonCount(8, 'data')
            ->assertJsonPath('total', 9)
            ->assertJsonPath('last_page', 2);
    }

    public function test_users_cannot_open_a_different_role_profile_or_complaint_dashboard(): void
    {
        $renter = User::factory()->create(['role' => 'renter']);

        $this->actingAs($renter)
            ->get(route('owner.profile.edit'))
            ->assertForbidden();

        $this->get(route('owner.dashboard'))
            ->assertForbidden();
    }
}
