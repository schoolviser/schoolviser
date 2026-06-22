<?php

namespace Modules\Schoolviser\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Cache;

use Modules\Schoolviser\Entities\TermlyRegistration;

use Modules\Schoolviser\Cache\CacheKeys\TermlyRegistrationCacheKeys as CacheKeys;
use App\Traits\Repositories\EnsureCompanyIsSet;
use Delgont\Core\Entities\Any;


class TermlyRegistrationRepository extends BaseRepository
{
    use EnsureCompanyIsSet;

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
    }


    /**
     * Get current term registrations
     */
    public function current()
    {
        $this->current = true;
        return $this;
    }

    /**
     * Get previous term registrations
     */
    public function previous()
    {
        $this->previous = true;
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

    public function getRegistration($registration_id)
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::REGISTRATION.$registration_id;

        return $this->cachedForever($cacheKey, function() use($registration_id){
            return $this->model::whereCompanyId($this->companyId)->whereId($registration_id)->firstOrfail();
        });

    }

    
    /**
     * Get the termly registrations with the student info
     */

    public function getPaginatedRegistrations($term_id, $perpage, $page, $attributes = ['*'])
    {
        $this->ensureCompanyIsSet();

        /*if($this->previous){
            return $this->cached(TermlyRegistrationCacheKeys::PREVIOUS_REGISTRATIONS, function(){
                return $this->model->previous()->with(['clazz','student'])->get();
            });
        }*/
        
        $cacheKey = CacheKeys::PAGINATED_REGISTRATIONS.$this->companyId.':'.$term_id.':'.CacheKeys::paginatedCacheSuffix($perpage, $page);

        return $this->cached($cacheKey, function() use($term_id, $perpage, $page){
            return $this->model::whereCompanyId($this->companyId)->whereTermId($term_id)->orderBy('created_at', 'desc')->with(['clazz','student'])->paginate($perpage, ['*'], 'page', $page);
        });
        
    }

   

    /**
     * Get total registrations
     * 
     * :current:count
     */
    public function getTotalRegistrations()
    {
        if($this->previous){
            return $this->cached(TermlyRegistrationCacheKeys::TOTAL_PREVIOUS_REGISTRATIONS, function(){
                return $this->model->previous()->count();
            });
        }
        
        return $this->cached(TermlyRegistrationCacheKeys::TOTAL_CURRENT_REGISTRATIONS, function(){
            return $this->model->current()->count();
        });
    }

    /**
     * Get Current Term Registrations
     * @param array $relations
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getCurrentRegistrations() : Collection
    {
        return $this->cached(TermlyRegistrationCacheKeys::CURRENT_REGISTRATIONS, function(){
            return $this->model->current()->with(['clazz','student'])->get();
        });
    }

    
}
