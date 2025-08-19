<?php

namespace App\Cache\CacheKeys;

use Delgont\Core\Cache\ModelCacheKeys;

class TermCacheKeys extends ModelCacheKeys
{
    const TERMS = 'Terms:All';
    const ACTIVE_TERMS = 'Active:Terms';
    const TERM = 'Term:';
    const CURRENT_TERM = 'Term:Current';
    const PREVIOUS_TERM = 'Term:Previous';

}
