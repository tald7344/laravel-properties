<?php

namespace Tests\Feature;

use App\Models\Language;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyDetailsPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_property_details_show_a_responsive_detail_page_and_active_language_options(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
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
}
