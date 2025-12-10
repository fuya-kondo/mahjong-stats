<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MGroup extends Model
{
    protected $table = 'm_group';

    protected $fillable = [
        'name',
        'rule_id',
    ];

    public function rule()
    {
        return $this->belongsTo(MRule::class, 'rule_id');
    }

}
