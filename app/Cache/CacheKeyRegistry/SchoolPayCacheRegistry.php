<?php

namespace App\Cache\CacheKeyRegistry;

class SchoolPayCacheRegistry
{
    
    const CACHE_PREFIX = "SchoolPay";
    const TRANSACTIONS_CACHE_KEY = "SchoolPay:Transactions";

    const CURRENT_TRANSACTIONS_CACHE_KEY = "SchoolPay:Transactions:Current";

    const REGISTRATIONS_WITH_NO_PAY_CODES = "SchoolPay:Registrations:withNoPayCodes";
}
