<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('m_rule')->insert([
            [
                'id' => 1,
                'name' => 'Mリーグルール',
                'start_score' => 25000,
                'end_score' => 30000,
                'uma_1' => 50, 'uma_2' => 10, 'uma_3' => -10, 'uma_4' => -30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => '最高位戦ルール',
                'start_score' => 25000,
                'end_score' => 30000,
                'uma_1' => 30, 'uma_2' => 10, 'uma_3' => -10, 'uma_4' => -30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
