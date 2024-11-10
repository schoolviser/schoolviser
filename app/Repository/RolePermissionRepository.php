<?php
namespace App\Repository;


use App\Repository\Eloquent\BaseRepository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Cache;
use Delgont\Auth\Models\Role;

class RolePermissionRepository extends BaseRepository
{
    protected $role_id;

    public function __construct(Role $model){
        parent::__construct($model);
    }

    public function role($id)
    {
        $this->role_id = $id;
        return $this;
    }

    public function permissions()
    {
        if($this->role_id){
            if ($this->fromCache) {
                $cached = Cache::get( 'role:'.$this->role_id.':permissions' );
                if ($cached) {
                    return $cached;
                }else{
                    $role = $this->model->whereId($this->role_id)->with(['permissions'])->first();
                    ($role->permissions) ? $this->storeCollectionInCache($role->permissions, 'role:'.$this->role_id.':permissions') : '';
                    return collect($role->permissions);
                }
            }
            $role = $this->model->whereId($this->role_id)->with(['permissions'])->first();
            return collect($role->permissions);
            
        }
        return null;
    }

    public function hasPermission()
    {

    }

    
}