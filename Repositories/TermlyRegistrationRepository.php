<?php

namespace Modules\Schoolviser\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Cache;


use Modules\Schoolviser\Cache\CacheKeys\TermlyRegistrationCacheKeys as CacheKeys;
use App\Traits\Repositories\EnsureCompanyIsSet;

# Models
use Modules\Schoolviser\Entities\TermlyRegistration;
use Modules\Schoolviser\Entities\Term;
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

    public function getPaginatedRegistrations($termOrTermId, $perpage, $page, $attributes = ['*'])
    {
        $this->ensureCompanyIsSet();
        
        $termId = ($termOrTermId instanceof Term) ? $termOrTermId->id : $termOrTermId;

        $cacheKey = CacheKeys::TERM_REGISTRATIONS_PAGINATED . CacheKeys::appendCacheSuffix(true, $this->companyId, $termId) . CacheKeys::appendPaginationCacheSuffix($perpage, $page);

        $paginated = $this->cached($cacheKey, function() use($termId, $perpage, $page){
            return $this->model::whereCompanyId($this->companyId)->whereTermId($termId)->orderBy('created_at', 'desc')->with(['clazz','student', 'stream'])->paginate($perpage, ['*'], 'page', $page);
        });
        return $this->transformPaginatedRegistrations($paginated, true);
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

    protected function transformPaginatedRegistrations($paginated, $withClazz = true)
    {
        $collection = $paginated->getCollection()->transform(function ($item) use ($withClazz) {
            return new Any([
                'id'            => $item->student->id,
                'uuid'          => $item->student->uuid,
                'photo'         => $item->student->photo,
                'first_name'    => $item->student->first_name,
                'last_name'     => $item->student->last_name,
                'regno'         => $item->student->regno,
                'access_number' => $item->student->access_number,
                'gender'        => $item->student->gender,
                'course'        => $item->student->course,
                'nin'           => $item->student->nin,
                'nationality'   => $item->student->nationality,
                'registration'  => new Any([
                    'id'               => $item->id,
                    'uuid'             => $item->uuid,
                    'residence'        => $item->residence,
                    'new_or_continuing'=> $item->new_or_continuing,
                    'meta'             => $item->meta,
                ]),
                'clazz' => $withClazz ? new Any([
                    'id'   => $item->clazz->id,
                    'uuid' => $item->clazz->uuid,
                    'name' => $item->clazz->name,
                    'code' => $item->clazz->code,
                ]) : null,
                'stream' => new Any([
                    'id' => $item->stream->id,
                    'name' => $item->stream->name,
                    'clazz_id' => $item->stream->clazz_id,
                ])
            ]);
        });

        return $paginated->setCollection($collection);
    }

    
}
