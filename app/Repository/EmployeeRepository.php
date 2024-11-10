<?php

namespace App\Repository;

use App\Models\Employee\Employee;
use App\Cache\CacheRegistry\EmployeeCacheRegistry;

use Illuminate\Support\Facades\Cache;

class EmployeeRepository
{
    protected $cacheExpiry = '1440';

    /**
     * Mode CacheRegistry
     */
    protected $cacheRegistry;

    protected $fromCache = false;


    public function __construct(){
        $this->cacheRegistry = app(EmployeeCacheRegistry::class);
    }

    public function fromCache()
    {
        $this->fromCache = true;
        return $this;
    }
    

    public function getNames()
    {
        if($this->fromCache){
            $names = Cache::get($this->cacheRegistry::EMPLOYEE_NAMES);
            if($names){
                return $names;
            }
            $names = $names = Employee::get(['id', 'first_name', 'last_name'])->mapWithKeys(function($item, $key){
                return [$item->id => $item->first_name.' '.$item->last_name];
            });
            Cache::put($this->cacheRegistry::EMPLOYEE_NAMES, $names, now()->addMinutes($this->cacheExpiry));
            return $names;
        }
        return $names = Employee::get(['id', 'first_name', 'last_name'])->mapWithKeys(function($item, $key){
            return [$item->id => $item->first_name.' '.$item->last_name];
        });
    }
}
