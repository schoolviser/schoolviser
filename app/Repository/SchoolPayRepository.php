<?php

namespace App\Repository;

use App\Models\TermlyRegistration;

class SchoolPayRepository
{
    /**
     * Whether to get the data from cache or not
     */
    protected $fromCache = false;

    /**
     * Registration object
     */
    protected $registration;

    /**
     * The term
     */
    protected $term;

    public function __construct()
    {
        $this->registration = app(TermlyRegistration::class);
    }

    public function ofRegistration()
    {
        return $this;
    }

    /**
     * Get students with no pay codes
    */
    public function getRegistrationsWithNoPayCodes()
    {

    }

    /**
     * Get school pay transactions
     */
    public function getTransactions()
    {

    }

}
