<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\LegalPage;
use App\Models\LegalPageTranslation;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LegalPageController extends Controller
{
    private function admin(): void
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);
    }

    public function index()
    {
        $this->admin();
        $pages = LegalPage::with('translations.language')
            ->orderBy('sort_order')
            ->orderBy('slug')
            ->paginate(20);
        $activeLanguageCount = Language::where('is_active', true)->count();

        return view('admin.legal-pages.index', compact('pages', 'activeLanguageCount'));
    }

    public function create()
    {
        $this->admin();
        $languages = Language::where('is_active', true)->orderBy('name')->get();

        return view('admin.legal-pages.form', ['page' => null, 'languages' => $languages]);
    }

    public function store(Request $request)
    {
        $this->admin();
        $languages = Language::where('is_active', true)->get();
        $data = $request->validate($this->rules($languages));

        DB::transaction(function () use ($data, $languages): void {
            $page = LegalPage::create([
                'slug' => $data['slug'],
                'is_published' => (bool) ($data['is_published'] ?? false),
                'sort_order' => $data['sort_order'] ?? 0,
            ]);

            $this->saveTranslations($page, $data['translations'], $languages);
        });

        return redirect()->route('admin.legal-pages.index')->with('success', __('legal.admin.created'));
    }

    public function edit(LegalPage $legalPage)
    {
        $this->admin();
        $page = $legalPage->load('translations');
        $languages = Language::where('is_active', true)->orderBy('name')->get();

        return view('admin.legal-pages.form', compact('page', 'languages'));
    }

    public function update(Request $request, LegalPage $legalPage)
    {
        $this->admin();
        $languages = Language::where('is_active', true)->get();
        $data = $request->validate($this->rules($languages, $legalPage));

        DB::transaction(function () use ($legalPage, $data, $languages): void {
            $legalPage->update([
                'slug' => $data['slug'],
                'is_published' => (bool) ($data['is_published'] ?? false),
                'sort_order' => $data['sort_order'] ?? 0,
            ]);

            $this->saveTranslations($legalPage, $data['translations'], $languages);
        });

        return redirect()->route('admin.legal-pages.index')->with('success', __('legal.admin.updated'));
    }

    public function destroy(LegalPage $legalPage)
    {
        $this->admin();
        $legalPage->delete();

        return redirect()->route('admin.legal-pages.index')->with('success', __('legal.admin.deleted'));
    }

    public function show(string $slug, SettingsService $settings)
    {
        $page = LegalPage::with('translations.language')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $translation = $page->translations->first(
            fn (LegalPageTranslation $item) => $item->language?->code === app()->getLocale()
        );

        if (! $translation) {
            $defaultLocale = $settings->value('default_language', 'ar');
            $translation = $page->translations->first(
                fn (LegalPageTranslation $item) => $item->language?->code === $defaultLocale
            );
        }

        abort_unless($translation, 404);

        return view('legal.show', [
            'page' => $page,
            'translation' => $translation,
            'title' => $translation->title,
        ]);
    }

    private function rules($languages, ?LegalPage $page = null): array
    {
        $rules = [
            'slug' => ['required', 'alpha_dash', 'max:120', \Illuminate\Validation\Rule::unique('legal_pages', 'slug')->ignore($page?->id)],
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0|max:65535',
            'translations' => 'required|array',
        ];

        foreach ($languages as $language) {
            $rules["translations.{$language->id}.title"] = 'required|string|max:255';
            $rules["translations.{$language->id}.content"] = 'required|string|max:50000';
        }

        return $rules;
    }

    private function saveTranslations(LegalPage $page, array $translations, $languages): void
    {
        foreach ($languages as $language) {
            $page->translations()->updateOrCreate(
                ['language_id' => $language->id],
                [
                    'title' => $translations[$language->id]['title'],
                    'content' => $translations[$language->id]['content'],
                ]
            );
        }
    }
}
