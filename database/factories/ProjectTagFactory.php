<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 */
class ProjectTagFactory extends Factory
{

    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Website türleri ile ilgili etiketler
        $tags = [
            'E-ticaret',
            'STK Websiteleri',
            'Avukatlık',
            'Blog',
            'Portföy',
            'Küçük İşletme',
            'Kurumsal',
            'Eğitim',
            'Sağlık',
            'Restoran',
            'Otel',
            'Seyahat',
            'Yazılım Hizmetleri',
            'Spor Kulübü',
            'Kütüphane',
        ];

        return [
            'name' => $this->faker->randomElement($tags),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}