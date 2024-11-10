<?php

namespace App\Observers;

use App\Models\Requirement\Requirement;
use App\Models\TermlyRegistration;



class RequirementObserver
{
    public function created(Requirement $requirement)
    {
        $clazz_id = $requirement->clazz_id;
        $gender = $requirement->gender;
        
        //Apply fees to student termly registration depending on term, new_or_continuing, clazz
        $termlyRegistrations = TermlyRegistration::where([
            'term_id' => $requirement->term_id,
            'new_or_continuing' => $requirement->new_or_continuing,
            'residence' => $requirement->residence,
        ])->whereHas('clazz', function($clazzQuery) use($clazz_id){
            $clazzQuery->whereId($clazz_id);
        })->whereHas('student', function($studentQuery) use($gender){
            $studentQuery->whereGender($gender);
        })->get();

        foreach ($termlyRegistrations as $registration) {
            $registration->requirements()->attach($requirement);
        }
    }

    public function updated(Requirement $requirement)
    {
        $clazz_id = $requirement->clazz_id;
        $gender = $requirement->gender;
        
        //Apply fees to student termly registration depending on term, new_or_continuing, clazz
        $termlyRegistrations = TermlyRegistration::where([
            'term_id' => $requirement->term_id,
            'new_or_continuing' => $requirement->new_or_continuing,
            'residence' => $requirement->residence,
        ])->whereHas('clazz', function($clazzQuery) use($clazz_id){
            $clazzQuery->whereId($clazz_id);
        })->whereHas('student', function($studentQuery) use($gender){
            $studentQuery->whereGender($gender);
        })->get();

        foreach ($termlyRegistrations as $registration) {
            $registration->requirements()->attach($requirement);
        }
    }
}
