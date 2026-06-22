<?php

namespace Modules\Schoolviser\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Cache;

use Modules\Schoolviser\Entities\SemesterRegistration;

use Modules\Schoolviser\Cache\TermlyRegistrationCacheKeys;


class SemesterRegistrationRepository extends BaseRepository
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

    protected $semester;

    /**
     * Term form which your geting the registrations
     */
    protected $term;


    public function __construct(SemesterRegistration $model)
    {
        parent::__construct($model);
        $this->cachePrefix = "SemesterRegistration";
    }


    public function setSemester($semester){
        $this->semester = $semester;
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
     * Get all the students
     */
    public function get( array $attributes = ['*'] )
    {
        return $this->registration->with(['student'])->get();
    }

    /**
     * Get the termly registrations with the student info
     */

    public function getRegistrations()
    {
        if($this->previous){
            return $this->cached(TermlyRegistrationCacheKeys::PREVIOUS_REGISTRATIONS, function(){
                return $this->model->previous()->with(['student' => function($studentQuery){
                    $studentQuery->with('course');
                }])->get();
            });
        }
        
        return $this->cached(TermlyRegistrationCacheKeys::CURRENT_REGISTRATIONS, function(){
            return $this->model->current()->with(['student' => function($studentQuery){
                $studentQuery->with('course');
            }])->get();
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
            return $this->model->current()->with(['student'])->get();
        });
    }


}
