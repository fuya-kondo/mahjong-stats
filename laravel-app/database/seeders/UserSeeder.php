<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => '管理者ユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Aリーグ（8人）
        $a_users = [
            1 => ['佐藤', '太郎'],
            2 => ['鈴木', '花子'],
            3 => ['高橋', '次郎'],
            4 => ['田中', '三郎'],
            5 => ['伊藤', '陽子'],
            6 => ['渡辺', '誠'],
            7 => ['山本', '健太'],
            8 => ['中村', '優子'],
        ];

        foreach ($a_users as $id => [$last, $first]) {
            DB::table('u_user')->insert([
                'id' => $id,
                'last_name' => $last,
                'first_name' => $first,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Bリーグ（4人）
        $b_users = [
            9  => ['松本', '大輔'],
            10 => ['小林', '麻衣'],
            11 => ['加藤', '和也'],
            12 => ['斎藤', '美咲'],
        ];

        foreach ($b_users as $id => [$last, $first]) {
            DB::table('u_user')->insert([
                'id' => $id,
                'last_name' => $last,
                'first_name' => $first,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
