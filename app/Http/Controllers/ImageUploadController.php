<?php

namespace App\Http\Controllers;

use App\Models\TImage;
use Exception;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('image');
        $fileName = Str::uuid() . '.' . $file->extension();
        $filePath = $file->storeAs('images', $fileName, 'public');


        $manager = new ImageManager(new Driver());
        $imageThumbnail = $manager->read($file);
        $imageThumbnail->resize(300, 200);
        $imageThumbnail->cover(200, 200);
        $thumbnailName = 'thumb_' . $fileName;
        Storage::disk('public')->put('thumbnails/' . $thumbnailName, $imageThumbnail->toJpeg());


        return response()->json([
            'path' => url('/storage/' . $filePath),
            'thumbnail_path' => url('/storage/thumbnails/' . $thumbnailName),
            'file_name' => $fileName,
            'thumbnail_name' => $thumbnailName,
        ], 201);
    }

    public function getImage(Request $request, $fileName)
    {
        $filePath = 'images/' . $fileName;
        if (!Storage::disk('public')->exists($filePath)) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        return response()->json([
            'path' => url('/storage/' . $filePath),
            'thumbnail_path' => url('/storage/thumbnails/thumb_' . $fileName),
        ], 200);
    }

    public function getRiskImage(Request $request, $riskId)
    {
        try {
            $images = TImage::where('risk_id', $riskId)->get()->map(function ($image) {
                return [
                    'file_name' => $image->file_name,
                    'path' => url('/storage/images/' . $image->file_name),
                    'thumbnail_path' => url('/storage/thumbnails/thumb_' . $image->file_name),
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $images,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
