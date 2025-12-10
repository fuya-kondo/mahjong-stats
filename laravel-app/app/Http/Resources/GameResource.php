<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'game_id' => $this->id,
            'rank' => $this->rank,
            'score' => $this->score,
            'point' => $this->point,
            'date' => $this->played_at->format('Y-m-d H:i'),
            'group_name' => $this->table->group->name ?? null,
        ];
    }

}
