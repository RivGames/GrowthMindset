<?php

namespace Modules\Category\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Inspirational',
            'Love',
            'Life',
            'Success',
            'Wisdom and Knowledge',
            'Humorous',
            'Friendship',
            'Family',
            'Motivational',
            'Leadership',
            'Sugar',
        ];
        array_map(function ($category) {
            DB::table('categories')->insert([
                'name' => $category,
            ]);
        }, $categories);
    }
}
