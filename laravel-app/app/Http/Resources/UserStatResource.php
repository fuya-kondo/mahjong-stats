<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserStatResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user_id'       => $this->id,
            'name'          => $this->last_name . ' ' . $this->first_name,
            'games_played'  => $this->games_played ?? 0,
            'wins'          => $this->wins ?? 0,
            'win_rate'      => $this->win_rate ? round($this->win_rate, 2) : 0,
            'avg_rank'      => $this->avg_rank ? round($this->avg_rank, 2) : 0,
            'avg_score'     => $this->avg_score ?? 0,
            'total_points'  => $this->total_points ?? 0,
        ];
    }
}
