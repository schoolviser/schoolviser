<?php

namespace App;

use App\StaffPosition;

use Illuminate\Database\Eloquent\Model;

use App\DepartmentMember;

class Staff extends Model
{
    //
    protected $table = 'staff';


    /**
     * 
     */
    public function getFullNameAttribute()
    {
       return ucwords("{$this->first_name} {$this->last_name}");
    }





    /**
     * Get only married staff memebers
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMarried($query)
    {
        return $query->whereMaritalStatus('married');
    }

    /**
     * Get only divorced staff memebers
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDivorced($query)
    {
        return $query->whereMaritalStatus('divorced');
    }

    /**
     * Get only male staff memebers
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMale($query)
    {
        return $query->whereGender('male');
    }

     /**
     * Get only female staff memebers
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFemale($query)
    {
        return $query->whereGender('female');
    }

    /**
     * Get the position to which the staff member belongs to
     */
    public function position()
    {
        return $this->belongsTo(StaffPosition::class, 'staff_position_id');
    }

     /**
     * Get the departments to which the staff member belongs to
     */
    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }
    
}
