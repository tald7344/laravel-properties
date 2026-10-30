<?php

namespace App\Services;

use App\Models\Language;

class LanguagesService {

    public function getActive(): mixed
    {
        return Language::where('is_active', true)->orderByDesc('is_default')->orderBy('name')->get();
    }

    public function getCurrentLanguage(): mixed
    {
        return $this->getActive()->firstWhere('code', app()->getLocale());
    }
}