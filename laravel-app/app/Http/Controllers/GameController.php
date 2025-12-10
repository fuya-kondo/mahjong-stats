<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreGameRequest;
use App\Http\Resources\GameResource;
use App\Models\UGameHistory;

class GameController extends Controller

{
    public function index()
    {
        $games = UGameHistory::latest()->take(20)->get();
        return GameResource::collection($games);
    }

    public function store(StoreGameRequest $request)
    {
        $data = $request->validated();

        // 新しい試合を登録
        $game = UGameHistory::create($data);

        // グループIDを取得（卓 → グループ）
        $groupId = $game->table->m_group_id ?? null;

        // キャッシュ削除（該当グループのみ）
        $cacheCleared = false;
        if ($groupId) {
            Cache::forget("group_{$groupId}_ranking");
            $cacheCleared = true;
        }

        return response()->json([
            'message' => '試合を登録しました。',
            'game' => $game,
            'cache_cleared' => $cacheCleared, // ✅ キャッシュ削除の有無を返す
        ], 201);
    }

}
