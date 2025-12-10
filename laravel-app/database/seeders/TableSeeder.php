<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        // Aリーグ: 40試合
        for ($i = 1; $i <= 40; $i++) {
            DB::table('u_table')->insert([
                'id' => $i,
                'm_group_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Bリーグ: 20試合
        for ($i = 41; $i <= 60; $i++) {
            DB::table('u_table')->insert([
                'id' => $i,
                'm_group_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
