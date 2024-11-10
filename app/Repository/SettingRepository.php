<?php
namespace App\Repository;


use App\Repository\Eloquent\BaseRepository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Cache;

use App\Models\Setting;

class SettingRepository extends BaseRepository
{
    protected $cacheKeyPrefix = 'setting';

    public function __construct(Setting $model){
        parent::__construct($model);
    }

    //Get setting value
    public function value($key, $modelObject, $default = null)
    {

        if($this->fromCache){
            $cached = Cache::get($this->cacheKeyPrefix.':'.$modelObject->id.':'.get_class($modelObject).':'.$key);
            if ($cached) {
                # code...
                $models = $this->model::hydrate([$cached]);
                $model = $models[0] ?? null;
                return ($model) ? $model->value : $default;
            } else {
                # code...
                $setting = $this->model->ofKey($key)->ofModel($modelObject)->first() ?? ($default) ? $this->model::firstOrCreate(['key' => $key], ['key' => $key, 'value' => $default, 'model_id' => $modelObject->id, 'model_type' => get_class($modelObject)]) : $default;
                ($setting) ?  $this->storeModelInCache( $setting, $this->cacheKeyPrefix.':'.$modelObject->id.':'.get_class($modelObject).':'.$key ) : '';
                return ($setting) ? $setting->value : $default;
            }
            
        }
        
        $setting = $this->model->ofKey($key)->ofModel($modelObject)->first();

        return ($setting) ? $setting->value : $default;
    }


    /**
     * Get general settings options
     */

     public function getGeneralSettings()
     {
        if ($this->fromCache) {
            $cached = Cache::get('general_settings');
            if($cached){
                return $cached;
            }
            $data = $this->model->generalSettings()->get();
            $this->storeCollectionInCache($data, 'general_settings');
            return $data;
        }
        return $this->model->generalSettings()->get();
     }

     /**
      * Get option of specific key
      */
      public function ofKey( $key, $identifier = null )
      {
        if ($this->fromCache) {
            $cached = Cache::get( $key );
            if ($cached) {
                $models = $this->model::hydrate([$cached]);
                return $model = $models[0] ?? null;
            } else {
                $data = $this->model->ofKey( $key )->first();
                ($data) ?  $this->storeModelInCache( $data, $key ) : '';
                return $data;
            }
        }
        return $this->model->ofKey( $key )->first();
      }
    
}