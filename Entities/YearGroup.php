<?php

namespace Modules\Schoolviser\Entities;

use Illuminate\Database\Eloquent\Model;


use Delgont\Core\Concerns\ModelHasMeta;

class YearGroup extends Model
{
    use ModelHasMeta;

    protected $fillable = [];


    public function students()
    {
        return $this->hasMany(Student::class);
    }
    
}
