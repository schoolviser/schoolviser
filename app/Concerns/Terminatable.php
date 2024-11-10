<?php

namespace App\Concerns;

use \Carbon\Carbon;

trait Terminatable {

    public function terminate($type = 'left', $reason = null)
    {
        $this->{$this->getQualifiedTerminatedOnColumn()} = Carbon::now();
        $this->save();
        $this->termination()->create([
            'year' => option('current_year'),
            'term' => option('current_term'),
            'type' => $type,
            'reason' => $reason
        ]);
    }

    public function expel($reason = null)
    {
        $this->{$this->getQualifiedTerminatedOnColumn()} = Carbon::now();
        $this->save();
        $this->termination()->create([
            'year' => option('current_year'),
            'term' => option('current_term'),
            'type' => 'expelled',
            'reason' => $reason
        ]);
    }

    public function unterminate()
    {
        $this->{$this->getQualifiedTerminatedOnColumn()} = null;
        $this->save();
        $this->termination()->delete();
    }

    public function unexpel()
    {
        $this->{$this->getQualifiedTerminatedOnColumn()} = null;
        $this->save();
        $this->termination()->delete();
    }

    /**
     * Determine if the model instance has been TERMINATED.
     *
     * @return bool
     */
    public function terminated()
    {
        return ! is_null($this->{$this->getTerminatedOnColumn()});
    }

    /**
     * Get the fully qualified "archived at" column.
     *
     * @return string
     */
    public function getQualifiedTerminatedOnColumn()
    {
        return $this->getTable().'.'.$this->getTerminatedOnColumn();
    }

    /**
     * Get the name of the "terminated on" column.
     *
     * @return string
     */
    public function getTerminatedOnColumn()
    {
        return defined('static::TERMINATED_ON') ? static::TERMINATED_ON : 'terminated_on';
    }

}
