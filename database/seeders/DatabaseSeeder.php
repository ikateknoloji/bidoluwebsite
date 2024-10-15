<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        // Website türleri ile ilgili etiketler
        $tags = [
            'Tümü', // 1
            'E-ticaret', // 2
            'Randevu', // 3
            'STK Websiteleri', // 4
            'Avukatlık', // 5
            'Mimarlık', // 6
            'Kuaför', // 7
            'Portföy', // 8
            'Kurumsal', // 9
            'Eğitim', // 10
            'Sağlık', // 11
            'Restoran', // 12
            'Otel', // 13
            'Seyahat', // 14
            'Blog', // 15
        ];


        // Create Tags first
        foreach ($tags as $tagName) {
            Tag::create(['name' => $tagName]);
        }
        

        
        // Create Projects with Tags
        Project::factory(10)->create()->each(function ($project) use ($tags) {
            $projectTags = Tag::inRandomOrder()->take(rand(1, 4))->get();
            $projectTags->prepend(Tag::find(1)); // Otomatik olarak birinci etiketi ekle
            $project->tags()->attach($projectTags);
        });
        
    }
}