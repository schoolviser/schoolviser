<?php
namespace App\Entities\Concerns;

use App\User;

trait HasCreatedBy {

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


}