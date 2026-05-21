<?php

namespace Database\Factories;

use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ServiceCategory>
 */
class ServiceCategoryFactory extends Factory
{
    protected $model = ServiceCategory::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Plumbing', 'Electrical', 'Carpentry', 'Painting', 'Cleaning',
            'HVAC', 'Gardening', 'Appliance Repair',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.fake()->unique()->numerify('###'),
            'description' => fake()->optional()->sentence(12),
            'is_active' => true,
            'icon' => fake()->optional()->randomElement(['heroicon-o-wrench', 'heroicon-o-bolt', 'heroicon-o-home']),
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
