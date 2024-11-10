<?php

namespace App\Entities\Concerns;

use App\Scopes\DisposableScope;
use \Carbon\Carbon;

trait Disposable {

    public static function bootDisposable()
	{
        static::addGlobalScope(new DisposableScope);
	}

    public function dispose()
    {
        $this->{$this->getQualifiedDisposedOnColumn()} = Carbon::now();
        $this->save();
    }

    public function undispose()
    {
        $this->{$this->getQualifiedDisposedOnColumn()} = null;
        $this->save();
    }

    /**
     * Determine if the model instance has been disposed.
     *
     * @return bool
     */
    public function disposed()
    {
        return ! is_null($this->{$this->getDisposedOnColumn()});
    }

    /**
     * Get the fully qualified "disposed on" column.
     *
     * @return string
     */
    public function getQualifiedDisposedOnColumn()
    {
        return $this->getTable().'.'.$this->getDisposedOnColumn();
    }

    /**
     * Get the name of the "disposed" column.
     *
     * @return string
     */
    public function getDisposedOnColumn()
    {
        return defined('static::DISPOSED_ON') ? static::DISPOSED_ON : 'disposed_on';
    }

}
