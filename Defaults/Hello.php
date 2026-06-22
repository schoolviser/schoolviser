<?php

namespace Modules\Schoolviser\Defaults;

use App\Models\Company;
use App\Defaults\IndustryDefaults;

class Hello extends IndustryDefaults
{
    public static function industry(): string
    {
        return 'industry-key'; // e.g. school, hospital, farm
    }

    public function load(Company $company): void
    {
        // Insert your defaults here
    }
}