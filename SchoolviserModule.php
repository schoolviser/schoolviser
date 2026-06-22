<?php

namespace Modules\Schoolviser;

use App\DelxeroModule;

class SchoolviserModule extends DelxeroModule
{
    protected string $name = 'Schoolviser';
    protected string $key = 'schoolviser_module';
    protected ?string $description = 'Describe your module here...';

    // Schoolviser is and must be used as a product in delxero engine
    protected string $mode = 'product';

    public function features(): array
    {
        return [
            [
                'name' => 'Example Feature',
                'key' => 'example_feature',
                'description' => 'This is an example feature.',
                'allowed_values' => [true, false],
            ],
            //Max of students per term/intake
            [
                'name' => 'Max Students Per Term/Intake',
                'key' => 'max_students_per_term',
                'description' => 'This limits the number of students allowed per term or intake.',
                'value_type' => 'string'
            ],
        ];
    }

    public function assets(): array
    {
        return [
            'Resources/dist' => '/',
            'Resources/assets/media' => 'media',
        ];
    }

    /**
     * Define bootstrap commands that must run when
     * `php artisan delxero:bootstrap` is executed.
     *
     */
    public function bootstrapCommands(): array
    {
        return [
            'schoolviser:bootstrap'
        ];
    }

    public function allowedModules(): array
    {
        return [
            'DelxeroHr',
            'DelxeroX'
        ];
    }



}
