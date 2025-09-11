<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';
    protected $fillable = ['name', 'slug', 'tel_prefix'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
