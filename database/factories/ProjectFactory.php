<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Genişlik ve yükseklik değerleri
        $imageWidth = 300;
        $imageHeight = 252;

        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'image_url' => "https://picsum.photos/{$imageWidth}/{$imageHeight}", // Lorem Picsum URL'si
            'image_width' => $imageWidth,
            'image_height' => $imageHeight,
            'image_alt_text' => $this->faker->sentence(5),
            'image_caption' => $this->faker->sentence(7),
            'redirect_url' => $this->faker->url(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}