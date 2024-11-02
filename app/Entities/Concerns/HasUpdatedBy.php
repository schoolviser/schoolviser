<?php
namespace App\Entities\Concerns;

use App\User;

trait HasUpdatedBy {

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


}