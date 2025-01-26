<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class OperationLogger
{
    public static function log($message, $type = 'info')
    {
        switch ($type) {
            case 'info':
                Log::info($message);
                break;
            case 'warning':
                Log::warning($message);
                break;
            case 'error':
                Log::error($message);
                break;
            default:
                Log::info($message);
                break;
        }
    }
}
