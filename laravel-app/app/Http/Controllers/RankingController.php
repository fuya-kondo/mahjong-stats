<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MGroup;
use App\Models\UUser;
use App\Models\UGameHistory;
use App\Models\UTable;

class RankingController extends Controller
{

    public function index($groupId, Request $request)
    {
        $sort = $request->get('sort', 'total_point'); // デフォルトはポイント順
        $order = $request->get('order', 'desc');

        $allowedSorts = ['total_point', 'average_rank', 'win_rate'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'total_point';
        }

        $rankings = DB::table('u_game_history')
        ->join('u_user', 'u_game_history.u_user_id', '=', 'u_user.id')
        ->join('u_table', 'u_game_history.u_table_id', '=', 'u_table.id')
        ->where('u_table.m_group_id', $groupId)
        ->select(
            'u_user.id as user_id',
            DB::raw("CONCAT(u_user.last_name, ' ', u_user.first_name) as user_name"),
            DB::raw('SUM(point) as total_point'),
            DB::raw('AVG(
                CASE
                    WHEN rank_position LIKE "%=%"
                        THEN CAST(SUBSTRING_INDEX(rank_position, "=", 1) AS UNSIGNED) + 0.5
                    ELSE CAST(rank_position AS UNSIGNED)
                END
            ) as average_rank'),
            DB::raw('SUM(
                CASE
                    WHEN SUBSTRING_INDEX(rank_position, "=", 1) = "1"
                        THEN 1
                    ELSE 0
                END
            ) / COUNT(*) as win_rate')
        )
        ->groupBy('u_user.id', 'u_user.last_name', 'u_user.first_name')
        ->get();

        return response()->json($rankings);
    }

}
