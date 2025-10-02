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
        'name',
        'slug'
    ];

    public function products()
    {
        return $this->belongsToMany(
            Product::class,    // Target model
            'tag_objects',     // Pivot table
            'tag_id',          // Foreign key on pivot table for Tag
            'object_id'        // Foreign key on pivot table for Product
        );
    }

    /**
     * Get all posts assigned to this tag without considering object_type
     */
    public function posts()
    {
        return $this->belongsToMany(
            \App\Models\Post::class,
            'tag_objects',
            'tag_id',
            'object_id'
        );
    }


    public function objectsCount()
    {
        return DB::table('tag_objects')
            ->where('tag_id', $this->id)
            ->count();
    }
}
