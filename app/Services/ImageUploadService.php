<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageUploadService
{
    protected $maxWidth = 1920;
    protected $maxHeight = 1080;

    public function upload($file, $resize = null)
    {
        // Generate unique file names for image and thumbnail
        $imageName = uniqid() . '.' . $file->getClientOriginalExtension();
        $thumbnailName = uniqid() . '.' . $file->getClientOriginalExtension();

        // Define the upload directory paths
        $uploadPath = 'private/images/uploads/';
        $thumbnailPath = 'private/images/uploads/thumbnails/';

        // Ensure directories exist, create if not
        if (!Storage::exists($uploadPath)) {
            Storage::makeDirectory($uploadPath, 0755, true);
        }
        if (!Storage::exists($thumbnailPath)) {
            Storage::makeDirectory($thumbnailPath, 0755, true);
        }

        // Read the image using Intervention
        $image = Image::make($file);

        // Resize the image if it's larger than the max size
        if ($image->width() > $this->maxWidth || $image->height() > $this->maxHeight) {
            $image->resize($this->maxWidth, $this->maxHeight, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        // Apply custom resize if provided
        if ($resize) {
            $resizeData = json_decode($resize);
            $image->resize($resizeData->width, $resizeData->height);
        }

        // Save the image
        $imagePath = $uploadPath . $imageName;
        Storage::put($imagePath, (string) $image->encode());

        // Create and save thumbnail
        $thumbnail = $image->resize(150, 150, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $thumbnailPath = $thumbnailPath . $thumbnailName;
        Storage::put($thumbnailPath, (string) $thumbnail->encode());

        // Return paths
        return [
            'image_path' => $imagePath,
            'image_url' => Storage::url($imagePath),
            'thumbnail_path' => $thumbnailPath,
            'thumbnail_url' => Storage::url($thumbnailPath),
        ];
    }

    public function delete($imagePath)
    {
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }
    }
}
