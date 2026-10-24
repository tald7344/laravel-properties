<?php

namespace Tests\Feature;

use App\Models\Language;
use App\Models\User;
use App\Support\TranslationFileManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminLanguageTranslationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_adding_and_renaming_a_language_provisions_all_english_page_files_without_overwriting_edits(): void
    {
        $this->withoutMiddleware(ValidateCsrfToken::class);

        $temporaryLanguageDirectory = storage_path('framework/testing/lang-'.Str::uuid());
        File::ensureDirectoryExists($temporaryLanguageDirectory);
        File::copyDirectory(lang_path('en'), $temporaryLanguageDirectory.DIRECTORY_SEPARATOR.'en');
        $this->app->instance(
            TranslationFileManager::class,
            new TranslationFileManager($temporaryLanguageDirectory)
        );

        try {
            $admin = User::factory()->create(['role' => 'admin']);

            $this->actingAs($admin)
                ->post(route('admin.languages.store'), [
                    'code' => 'sp',
                    'name' => 'Spanish',
                    'native_name' => 'Español',
                    'direction' => 'ltr',
                    'is_active' => '1',
                ])
                ->assertRedirect(route('admin.languages.index'));

            $this->assertDatabaseHas('languages', ['code' => 'sp', 'native_name' => 'Español']);
            $sourceFiles = collect(File::files($temporaryLanguageDirectory.DIRECTORY_SEPARATOR.'en'))
                ->map(fn ($file) => $file->getFilename())
                ->sort()
                ->values();
            $localeFiles = collect(File::files($temporaryLanguageDirectory.DIRECTORY_SEPARATOR.'sp'))
                ->map(fn ($file) => $file->getFilename())
                ->sort()
                ->values();
            $this->assertSame($sourceFiles->all(), $localeFiles->all());
            $this->assertSame(
                File::get($temporaryLanguageDirectory.DIRECTORY_SEPARATOR.'en'.DIRECTORY_SEPARATOR.'home.php'),
                File::get($temporaryLanguageDirectory.DIRECTORY_SEPARATOR.'sp'.DIRECTORY_SEPARATOR.'home.php')
            );

            File::put($temporaryLanguageDirectory.DIRECTORY_SEPARATOR.'sp'.DIRECTORY_SEPARATOR.'home.php', "<?php return ['hero_title' => 'Translated copy'];");
            $language = Language::where('code', 'sp')->firstOrFail();

            $this->actingAs($admin)
                ->put(route('admin.languages.update', $language), [
                    'code' => 'zz',
                    'name' => 'Spanish',
                    'native_name' => 'Español',
                    'direction' => 'ltr',
                    'is_active' => '1',
                ])
                ->assertSessionHasNoErrors()
                ->assertRedirect(route('admin.languages.index'));

            $this->assertDatabaseHas('languages', ['id' => $language->id, 'code' => 'zz']);
            $this->assertFileExists($temporaryLanguageDirectory.DIRECTORY_SEPARATOR.'zz'.DIRECTORY_SEPARATOR.'home.php');
            $this->assertSame(
                "<?php return ['hero_title' => 'Translated copy'];",
                File::get($temporaryLanguageDirectory.DIRECTORY_SEPARATOR.'sp'.DIRECTORY_SEPARATOR.'home.php')
            );
            $this->assertSame(
                File::get($temporaryLanguageDirectory.DIRECTORY_SEPARATOR.'en'.DIRECTORY_SEPARATOR.'home.php'),
                File::get($temporaryLanguageDirectory.DIRECTORY_SEPARATOR.'zz'.DIRECTORY_SEPARATOR.'home.php')
            );

            $this->actingAs($admin)
                ->get(route('admin.settings.index'))
                ->assertOk()
                ->assertSee('Español');
        } finally {
            File::deleteDirectory($temporaryLanguageDirectory);
        }
    }
}
