<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('m_group')->insert([
            [
                'id' => 1,
                'name' => 'Aリーグ（Mリーグルール）',
                'm_rule_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Bリーグ（最高位戦ルール）',
                'm_rule_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
