<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

use App\HostelStudent;
use App\HostelRoom;

use App\Models\Building;
use App\Models\Room;

use Modules\Student\Entities\TermlyRegistration;

class Hostel extends Model
{
    //Get the buidling of the hostel
    public function building()
    {
        return $this->morphOne(Building::class, 'building');
    }

    //Get rooms in that hostel
    public function rooms()
    {
        return $this->hasManyThrough(Room::class, Building::class, 'building_id', 'building_id');
    }

    //Get the termly registrations
    public function termlyRegistrations()
    {
        return $this->hasMany(TermlyRegistration::class);
    }

    public function scopeOfGender($query, $gender)
    {
        return $query->whereGender($gender);
    }

    //Get hostels of male
    public function scopeForMale($query)
    {
        return $query->whereGender('male');
    }

    //Get hostels of male
    public function scopeForFemale($query)
    {
        return $query->whereGender('female');
    }


   
   
}
