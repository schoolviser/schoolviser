<?php

namespace App\Concerns;

/**
 * Observers
 */
use App\Observers\FeeObserver;
use App\Observers\FeeDiscountObserver;
use App\Observers\FeePaymentObserver;
use App\Observers\UserObserver;
use App\Observers\PermissionObserver;
use App\Observers\RequirementObserver;
use App\Observers\TermObserver;
use App\Observers\ClazzObserver;

/**
 * Models
 */
use App\User;
use App\Models\Fee\Fee;

use App\Models\Fee\FeeDiscount;
use App\Models\Fee\FeePayment;
use Delgont\Armor\Models\Permission;
use App\Models\Requirement\Requirement;

use App\Entities\Term;
use App\Entities\Clazz;


trait BootObservers
{
    private function bootObservers() : void
    {
        //FeeDiscount::observe(FeeDiscountObserver::class);
        //FeePayment::observe(FeePaymentObserver::class);
        //Fee::observe(FeeObserver::class);
        //Requirement::observe(RequirementObserver::class);


        User::observe(UserObserver::class);
        Permission::observe(PermissionObserver::class);

        Term::observe(TermObserver::class);
        Clazz::observe(ClazzObserver::class);
    }
}