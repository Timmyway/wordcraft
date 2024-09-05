<?php

namespace App\Http\Controllers;

use App\Helpers\Uploader;
use App\Models\Illustration;
use App\Services\ImageUploader;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class GalleryController extends Controller
{
    protected $validations;
    protected $imageUploader;
    private $_limit;

    public function __construct(ImageUploadService $imageUploader)
    {
        $this->validations = [
            'resize' => '',
            'config' => '',
            'images' => 'required|array',
            'images.*' => 'image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
        ];

        $this->imageUploader = $imageUploader;
    }

    public function index(Request $request)
    {
        // Restrict to user's images only
        if ($request->input('user') != 'all') {
            $images = Illustration::where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            // ->take($this->_limit)
            // ->get();
            ->paginate(25);
        } else {
            $images = Illustration::take($this->_limit)
            ->orderBy('id', 'desc')
            ->paginate(25);
        }
        return response()->json(['response' => $images]);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $postData = $request->validate($this->validations);

        if ($request->hasFile('images')) {
            $uploadedImages = $request->file('images');
            $responses = [];

            foreach ($uploadedImages as $file) {
                // Get resize config if available
                $resize = isset($postData['resize']) ? json_decode($postData['resize'], true) : null;

                // Upload image and thumbnail using the service
                $uploadResult = $this->imageUploader->upload($file, $resize);

                // Save the new image record in the database
                $newImage = new Illustration();
                $newImage->name = basename($uploadResult['image_path']);
                $newImage->location = $uploadResult['image_path'];
                $newImage->thumbnail = $uploadResult['thumbnail_path'];
                $newImage->url = $uploadResult['url'];
                $newImage->url_thumbnail = $uploadResult['thumbnail_url'];
                $newImage->config = $postData['config'] ?? json_encode([]);
                $newImage->user()->associate($request->user());
                $newImage->save();

                $responses[] = ['response' => 'created', 'url' => $newImage->url];
            }

            return response()->json($responses);
        } else {
            return response()->json(['error' => 'No image found to upload'], 404);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            // Find the image instance or fail with 404 if not found
            $image_instance = Illustration::findOrFail($id);

            // Check if the authenticated user owns the image
            if ($request->user()->id !== $image_instance->user_id) {
                return response()->json(['error' => 'Unauthorized: You can only delete your own images.'], 401);
            }

            // Delete image from database
            Illustration::destroy($id);

            // Delete image and its thumbnail from storage
            if (Storage::exists($image_instance->location)) {
                Storage::delete([$image_instance->location, $image_instance->thumbnail]);
            } else {
                // Handle case where image files are missing in storage (optional)
                // This block can be omitted if you expect storage files to always exist
                return response()->json(['error' => 'Image files not found in storage.'], 404);
            }

            return response()->json(['response' => 'Image with id '.$id.' deleted successfully.']);
        } catch (\Throwable $th) {
            // Handle any unexpected errors
            return response()->json(['error' => 'Failed to delete image.'], 500);
        }
    }

    public function uploadedImage($filename)
    {
        $path = 'private/images/uploads/' . $filename;
        // Check if the file exists
        if (!Storage::exists($path)) {
            abort(404);
        }

        // Serve the file content with proper headers
        $file = Storage::get($path);
        $type = Storage::mimeType($path);

        return response()->make($file, 200, [
            'Content-Type' => $type,
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    public function thumbnailImage($filename)
    {
        $path = 'private/images/uploads/thumbnails/' . $filename;

        // Check if the file exists
        if (!Storage::exists($path)) {
            abort(404);
        }

        // Serve the file content with proper headers
        $file = Storage::get($path);
        $type = Storage::mimeType($path);

        return response()->make($file, 200, [
            'Content-Type' => $type,
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }
}
