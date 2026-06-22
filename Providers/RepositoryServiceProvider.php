<?php
namespace Modules\Schoolviser\Providers;

use Illuminate\Support\ServiceProvider;

use App\Traits\InfersModelFromRepoTrait;

class RepositoryServiceProvider extends ServiceProvider
{
    use InfersModelFromRepoTrait;

    protected $defer = true;

    protected $modelPath = 'Modules\\Schoolviser\\Entities';

    public function register()
    {
        $map = config('schoolviser.model_repositories', []);

        foreach ($map as $key => $class) {
            $this->app->singleton($key, function ($app) use ($class) {
                $modelClass = $this->inferModelFromRepo($class);
                return new $class(new $modelClass());
            });
        }
    }

    public function provides()
    {
        return array_keys(config('schoolviser.model_repositories', []));
    }
    
}
