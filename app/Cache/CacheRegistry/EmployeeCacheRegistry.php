<?php

namespace App\Cache\CacheRegistry;

use Illuminate\Database\Eloquent\Model;

class EmployeeCacheRegistry extends BaseCacheRegistry
{
    const EMPLOYEES = 'employees:all';
    const EMPLOYEE_NAMES = "employee:names";


    public static function clearEmployeesFromCache()
    {
        $this->clearFromCache(self::EMPLOYEES);
    }
    
}
