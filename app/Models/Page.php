<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Visit\Traits\Visitable;

class Page extends Model
{
    use  Visitable;

    protected $fillable = [
        'name',
        'title'
    ];
}
