<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UGameHistory extends Model
{
    use HasFactory;

    protected $table = 'u_game_history';

    protected $fillable = [
        'u_table_id',
        'u_user_id',
        'game',
        'rank',
        'score',
        'point',
        'mistake_count',
        'played_at',
    ];

    protected $casts = [
        'played_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(UUser::class, 'u_user_id');
    }

    public function table()
    {
        return $this->belongsTo(UTable::class, 'u_table_id');
    }

}
