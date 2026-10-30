<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(Request $r, Language $language)
    {
        abort_unless($language->is_active, 404);
        session(['locale' => $language->code]);
        return redirect()->back();
    }
}
