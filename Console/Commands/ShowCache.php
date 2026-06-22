<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ShowCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:show {key : The cache key to retrieve} {--format=array : The format to display (array or model)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve and display cache data based on the provided key and format';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $key = $this->argument('key');
        $format = $this->option('format');

        // Retrieve the cached value
        $cache = Cache::get($key);

        if (is_null($cache)) {
            $this->error("Cache with key '{$key}' does not exist.");
            return 1;
        }

        if ($format === 'array') {
            // Display as array
            $this->info('Displaying cache as array:');
            $this->line(print_r($cache, true));
        } elseif ($format === 'model' && is_array($cache)) {
            // Attempt to cast array to model (assuming model class is stored in array with a "model" key)
            $modelClass = $cache['model'] ?? null;

            if ($modelClass && class_exists($modelClass)) {
                try {
                    $model = new $modelClass($cache);
                    $this->info('Displaying cache as model:');
                    $this->line($model->toJson(JSON_PRETTY_PRINT));
                } catch (\Exception $e) {
                    $this->error("Failed to cast cache to model: {$e->getMessage()}");
                }
            } else {
                $this->error('Cache cannot be displayed as a model. Ensure the "model" key is present in the cache data.');
            }
        } else {
            $this->error("Invalid format specified. Use 'array' or 'model'.");
        }

        return 0;
    }
}
