<?php

namespace Tests\Feature;

use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Tests\TestCase;

class OwnerComplaintsTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_submit_a_complaint_about_another_person(): void
    {
        $this->withoutMiddleware(ValidateCsrfToken::class);
        $owner = User::factory()->create(['role' => 'owner']);

        $response = $this->actingAs($owner)->post(route('owner.complaints.store'), [
            '_token' => csrf_token(),
            'subject_type' => 'tenant',
            'subject_name' => 'Example renter',
            'subject_contact' => 'example@example.test',
            'type' => 'fraud',
            'details' => 'The renter provided misleading information.',
        ]);

        $response->assertRedirect(route('owner.dashboard'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reports', [
            'property_id' => null,
            'reporter_id' => $owner->id,
            'subject_type' => 'tenant',
            'subject_name' => 'Example renter',
            'subject_contact' => 'example@example.test',
            'type' => 'fraud',
            'status' => 'open',
        ]);
    }

    public function test_owner_dashboard_lists_only_complaints_submitted_by_that_owner(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $otherOwner = User::factory()->create(['role' => 'owner']);

        Report::create([
            'reporter_id' => $owner->id,
            'subject_type' => 'owner',
            'subject_name' => 'Visible complaint',
            'type' => 'other',
            'details' => 'This complaint belongs to the signed-in owner.',
        ]);
        Report::create([
            'reporter_id' => $otherOwner->id,
            'subject_type' => 'tenant',
            'subject_name' => 'Private complaint',
            'type' => 'other',
            'details' => 'This complaint belongs to another owner.',
        ]);

        $this->actingAs($owner)
            ->get(route('owner.dashboard'))
            ->assertOk()
            ->assertSee('Visible complaint')
            ->assertDontSee('Private complaint');
    }
}
