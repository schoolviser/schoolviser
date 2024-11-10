<?php

namespace App\Repository;

use App\Models\TermlyRegistration;
use App\Cache\CacheRegistry\TermlyRegistrationCacheRegistry;
use Illuminate\Support\Facades\Cache;

use App\Repository\Eloquent\BaseRepository;


class TermlyRegistrationRepository extends BaseRepository
{
    /**
     * When working this repository always call current, previous geting any data
     */

     /**
     * wheather to get the current registrations by default the current will be got.
     *
     * @var array
     */
    protected $current = true;

    protected $previous = false;

    /**
     * Term form which your geting the registrations
     */
    protected $term;


    public function __construct(TermlyRegistration $model)
    {
        parent::__construct($model);
        $this->cachePrefix = $this->model::$cachePrefix;
    }


    /**
     * Get current term registrations
     */
    public function current()
    {
        $this->current = true;
        $this->model->current();
        return $this;
    }

    /**
     * Get previous term registrations
     */
    public function previous()
    {
        $this->previous = true;
        $this->model->previous();
        return $this;
    }

    /**
     * Get Registrations of specific clazz
     */
    public function ofClazz($clazz)
    {
        $this->registration->ofClazz($clazz);
        return $this;
    }

    /**
     * Get all the students
     */
    public function get( array $attributes = ['*'] )
    {
        return $this->registration->with(['student'])->get();
    }

    /**
     * Count the number of registrations
     * 
     * :current:count
     */
    public function count()
    {
        $cacheKey = ($this->previous) ? $this->getCachePrefix().':Previous:Count' : $this->getCachePrefix().':Current:Count';
        
        if($this->fromCache){
            $cachedData = Cache::get($cacheKey);
            if($cachedData){
                return $cachedData;
            }
            $dbData = $this->model->count();
            Cache::put($cacheKey, $dbData, now()->addMinutes($this->cacheExpiry));
            return $dbData;
        }
        return $this->model->count();
    }

    /**
     * Get Current Term Registrations
     * @param array $relations
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getCurrentRegistrations() : Collection
    {
        return 'hello';
    }


    /**
     * Clear current term cached registrations
     */
    public static function clearCurrentCache()
    {
        $instance = new self();
        $instance->term = term();
        Cache::forget($instance->cacheRegistry::TOTAL_REGISTRATIONS_CACHE_KEY.$instance->term->id);
    }
    
}
