<?php

namespace Modules\Schoolviser\Cache\CacheKeys;

use Delgont\Core\Cache\ModelCacheKeys;

class SubjectCacheKeys extends ModelCacheKeys
{
    const SUBJECTS_PAGINATED = 'paginated:subjects:';
    const OLEVEL_SUBJECTS_PAGINATED = 'paginated:olevel:sbjects:';
    const ALEVEL_SUBJECTS_PAGINATED = 'paginated:alevel:subjects:';

}
