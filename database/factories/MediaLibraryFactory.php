<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MediaLibraryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'conversions_disk' => $this->faker->word(),
            'model_type' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'custom_properties' => $this->faker->words(),
            'file_name' => $this->faker->name(),
            'mime_type' => $this->faker->word(),
            'uuid' => $this->faker->uuid(),
            'order_column' => $this->faker->randomNumber(),
            'updated_at' => Carbon::now(),
            'suspended_at' => Carbon::now(),
            'model_id' => $this->faker->randomNumber(),
            'manipulations' => $this->faker->words(),
            'generated_conversions' => $this->faker->words(),
            'collection_name' => $this->faker->name(),
            'responsive_images' => $this->faker->words(),
            'name' => $this->faker->name(),
            'disk' => $this->faker->word(),
            'size' => $this->faker->randomNumber(),
        ];
    }
}
