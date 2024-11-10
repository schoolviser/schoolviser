<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Modules\Student\Entities\Student;
use App\StudentPerent;

class Perent extends Model
{
    //

        /**
     * Get all of the groups of student
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_perent')->using(StudentPerent::class);
    }
}
