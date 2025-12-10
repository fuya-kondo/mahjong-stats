<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableUserSeeder extends Seeder
{
    public function run(): void
    {
        // =====================
        // Aリーグ（8人 → 40試合）
        // =====================
        $a_users = range(1, 8);
        $user_games = array_fill_keys($a_users, 0); // 出場回数をカウント

        for ($i = 1; $i <= 40; $i++) {
            // 出場回数が少ない順に並べて4人を選出
            $members = collect($a_users)
                ->sortBy(fn($u) => $user_games[$u])
                ->take(4)
                ->shuffle()
                ->toArray();

            foreach ($members as $user_id) {
                DB::table('u_table_user')->insert([
                    'u_table_id' => $i,
                    'u_user_id' => $user_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $user_games[$user_id]++; // 出場回数を増やす
            }
        }

        // =====================
        // Bリーグ（4人固定 → 20試合）
        // =====================
        $b_users = [9, 10, 11, 12];

        for ($i = 41; $i <= 60; $i++) {
            foreach ($b_users as $user_id) {
                DB::table('u_table_user')->insert([
                    'u_table_id' => $i,
                    'u_user_id' => $user_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
