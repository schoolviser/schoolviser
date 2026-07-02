<?php
namespace Modules\Schoolviser\Services;

use Delgont\Core\Services\ModelService;

use Modules\Schoolviser\Entities\CourseGroup;
use Modules\Schoolviser\Cache\CacheKeys\CourseGroupCacheKeys as CacheKeys;
use App\Traits\Repositories\EnsureCompanyIsSet;
use Illuminate\Database\Eloquent\Model;

class CourseGroupService extends ModelService
{
    use EnsureCompanyIsSet;

    protected $cacheExpiry = '1440'; // Example: cache expiry in minutes
    protected $fromCache = false;    // Example: toggle to read from cache

    public function __construct(CourseGroup $model)
    {
        parent::__construct($model);
    }

    public function create(array $data) : CourseGroup
    {
        $this->ensureCompanyIsSet();
        // Always enforce company_id from the service context
        $data['company_id'] = $this->companyId;

        $this->run('before', 'create', $data);

        $group = $this->model->create($data);

        $this->run('after', 'create', $group);

        return $group;
    }

    public function update(Model $model, array $data): CourseGroup
    {
        $this->ensureCompanyIsSet();

        // enforce company context
        $data['company_id'] = $this->companyId;

        $this->run('before', 'update', $model, $data);

        // update returns boolean, so call on the instance
        $model->update($data);

        $this->run('after', 'update', $model, $data);

        return $model; // will be a CourseGroup instance
    }

    
    
}
