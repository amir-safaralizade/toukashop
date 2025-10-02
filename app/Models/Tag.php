<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Visit\Traits\Visitable;

class Tag extends Model
{
    use  Visitable;
    protected $fillable = [
        'type',
        'object',
        'name',
        'slug'
    ];

    public function products()
    {
        return $this->morphedByMany(Product::class, 'object', 'tag_objects');
    }

    // Relation with posts
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'object', 'tag_objects');
    }

    public function objectsCount()
    {
        return DB::table('tag_objects')
            ->where('tag_id', $this->id)
            ->count();
    }
}
