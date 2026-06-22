<?php

namespace Modules\Schoolviser\Products;

use App\Products\SubscriableProduct;

class SchoolviserSubscriableProduct extends SubscriableProduct
{
    public string $name = 'schoolviser';

    public string $description = 'School management system for tertiary,primary & secondary institutions.';

    public array $features = [
        // Add default features here
    ];

    public function name(): string
    {
        return $this->name;
    }

    public function displayName(): string
    {
        return 'Schoolviser';
    }

    public function description(): string
    {
        return $this->description;
    }

    /**
     * Subscription plans configuration.
     *
     * @return array<string, array<string, mixed>>
     */
    public function plansConfig() : array
    {
        return [];

    }

    /**
     * Product features configuration.
     */
    public function featuresConfig() : array
    {
        return config('schoolviser.features', []);
    }
}