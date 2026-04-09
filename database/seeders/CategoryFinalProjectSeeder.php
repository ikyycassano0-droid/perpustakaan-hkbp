<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryFinalProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = ['ebook', 'e-article', 'cd', 'video', 'kti'];

        foreach ($data as $item) {
            \App\Models\CategoryFinalProject::firstOrCreate([
                'name' => $item
            ]);
        }
    }
}
