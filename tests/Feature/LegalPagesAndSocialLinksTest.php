<?php

namespace Tests\Feature;

use App\Models\Language;
use App\Models\LegalPage;
use App\Models\LegalPageTranslation;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LegalPagesAndSocialLinksTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    public function test_admin_can_create_a_published_legal_page_in_all_active_languages(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $arabic = Language::create([
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

        $response = $this->actingAs($admin)->post(route('admin.legal-pages.store'), [
            'slug' => 'privacy-test',
            'sort_order' => 3,
            'is_published' => '1',
            'translations' => [
                $arabic->id => ['title' => 'سياسة الخصوصية', 'content' => 'نص عربي.'],
                $english->id => ['title' => 'Privacy Policy', 'content' => 'English content.'],
            ],
        ]);

        $response->assertRedirect(route('admin.legal-pages.index'));
        $this->assertDatabaseHas('legal_pages', ['slug' => 'privacy-test', 'is_published' => true]);
        $page = LegalPage::where('slug', 'privacy-test')->firstOrFail();
        $this->assertSame(2, $page->translations()->count());

        $this->get(route('legal.show', 'privacy-test'))
            ->assertOk()
            ->assertSee('نص عربي.');

        $this->withSession(['locale' => 'en'])
            ->get(route('legal.show', 'privacy-test'))
            ->assertOk()
            ->assertSee('English content.');
    }

    public function test_legal_pages_require_each_active_language_translation_and_are_hidden_until_published(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $arabic = Language::create([
            'code' => 'ar',
            'name' => 'Arabic',
            'native_name' => 'العربية',
            'direction' => 'rtl',
            'is_active' => true,
            'is_default' => true,
        ]);
        Language::create([
            'code' => 'en',
            'name' => 'English',
            'native_name' => 'English',
            'direction' => 'ltr',
            'is_active' => true,
            'is_default' => false,
        ]);

        $this->actingAs($admin)->from(route('admin.legal-pages.create'))
            ->post(route('admin.legal-pages.store'), [
                'slug' => 'missing-translation',
                'translations' => [
                    $arabic->id => ['title' => 'عنوان', 'content' => 'محتوى'],
                ],
            ])
            ->assertSessionHasErrors("translations.".Language::where('code', 'en')->value('id').".title");

        $page = LegalPage::create(['slug' => 'draft-legal-page', 'is_published' => false]);
        LegalPageTranslation::create([
            'legal_page_id' => $page->id,
            'language_id' => $arabic->id,
            'title' => 'مسودة',
            'content' => 'محتوى المسودة',
        ]);

        $this->get(route('legal.show', $page->slug))->assertNotFound();
    }

    public function test_admin_can_edit_and_delete_legal_pages(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $language = Language::create([
            'code' => 'ar',
            'name' => 'Arabic',
            'native_name' => 'العربية',
            'direction' => 'rtl',
            'is_active' => true,
            'is_default' => true,
        ]);
        $page = LegalPage::create(['slug' => 'editable-policy', 'is_published' => false]);
        LegalPageTranslation::create([
            'legal_page_id' => $page->id,
            'language_id' => $language->id,
            'title' => 'عنوان قديم',
            'content' => 'محتوى قديم.',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.legal-pages.edit', $page))
            ->assertOk()
            ->assertSee('محتوى قديم.');

        $this->put(route('admin.legal-pages.update', $page), [
            'slug' => 'updated-policy',
            'sort_order' => 7,
            'is_published' => '1',
            'translations' => [
                $language->id => ['title' => 'عنوان محدث', 'content' => 'محتوى محدث.'],
            ],
        ])->assertRedirect(route('admin.legal-pages.index'));

        $this->assertDatabaseHas('legal_pages', ['id' => $page->id, 'slug' => 'updated-policy', 'is_published' => true]);
        $this->assertDatabaseHas('legal_page_translations', [
            'legal_page_id' => $page->id,
            'language_id' => $language->id,
            'title' => 'عنوان محدث',
        ]);

        $this->delete(route('admin.legal-pages.destroy', $page))
            ->assertRedirect(route('admin.legal-pages.index'));
        $this->assertDatabaseMissing('legal_pages', ['id' => $page->id]);
        $this->assertDatabaseMissing('legal_page_translations', ['legal_page_id' => $page->id]);
    }

    public function test_legal_pages_fall_back_to_the_default_language_when_a_translation_is_missing(): void
    {
        $arabic = Language::create([
            'code' => 'ar',
            'name' => 'Arabic',
            'native_name' => 'العربية',
            'direction' => 'rtl',
            'is_active' => true,
            'is_default' => true,
        ]);
        Language::create([
            'code' => 'fr',
            'name' => 'French',
            'native_name' => 'Français',
            'direction' => 'ltr',
            'is_active' => true,
            'is_default' => false,
        ]);
        $page = LegalPage::create(['slug' => 'translated-later', 'is_published' => true]);
        LegalPageTranslation::create([
            'legal_page_id' => $page->id,
            'language_id' => $arabic->id,
            'title' => 'معلومات قانونية',
            'content' => 'المحتوى باللغة الافتراضية.',
        ]);

        $this->withSession(['locale' => 'fr'])
            ->get(route('legal.show', $page->slug))
            ->assertOk()
            ->assertSee('المحتوى باللغة الافتراضية.');
    }

    public function test_legal_page_seeder_creates_default_translations_without_overwriting_admin_edits(): void
    {
        $arabic = Language::create([
            'code' => 'ar',
            'name' => 'Arabic',
            'native_name' => 'العربية',
            'direction' => 'rtl',
            'is_active' => true,
            'is_default' => true,
        ]);
        Language::create([
            'code' => 'en',
            'name' => 'English',
            'native_name' => 'English',
            'direction' => 'ltr',
            'is_active' => true,
            'is_default' => false,
        ]);

        $this->seed(\Database\Seeders\LegalPageSeeder::class);
        $this->assertSame(6, LegalPage::count());
        $page = LegalPage::where('slug', 'terms-of-use')->firstOrFail();
        $this->assertSame(2, $page->translations()->count());
        $page->translations()->where('language_id', $arabic->id)->update(['content' => 'Admin-edited terms.']);

        $this->seed(\Database\Seeders\LegalPageSeeder::class);

        $this->assertDatabaseHas('legal_page_translations', [
            'legal_page_id' => $page->id,
            'language_id' => $arabic->id,
            'content' => 'Admin-edited terms.',
        ]);
    }

    public function test_admin_can_manage_social_links_and_they_are_rendered_in_the_three_column_footer(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $language = Language::create([
            'code' => 'ar',
            'name' => 'Arabic',
            'native_name' => 'العربية',
            'direction' => 'rtl',
            'is_active' => true,
            'is_default' => true,
        ]);
        $page = LegalPage::create(['slug' => 'terms-test', 'is_published' => true]);
        LegalPageTranslation::create([
            'legal_page_id' => $page->id,
            'language_id' => $language->id,
            'title' => 'الشروط والأحكام',
            'content' => 'محتوى الشروط.',
        ]);

        $this->actingAs($admin)->post(route('admin.settings.update'), [
            'default_language' => 'ar',
            'website_name' => 'دارك',
            'premium_monthly_price_per_property' => 3,
            'default_currency' => 'USD',
            'social_links' => [
                ['name' => 'Instagram', 'url' => 'https://instagram.com/dark'],
                ['name' => 'Facebook', 'url' => 'https://facebook.com/dark'],
            ],
        ])->assertRedirect();

        $setting = Setting::where('key', 'social_links')->firstOrFail();
        $this->assertSame('json', $setting->type);
        $this->assertCount(2, json_decode($setting->value, true));
        $this->actingAs($admin)
            ->get(route('admin.settings.index'))
            ->assertOk()
            ->assertSee('Instagram')
            ->assertSee('https://instagram.com/dark');

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('الشروط والأحكام')
            ->assertSee('Instagram')
            ->assertSee('https://instagram.com/dark')
            ->assertSee('تابعنا');
    }

    public function test_only_administrators_can_manage_legal_pages(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'renter']))
            ->get(route('admin.legal-pages.index'))
            ->assertForbidden();
    }
}
