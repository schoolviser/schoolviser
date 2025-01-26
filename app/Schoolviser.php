<?php

namespace App;

class Schoolviser
{
    public static $hello = false;

    public static function hello()
    {
        static::$hello = true;
    }

    public static function getHello()
    {
        return static::$hello;
    }
}
