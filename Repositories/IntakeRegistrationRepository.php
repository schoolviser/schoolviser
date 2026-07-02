<?php

namespace Modules\Schoolviser\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use Modules\Schoolviser\Entities\IntakeRegistration;
use Modules\Schoolviser\Cache\CacheKeys\IntakeRegistrationCacheKeys as CacheKeys;
use App\Traits\Repositories\EnsureCompanyIsSet;

class IntakeRegistrationRepository extends BaseRepository
{
    use EnsureCompanyIsSet;

    protected $cacheExpiry = '1440';
    protected $fromCache = false;

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

    public function __construct(IntakeRegistration $model)
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
     * Get intake reistration
     */
    public function getIntakeRegistration($id)
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::INTAKE_REGISTRATION . $this->companyId.':'.$id;

        return $this->cachedForever($cacheKey, function() use ($id){
            return $this->model::whereCompanyId($this->companyId)->where('uuid', $id)->firstOrFail();
        });
    }

    public function getPaginatedIntakeRegistrations($intakeId, $perPage = 15, $page = 1, $attributes = ['*'])
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::PAGINATED_INTAKE_REGISTRATIONS 
        . CacheKeys::appendCacheSuffix(true, $this->companyId,$intakeId) 
        . CacheKeys::appendPaginationCacheSuffix($perPage, $page);

        return $this->cached($cacheKey, function() use ($intakeId, $perPage, $page, $attributes){
            return $this->model->whereHas('term', function($q) use ($intakeId){
                $q->whereId($intakeId);
            })->orderBy('created_at', 'desc')->with(['student' => function($studentQuery){
                $studentQuery->with(['course','yearGroup', 'courseGroup']);
            }])->paginate($perPage, $attributes, 'page', $page);
        });
    }

    /**
     * Get the termly registrations with the student info
     */

    public function getCurrentPaginatedRegistrations($perPage = 1015, $page = 1, $attributes = ['*'])
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::CURRENT_PAGINATED_REGISTRATIONS . CacheKeys::appendCacheSuffix(true, $this->companyId) . CacheKeys::paginatedCacheSuffix($perPage, $page);

        return $this->cached($cacheKey, function() use ($perPage, $page) {
            return $this->model->current()->whereCompanyId($this->companyId)->orderBy('created_at', 'desc')->with(['student' => function($studentQuery){
                $studentQuery->with(['course','yearGroup', 'courseGroup']);
            }])->paginate($perPage);
        });
    }

    public function getPreviousPaginatedRegistrations()
    {
        return $this->cached(CacheKeys::PREVIOUS_REGISTRATIONS, function () {
            return $this->model->previous()
                ->orderBy('created_at', 'desc')
                ->with([
                    'student' => function ($studentQuery) {
                        $studentQuery->with(['course', 'yearGroup', 'courseGroup']);
                    }
                ])
                ->paginate(20);
        });
    }



    public function getGenderBasedRegistrations($gender, $term = null)
    {
        if($term){
            return $this->cached('ggg', function() use ($term, $gender){
                return $this->model->whereTermId($term->id)->orderBy('created_at', 'desc')->with(['student' => function($studentQuery){
                    $studentQuery->with(['course','yearGroup', 'courseGroup']);
                }])->paginate(20);
            });
        }

        return $this->cached('ddd', function() use ($gender){
            return $this->model->current()->orderBy('created_at', 'desc')->with(['student' => function($studentQuery) use ($gender){
                $studentQuery->whereGender($gender)->with(['course','yearGroup', 'courseGroup']);
            }])->paginate(20);
        });
    }

    public function getRegistrationsWithNullStudent()
    {
        return $this->model->whereNull('student_id')->get(); // Returns all registrations with no associated student
    }


     /**
     * Get total registrations
     *
     * :current:count
     */
    public function getTotalRegistrations()
    {
        if($this->previous){
            return $this->cached(CacheKeys::TOTAL_PREVIOUS_REGISTRATIONS, function(){
                return $this->model->previous()->count();
            });
        }

        return $this->cached(CacheKeys::TOTAL_CURRENT_REGISTRATIONS, function(){
            return $this->model->current()->count();
        });
    }



}
