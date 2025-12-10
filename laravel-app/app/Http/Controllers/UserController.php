<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\UUser;
use App\Models\UGameHistory;
use App\Http\Resources\UserStatResource;

class UserController extends Controller
{
    public function stats($id)
    {
        $user = UUser::withCount('games as games_played')
            ->withSum('games as total_points', 'point')
            ->withAvg('games as avg_score', 'score')
            ->findOrFail($id);

        // 勝利数と順位の集計
        $wins = UGameHistory::where('u_user_id', $id)->where('rank', 1)->count();
        $avg_rank = UGameHistory::where('u_user_id', $id)->avg('rank');

        // 一時プロパティに追加
        $user->wins = $wins;
        $user->win_rate = $user->games_played ? ($wins / $user->games_played * 100) : 0;
        $user->avg_rank = $avg_rank;

        return new UserStatResource($user);
    }

    public function games($id)
    {
        $games = DB::table('u_game_history')
            ->join('u_table', 'u_game_history.u_table_id', '=', 'u_table.id')
            ->join('m_group', 'u_table.m_group_id', '=', 'm_group.id')
            ->where('u_game_history.u_user_id', $id)
            ->orderBy('u_game_history.played_at', 'desc')
            ->select(
                'u_game_history.id as game_id',
                'u_table.id as table_id',
                'm_group.name as group_name',
                'u_game_history.rank',
                'u_game_history.score',
                'u_game_history.point',
                'u_game_history.played_at'
            )
            ->paginate(10);

        return response()->json($games);
    }
}
