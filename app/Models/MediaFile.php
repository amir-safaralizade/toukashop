<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MediaFile extends Model
{
    protected $fillable = [
        'type', 'path', 'disk', 'mime', 'original_name',
        'title', 'alt', 'group', 'uploaded_by', 'uploaded_ip'
    ];

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getUrlAttribute(): string
    {
        return \Storage::disk($this->disk)->url($this->path);
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime, 'image/');
    }

    public function getFullUrlAttribute(): string
    {
        return rtrim(config('services.manage_panel'), '/') . '/' . ltrim($this->path, '/');
    }

}
