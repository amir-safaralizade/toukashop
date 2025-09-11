<?php

namespace App\Traits;

use App\Models\MediaFile;
use App\Services\MediaService;

trait HasMediaFiles
{
    public function mediaFiles()
    {
        return $this->morphMany(MediaFile::class, 'fileable');
    }

    public function mediaGroup(string $group)
    {
        return $this->mediaFiles()->where('group', $group);
    }

    public function firstMedia(string $group)
    {
        return $this->mediaGroup($group)->first();
    }

    /**
     * حذف تمام فایل‌ها یا فایل‌های یک گروه خاص
     */
    public function deleteMedia(string $group = null): void
    {
        $files = $group ? $this->mediaGroup($group)->get() : $this->mediaFiles()->get();

        foreach ($files as $file) {
            app(MediaService::class)->deleteFile($file);
        }
    }
}
