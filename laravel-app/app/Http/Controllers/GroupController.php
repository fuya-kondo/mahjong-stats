<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function stats($id)
    {
        $stats = DB::table('u_game_history')
            ->join('u_user', 'u_game_history.u_user_id', '=', 'u_user.id')
            ->join('u_table', 'u_game_history.u_table_id', '=', 'u_table.id')
            ->where('u_table.m_group_id', $id)
            ->groupBy('u_user.id', 'u_user.last_name', 'u_user.first_name')
            ->selectRaw('
                u_user.id as user_id,
                u_user.last_name,
                u_user.first_name,
                COUNT(*) as games,
                AVG(rank) as avg_rank,
                AVG(score) as avg_score,
                AVG(point) as avg_point,
                SUM(CASE WHEN rank = 1 THEN 1 ELSE 0 END) as win_count,
                SUM(CASE WHEN rank = 4 THEN 1 ELSE 0 END) as last_count
            ')
            ->get();

        // 成績加工
        $stats = $stats->map(function ($s) {
            $s->win_rate = $s->games > 0 ? round($s->win_count / $s->games * 100, 2) : 0;
            $s->last_rate = $s->games > 0 ? round($s->last_count / $s->games * 100, 2) : 0;
            $s->avg_rank = round($s->avg_rank, 2);
            $s->avg_score = round($s->avg_score, 1);
            $s->avg_point = round($s->avg_point, 1);
            return $s;
        });

        // 順位（平均ポイントでソート）
        $sorted = $stats->sortByDesc('avg_point')->values();

        return response()->json($sorted);
    }
}
