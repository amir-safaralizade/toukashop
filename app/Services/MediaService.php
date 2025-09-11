<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\MediaFile;
use Jenssegers\Agent\Agent;

class MediaService
{
    public function storeFile(UploadedFile $file, $model, string $group = null, string $uploadTo = 'storage', string $customPath = null): MediaFile
    {
        if (!$file->isValid()) {
            throw new \Exception('The uploaded file is not valid: ' . $file->getErrorMessage());
        }

        $mimeType = $file->getMimeType();
        $originalName = $file->getClientOriginalName();
        $fileType = $this->detectType($file);

        $disk = 'public';
        $filename = $this->generateFileName($file, $fileType);
        $finalPath = null;

        try {
            if ($uploadTo === 'storage') {
                // Build path for storage
                $path = rtrim($customPath ?? 'uploads/' . date('Y/m'), '/');
                $finalPath = $file->storeAs($path, $filename, $disk);
            } else {
                // Build path for public directory
                $basePath = rtrim('uploads/' . date('Y'), '/');
                $subPath = $customPath ? ltrim($customPath, '/') : 'default/' . date('m');
                $path = $basePath . '/' . $subPath;

                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                $file->move($path, $filename);
                $finalPath = rtrim($path, '/') . '/' . $filename;
            }

            // Normalize path to remove extra slashes
            $finalPath = preg_replace('#/+#', '/', $finalPath);
        } catch (\Exception $e) {
            throw new \Exception('File upload failed: ' . $e->getMessage());
        }

        try {
            // Create media record
            $media = $model->mediaFiles()->create([
                'type' => $fileType,
                'path' => $finalPath,
                'disk' => $disk,
                'mime' => $mimeType,
                'original_name' => $originalName,
                'group' => $group,
                'uploaded_by' => Auth::user()->id ?? 1,
                'uploaded_ip' => get_client_ip(),
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Failed to save media record: ' . $e->getMessage());
        }

        activity()
            ->performedOn($media)
            ->causedBy(auth()->user())
            ->withProperties([
                'group' => $group,
                'ip' => get_client_ip(),
                'agent' => get_user_agent(),
                'source' => $uploadTo,
            ])
            ->log('File uploaded successfully');

        return $media;
    }

    public function deleteFile(MediaFile $media): bool
    {
        try {
            // Delete file from disk
            if ($media->disk === 'public') {
                $fullPath = public_path($media->path);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                    $directory = dirname($fullPath);
                    if (is_dir($directory) && !glob($directory . '/*')) {
                        rmdir($directory);
                    }
                }
            } else {
                Storage::disk($media->disk)->delete($media->path);
            }
        } catch (\Exception $e) {
            // Silent catch to prevent deletion failure from stopping the process
        }

        // Log activity for file deletion
        activity()
            ->performedOn($media)
            ->causedBy(auth()->user())
            ->withProperties([
                'path' => $media->path,
                'type' => $media->type,
                'group' => $media->group,
            ])
            ->log('File deleted');

        return $media->delete();
    }

    private function generateFileName(UploadedFile $file, $fileType): string
    {
        $rand_length = mt_rand(30, 50);
        return $fileType . '_' . Str::random($rand_length) . '.' . $file->getClientOriginalExtension();
    }

    private function detectType(UploadedFile $file): string
    {
        $mime = $file->getMimeType();
        return match (true) {
            str_starts_with($mime, 'image/') => 'image',
            str_starts_with($mime, 'video/') => 'video',
            str_starts_with($mime, 'audio/') => 'audio',
            default => 'document',
        };
    }
}
