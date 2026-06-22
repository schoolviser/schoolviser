<?php

namespace Modules\Schoolviser\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Traits\PathNamespace;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

use Modules\Schoolviser\Http\Middleware\CheckCurrentAcademicYearMiddleware;
use Modules\Schoolviser\Http\Middleware\EnsureTenantCanManageClassesMiddleware;
use Modules\Schoolviser\Http\Middleware\TertiarySchoolMiddleware;
use Modules\Schoolviser\Http\Middleware\SecondarySchoolMiddleware;
use Modules\Schoolviser\Http\Middleware\TermMiddleware;

use Illuminate\Contracts\Http\Kernel;

use App\Delxero;

class SchoolviserServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string $name = 'Schoolviser';

    protected string $nameLower = 'schoolviser';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        require_once base_path('Modules/Schoolviser/Helpers/helpers.php');

        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->name, 'Database/migrations'));
        $this->loadTranslationsFrom(module_path($this->name, 'Resources/lang'), 'schoolviser');
        
        $this->bootBladeDirectives();

        $this->bootPermissionRegistrars();

        Delxero::registerModules([
            'schoolviser_module' => \Modules\Schoolviser\SchoolviserModule::class,
        ]);

        # Normal Layouts
        Delxero::registerMenus('dashboard', [
            'manage_students_tertiary' => 'schoolviser::layouts.dashboard.menus._tertiary_students_menuitems',
            'manage_students' => 'schoolviser::layouts.dashboard.menus._students_menuitems'
        ]);
        Delxero::registerAppbarMenus('dashboard', [
            'settings' => 'schoolviser::layouts.dashboard.menus.appbar._settings_appbar_menuitems'
        ]);

        # Sidebar Layouts
        Delxero::registerSidebarMenusTop('dashboard', [
            'manage_students' => 'schoolviser::layouts.dashboard.menus._tertiary_students_menuitems'
        ]);

    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);

        // Register middleware alias
        $router = $this->app['router'];

        $router->aliasMiddleware('current.academic.year', CheckCurrentAcademicYearMiddleware::class);
        $router->aliasMiddleware('current.term', TermMiddleware::class);
        
        $router->aliasMiddleware('is.primaryOrSecondarySchool', EnsureTenantCanManageClassesMiddleware::class);
        $router->aliasMiddleware('tertiary', TertiarySchoolMiddleware::class);
        $router->aliasMiddleware('secondary', SecondarySchoolMiddleware::class);

    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        $this->commands([
            \Modules\Schoolviser\Console\GenerateStudentAccessNumbers::class,
            \Modules\Schoolviser\Console\Commands\SyncCoursesCommand::class,
            \Modules\Schoolviser\Console\SyncCourseEnrollmentStatsCommand::class,

            \Modules\Schoolviser\Console\SchoolviserBootstrapCommand::class,
            \Modules\Schoolviser\Console\SchoolviserBootstrapBrandingCommand::class,
        ]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/'.$this->nameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->nameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->name, 'lang'), $this->nameLower);
            $this->loadJsonTranslationsFrom(module_path($this->name, 'lang'));
        }
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $configPath = module_path($this->name, config('modules.paths.generator.config.path'));

        if (is_dir($configPath)) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($configPath));

            foreach ($iterator as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $config = str_replace($configPath.DIRECTORY_SEPARATOR, '', $file->getPathname());
                    $config_key = str_replace([DIRECTORY_SEPARATOR, '.php'], ['.', ''], $config);
                    $segments = explode('.', $this->nameLower.'.'.$config_key);

                    // Remove duplicated adjacent segments
                    $normalized = [];
                    foreach ($segments as $segment) {
                        if (end($normalized) !== $segment) {
                            $normalized[] = $segment;
                        }
                    }

                    $key = ($config === 'config.php') ? $this->nameLower : implode('.', $normalized);

                    $this->publishes([$file->getPathname() => config_path($config)], 'config');
                    $this->merge_config_from($file->getPathname(), $key);
                }
            }
        }
    }

    /**
     * Merge config from the given path recursively.
     */
    protected function merge_config_from(string $path, string $key): void
    {
        $existing = config($key, []);
        $module_config = require $path;

        config([$key => array_replace_recursive($existing, $module_config)]);
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/'.$this->nameLower);
        $sourcePath = module_path($this->name, 'Resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->nameLower.'-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->nameLower);

        Blade::componentNamespace(config('modules.namespace').'\\' . $this->name . '\\View\\Components', $this->nameLower);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path.'/modules/'.$this->nameLower)) {
                $paths[] = $path.'/modules/'.$this->nameLower;
            }
        }

        return $paths;
    }


    private function bootPermissionRegistrars()
    {
        \Delgont\Armor\Armor::registerPermissionRegistrars([
            \Modules\Schoolviser\StudentPermissionRegistrar::class,
        ]);
    }

    private function bootBladeDirectives()
    {
        Blade::if('tertiarySchool', function () {
            $schoolType = \App\Services\TenantSettingsService::getKeyed('school_type', null, 'schoolviser_setup');
            return strtolower($schoolType) === 'tertiary';
        });

        Blade::if('primarySchool', function () {
            $schoolType = \App\Services\TenantSettingsService::getKeyed('school_type', null, 'schoolviser_setup');
            return strtolower($schoolType) === 'primary';
        });

        Blade::if('secondarySchool', function () {
            $schoolType = \App\Services\TenantSettingsService::getKeyed('school_type', null, 'schoolviser_setup');
            return strtolower($schoolType) === 'secondary';
        });

        // Tertiary directive
        Blade::if('tertiary', function () {
            $company = company();
            return $company && $company->school_type === 'tertiary';
        });

        // Primary directive
        Blade::if('primary', function () {
            $company = company();
            return $company && $company->school_type === 'primary';
        });

        // Secondary directive
        Blade::if('secondary', function () {
            $company = company();
            return $company && $company->school_type === 'secondary';
        });

    }
}
