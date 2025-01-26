<?php

namespace App\Momo;

abstract class MomoCallback
{
    /**
     * Handle success callback.
     *
     * @param array $data
     * @return void
     */
    abstract public static function onSuccess(array $data);

    /**
     * Handle failure callback.
     *
     * @param array $data
     * @return void
     */
    abstract public static function onFail(array $data);
}
