<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\UUser;

class RankingResource extends JsonResource
{
    public function toArray($request)
    {
        $user = UUser::find($this->u_user_id);

        return [
            'user_id'      => $this->u_user_id,
            'user_name'    => $user->name ?? 'Unknown',
            'games_played' => (int) $this->games_played,
            'total_point'  => round($this->total_point, 1),
            'avg_rank'     => round($this->avg_rank, 2),
        ];
    }
}
