<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserGameResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'game_id' => $this->id,
            'rank' => $this->rank,
            'score' => $this->score,
            'point' => $this->point !== null ? floatval($this->point) : null,
            'date' => $this->played_at->format('Y-m-d H:i'),
            'group_name' => optional($this->table->group)->name,
        ];
    }
}
