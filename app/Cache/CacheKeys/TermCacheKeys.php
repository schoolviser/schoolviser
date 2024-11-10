<?php

namespace App\Cache\CacheKeys;

use Delgont\Core\Cache\ModelCacheKeys;

class TermCacheKeys extends ModelCacheKeys
{
    const CURRENT_TERM = 'Term:Current';
    const PREVIOUS_TERM = 'Term:Previous';

}
