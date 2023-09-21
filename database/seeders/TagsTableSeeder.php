<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tags')->insert([
            [
                'name' => 'B2C Product',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'B2B Product',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
