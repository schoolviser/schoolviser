<?php
namespace App\Repository;


use App\Repository\Eloquent\BaseRepository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Cache;


use App\Hostel;

class HostelRepository extends BaseRepository
{

    public function __construct(Hostel $model){
        parent::__construct($model);
    }

    public function ofGender($gender)
    {
        if ($this->fromCache) {
            $cached = Cache::get( $this->getCachePrefix().':'.$gender );
            if ($cached) {
                return $cached;
            } else {
                $collection = $this->model->ofGender( $gender )->get();
                ($collection) ?  $this->storeCollectionInCache( $collection, $this->getCachePrefix().':'.$gender ) : '';
                return $collection;
            }
        }
        return $this->model->ofGender( $gender )->get();
    }
    
}