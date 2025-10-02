<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagObject extends Model
{
    protected $fillable = [
        'tag_id',
        'object_type',
        'object_id'
    ];
}
