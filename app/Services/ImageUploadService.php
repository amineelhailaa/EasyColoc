<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploadService
{
    /**
     * Upload an image and return the path/URL to store in the database.
     *
     * On Heroku (production), images go to Cloudinary and we store the full URL.
     * Locally, images go to the public disk and we store the relative path.
     */
    public static function upload(UploadedFile $file, string $folder = 'avatars'): string
    {
        if (self::useCloudinary()) {
            return self::uploadToCloudinary($file, $folder);
        }

        return $file->store($folder, 'public');
    }

    /**
     * Check if an avatar value is a full URL (Cloudinary) or a local path.
     */
    public static function isUrl(?string $avatar): bool
    {
        if (empty($avatar)) {
            return false;
        }

        return str_starts_with($avatar, 'http://') || str_starts_with($avatar, 'https://');
    }

    /**
     * Get the display URL for an avatar value.
     */
    public static function url(?string $avatar): ?string
    {
        if (empty($avatar)) {
            return null;
        }

        // Already a full URL (Cloudinary)
        if (self::isUrl($avatar)) {
            return $avatar;
        }

        // Local path — use storage URL
        if (Storage::disk('public')->exists($avatar)) {
            return asset('storage/' . $avatar);
        }

        return null;
    }

    /**
     * Delete an old image if it exists.
     */
    public static function delete(?string $avatar): void
    {
        if (empty($avatar)) {
            return;
        }

        // Don't try to delete Cloudinary URLs from local disk
        if (self::isUrl($avatar)) {
            // Could add Cloudinary delete logic here if needed
            return;
        }

        if (Storage::disk('public')->exists($avatar)) {
            Storage::disk('public')->delete($avatar);
        }
    }

    /**
     * Determine whether to use Cloudinary based on env config.
     */
    private static function useCloudinary(): bool
    {
        return !empty(config('filesystems.disks.cloudinary.url'));
    }

    /**
     * Upload a file to Cloudinary and return the secure URL.
     */
    private static function uploadToCloudinary(UploadedFile $file, string $folder): string
    {
        $cloudinary = app(Cloudinary::class);

        $result = $cloudinary->uploadApi()->upload($file->getRealPath(), [
            'folder' => $folder,
            'resource_type' => 'image',
            'transformation' => [
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ],
        ]);

        return $result['secure_url'];
    }
}

