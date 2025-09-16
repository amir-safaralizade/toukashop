<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Visit\Traits\Visitable;

class Category extends Model
{
    use  Visitable;
    protected $fillable = ['name', 'slug', 'type'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
