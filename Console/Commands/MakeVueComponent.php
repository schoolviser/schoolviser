<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeVueComponent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:vue-component {name : The name of the Vue component with subdirectory (e.g., settings/terms/ComponentHere)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Vue component, optionally in a subdirectory';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');

        // Generate full file path
        $componentPath = resource_path("js/components/{$name}.vue");

        // Ensure the directory exists
        $directoryPath = dirname($componentPath);
        if (!File::isDirectory($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }

        // Check if the file already exists
        if (File::exists($componentPath)) {
            $this->error("The component {$name} already exists!");
            return Command::FAILURE;
        }

        // Create the Vue component file with a basic template
        File::put($componentPath, $this->getComponentTemplate(basename($name)));
        $this->info("Vue component {$name} created successfully!");

        return Command::SUCCESS;
    }

    /**
     * Get the basic template for the Vue component.
     *
     * @param string $name
     * @return string
     */
    protected function getComponentTemplate($name)
    {
        return <<<TEMPLATE
<template>
    <div>
        <h1>{$name} Component</h1>
    </div>
</template>

<script>
export default {
    name: '{$name}',
};
</script>

<style scoped>
</style>
TEMPLATE;
    }
}
