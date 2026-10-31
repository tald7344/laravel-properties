<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Tests\TestCase;

class PropertyFavoritesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    public function test_guests_cannot_save_favorites(): void
    {
        $property = $this->publishedProperty();

        $this->putJson(route('properties.favorite.store', $property))
            ->assertUnauthorized();

        $this->assertDatabaseMissing('favorites', ['property_id' => $property->id]);
    }

    public function test_all_authenticated_roles_can_save_and_remove_favorites(): void
    {
        $property = $this->publishedProperty();

        foreach (['tenant', 'renter', 'owner', 'admin'] as $role) {
            $user = User::factory()->create(['role' => $role]);

            $this->actingAs($user)
                ->putJson(route('properties.favorite.store', $property))
                ->assertOk()
                ->assertJson(['favorited' => true]);

            $this->assertDatabaseHas('favorites', [
                'user_id' => $user->id,
                'property_id' => $property->id,
            ]);

            $this->putJson(route('properties.favorite.store', $property))->assertOk();
            $this->assertSame(1, $user->favoriteProperties()->count());

            $this->getJson(route('properties.search'))
                ->assertOk()
                ->assertJsonPath('data.0.is_favorite', true);

            $this->get(route('properties.index'))
                ->assertOk()
                ->assertSee('&quot;is_favorite&quot;:true', false);

            $this->deleteJson(route('properties.favorite.destroy', $property))
                ->assertOk()
                ->assertJson(['favorited' => false]);

            $this->assertDatabaseMissing('favorites', [
                'user_id' => $user->id,
                'property_id' => $property->id,
            ]);
        }
    }

    private function publishedProperty(): Property
    {
        $owner = User::factory()->create(['role' => 'owner']);

        return Property::create([
            'user_id' => $owner->id,
            'title' => 'Favorite test home',
            'description' => 'A property used to test favorites.',
            'city' => 'Damascus',
            'neighborhood' => 'Central',
            'purpose' => 'rent',
            'category' => 'residential',
            'price' => 450,
            'currency' => 'USD',
            'status' => 'published',
            'published_at' => now(),
        ]);
    }
}
