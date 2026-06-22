<?php

use Modules\Schoolviser\Repositories\TermRepository;
use Modules\Schoolviser\Repositories\ClazzRepository;

//Get the current term detials
if(!function_exists('term')){
    function term($id = null){
        return ($id) ? app(TermRepository::class)->company(auth()->user()->default_company_id)->fromCache()->getTerm($id) : app(TermRepository::class)->company(auth()->user()->default_company_id)->fromCache()->getCurrentTerm();
    }
}

//Get the current term detials
if(!function_exists('clazzes')){
    function clazzes(){
        return app(ClazzRepository::class)->company(company()->id)->getClazzes();
    }
}


//Get the current term detials
if(!function_exists('active_terms')){
    function active_terms(){
        return app(TermRepository::class)->company(auth()->user()->default_company_id)->getActiveTerms();
    }
}

if (!function_exists('termLabel')) {
    /**
     * Translate a term number into a human-readable label.
     *
     * @param  int    $term
     * @param  string|null $fallback
     * @return string
     */
    function termLabel(int $term, $fallback = null)
    {
        switch ($term) {
            case 1:
                return tenantTrans('schoolviser::terms.one');
            case 2:
                return tenantTrans('schoolviser::terms.two');
            case 3:
                return tenantTrans('schoolviser::terms.three');
            default:
                return $fallback ?? 'Term '.$term;
        }
    }
}







