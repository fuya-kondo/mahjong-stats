<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UGameHistory;

class GameApiController extends Controller
{
    public function index()
    {
        $games = UGameHistory::with(['user', 'direction', 'tableRef'])
            ->orderByDesc('play_date')
            ->take(50) // 直近50件
            ->get();

        return response()->json($games);
    }
}
