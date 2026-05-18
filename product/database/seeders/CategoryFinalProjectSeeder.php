<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryFinalProject;

class CategoryFinalProjectSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Ebook', 'slug' => 'ebook'],
            ['name' => 'E-Article', 'slug' => 'e-article'],
            ['name' => 'CD', 'slug' => 'cd'],
            ['name' => 'Video', 'slug' => 'video'],
            ['name' => 'KTI', 'slug' => 'kti'],
        ];

        foreach ($data as $item) {
            CategoryFinalProject::updateOrCreate(
                ['name' => $item['name']], // patokan
                ['slug' => $item['slug']]
            );
        }
    }
}