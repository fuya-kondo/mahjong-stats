<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UUser extends Model
{
    use HasFactory;

    protected $table = 'u_user';

    protected $fillable = [
        'last_name',
        'first_name',
    ];

    public function games()
    {
        return $this->hasMany(UGameHistory::class, 'u_user_id');
    }
}
