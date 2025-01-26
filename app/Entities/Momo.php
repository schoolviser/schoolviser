<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Momo extends Model
{
     // Specify the table name since it's not 'school_infos'
    protected $table = 'options';

    // If needed, specify fillable columns
    protected $fillable = ['key', 'value', 'group'];

    /**
     * The "booted" method of the model.
     * Apply the global scope to filter by 'group'.
     */
    protected static function booted()
    {
        static::addGlobalScope('mtnMomo', function (Builder $builder) {
            $builder->where('group', 'momo');
        });
    }

}
