<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameHistorySeeder extends Seeder
{
    public function run(): void
    {
        $rules = DB::table('m_rule')->get()->keyBy('id');

        // =====================
        // Aリーグ（40試合）
        // =====================
        for ($table_id = 1; $table_id <= 40; $table_id++) {
            $this->seedTable($table_id, $rules[1]); // Mリーグルール
        }

        // =====================
        // Bリーグ（20試合）
        // =====================
        for ($table_id = 41; $table_id <= 60; $table_id++) {
            $this->seedTable($table_id, $rules[2]); // 最高位戦ルール
        }
    }

    private function seedTable(int $table_id, $rule): void
    {
        $members = DB::table('u_table_user')
            ->where('u_table_id', $table_id)
            ->pluck('u_user_id')
            ->toArray();

        $scores = $this->generateScores();
        $ranks = $this->generateRanks();

        foreach ($members as $i => $user_id) {
            $score = $scores[$i];
            $rank = $ranks[$i];

            // ===== UMA 計算（同着対応） =====
            $tieCount = array_count_values($ranks)[$rank];
            $uma = $this->calculateUma($rule, $rank, $tieCount);

            $point = (($score - $rule->end_score) / 1000) + $uma;

            DB::table('u_game_history')->insert([
                'u_table_id' => $table_id,
                'u_user_id' => $user_id,
                'game_no' => $table_id,
                'seat' => $i + 1,
                'rank_position' => $rank,
                'score' => $score,
                'point' => $point,
                'mistake_count' => rand(0, 1) < 0.05 ? 1 : 0,
                'played_at' => now()->subDays(60 - $table_id),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }
    }

    /**
     * 点数をランダム生成（合計10万）
     */
    private function generateScores(): array
    {
        $scores = [
            floor(rand(20000, 40000) / 100) * 100,
            floor(rand(20000, 40000) / 100) * 100,
            floor(rand(20000, 40000) / 100) * 100,
        ];

        $sum = array_sum($scores);
        $last = 100000 - $sum;

        $last = floor($last / 100) * 100;
        $diff = 100000 - ($sum + $last);
        $scores[0] += $diff;

        $scores[] = $last;

        return $scores;
    }

    /**
     * 順位をランダム生成（同着あり）
     */
    private function generateRanks(): array
    {
        $base = [1, 2, 3, 4];
        shuffle($base);

        // 5% の確率で同着を発生
        if (rand(1, 100) <= 5) {
            $tieType = rand(2, 4); // 同着人数（2〜4人）
            $rank = rand(1, 5 - $tieType); // 1〜 (5 - tieType)
            for ($i = 0; $i < $tieType; $i++) {
                $base[$i] = $rank;
            }
            sort($base); // 順位配列を整える
        }

        return $base;
    }

    /**
     * 同着対応 UMA 計算
     */
    private function calculateUma($rule, int $rank, int $tieCount): float
    {
        if ($tieCount > 1) {
            $umaSum = 0;
            for ($j = 0; $j < $tieCount; $j++) {
                $umaSum += $rule->{'uma_'.($rank + $j)};
            }
            return $umaSum / $tieCount;
        } else {
            return $rule->{'uma_'.$rank};
        }
    }
}
