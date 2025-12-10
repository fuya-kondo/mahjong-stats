<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UTable extends Model
{
    protected $table = 'u_table';

    public function group()
    {
        return $this->belongsTo(MGroup::class, 'm_group_id');
    }

}
