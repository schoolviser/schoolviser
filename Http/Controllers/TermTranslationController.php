<?php

namespace Modules\Schoolviser\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\TenantTranslationService;

class TermTranslationController extends Controller
{
    public function __construct()
    {
    }
    
    /**
     * Display a listing of the translations for a given locale.
     */
    public function index($locale)
    {
        $companyId = company()->id;

        $translations = DB::table('tenant_translations')
            ->where('company_id', $companyId)
            ->where('locale', $locale)
            ->pluck('value', 'key')
            ->toArray();

        return view('schoolviser::terms.translations.index', compact('translations', 'locale'));
    }

    /**
     * Store or update tenant translations.
     */
    public function store(Request $request)
    {
        $companyId = company()->id;
        $locale = $request->input('locale', app()->getLocale());

        foreach ($request->input('translations', []) as $key => $value) {
            TenantTranslationService::set($key, $value, $locale, $companyId);
        }

        TenantTranslationService::clearCache($companyId, $locale);

        return back()
            ->with('success', 'Translations updated successfully.');
    }
}