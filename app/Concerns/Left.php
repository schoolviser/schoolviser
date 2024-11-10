<?php

namespace App\Concerns;

use App\Scopes\LeftScope;
use \Carbon\Carbon;

trait Left {

    public static function bootLeft()
	{
        static::addGlobalScope(new LeftScope);
	}

    public function markAsLeft($date = null)
    {
        $this->{$this->getQualifiedLeftOnColumn()} = $date ?? Carbon::now();
        $this->save();
    }

    public function unMarkAsLeft()
    {
        $this->{$this->getQualifiedLeftOnColumn()} = null;
        $this->save();
    }

    /**
     * Determine if the model instance has been archived.
     *
     * @return bool
     */
    public function left()
    {
        return ! is_null($this->{$this->getLeftOnColumn()});
    }

    /**
     * Get the fully qualified "archived at" column.
     *
     * @return string
     */
    public function getQualifiedLeftOnColumn()
    {
        return $this->getTable().'.'.$this->getLeftOnColumn();
    }

    /**
     * Get the name of the "archived at" column.
     *
     * @return string
     */
    public function getLeftOnColumn()
    {
        return defined('static::LEFT_ON') ? static::LEFT_ON : 'left_on';
    }

}
