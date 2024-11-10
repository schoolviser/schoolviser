<?php

namespace App\Repository;

use App\Models\Employee\Employee;
use Illuminate\Support\Facades\Cache;

class TeacherRepository
{

    const CACHE_PREFIX = 'Teachers';

    const TEACHERS_COUNT = self::CACHE_PREFIX.':Count';
    
    /**
     * Model object
     */
    protected $model;

    /**
     * Cache expiry time
     */
    protected $cacheExpiry = '1440';

    /**
     * Whether to get registrations from cache or from db
     */
    protected $fromCache = false;


    public function __construct()
    {
        $this->model = app(Employee::class)->teacher();
    }

      /**
     * Whether to get registrations from cache or from db
     */
    public function fromCache()
    {
        $this->fromCache = true;
        return $this;
    }


    public function count()
    {
        if($this->fromCache){
            $cachedData = Cache::get($this::TEACHERS_COUNT);
            if($cachedData){
                return $cachedData;
            }
            $dbData = $this->model->count();
            Cache::put($this::TEACHERS_COUNT, $dbData, now()->addMinutes($this->cacheExpiry));
            return $dbData;
        }
        return $this->model->count();
    }


    public static function clearCache()
    {
        Cache::forget(self::TEACHERS_COUNT);
    }
}
