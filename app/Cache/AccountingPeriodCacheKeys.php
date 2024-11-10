<?php

namespace App\Cache;

use Illuminate\Database\Eloquent\Model;
use Delgont\Core\Cache\ModelCacheKeys;


class AccountingPeriodCacheKeys extends ModelCacheKeys
{

    const CACHE_PREFIX = 'period';
    const PERIODS_CACHE_KEY = 'periods';
    const CURRENT_PERIOD_CACHE_KEY = 'period:current';
    const PREVIOUS_PERIOD_CACHE_KEY = 'period:previous';
    const NEXT_PERIOD_CACHE_KEY = 'next:previous';

}
