<?php

namespace App\Http\Controllers;

use App\Models\UUser;
use Illuminate\Http\Request;
use App\Http\Resources\UserGameResource;

class UserGameController extends Controller
{

    public function index(Request $request, $id)
    {
        $user = UUser::findOrFail($id);

        $query = $user->games()->latest();

        // 日付フィルタリング
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('played_at', [$request->from, $request->to]);
        } elseif ($request->filled('from')) {
            $query->whereDate('played_at', '>=', $request->from);
        } elseif ($request->filled('to')) {
            $query->whereDate('played_at', '<=', $request->to);
        }

        return UserGameResource::collection($query->paginate(10));
    }

}
