<?php

namespace Modules\Schoolviser\Repositories;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use Modules\Schoolviser\Entities\Subject;
use Modules\Schoolviser\Cache\CacheKeys\SubjectCacheKeys;
use App\Traits\Repositories\EnsureCompanyIsSet;

class SubjectRepository extends BaseRepository
{
    use EnsureCompanyIsSet;

    protected $cacheExpiry = '1440';
    protected $fromCache = false;

    public function __construct(Subject $model)
    {
        parent::__construct($model);
    }

    public function getPaginatedSubjects($perpage, $page, $attributes = ['*'])
    {
        $this->ensureCompanyIsSet();

        $cacheKey = SubjectCacheKeys::SUBJECTS_PAGINATED . SubjectCacheKeys::appendCacheSuffix(true, $this->companyId);

        return $this->cached($cacheKey, function() use ($perpage, $page, $attributes){
            return $this->model::whereCompanyId($this->companyId)->with(['papers'])->paginate($perpage, $attributes, 'page', $page);
        });
    }
   
}
