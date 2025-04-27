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
        // Validate request
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Giới hạn kích thước ảnh: 2MB
        ]);

        // Lấy file ảnh từ request
        $file = $request->file('image');
        $fileName = Str::uuid() . '.' . $file->extension();

        // Lưu ảnh gốc vào storage/app/public/images
        $filePath = $file->storeAs('images', $fileName, 'public');

        // Tạo thumbnail
        $manager = new ImageManager(new Driver());
        $imageThumbnail = $manager->read($file);
        $imageThumbnail->resize(300, 200);
        $imageThumbnail->cover(200, 200);
        $thumbnailName = 'thumb_' . $fileName;

        // Lưu thumbnail vào storage/app/public/thumbnails
        Storage::disk('public')->put('thumbnails/' . $thumbnailName, $imageThumbnail->toJpeg());

        // Trả về URL của ảnh gốc và thumbnail
        return response()->json([
            'path' => url('/storage/' . $filePath),
            'thumbnail_path' => url('/storage/thumbnails/' . $thumbnailName),
            'file_name' => $fileName,
            'thumbnail_name' => $thumbnailName,
        ], 201);
    }

    public function getImage(Request $request, $fileName)
    {
        // Kiểm tra file có tồn tại trong storage không
        $filePath = 'images/' . $fileName;
        if (!Storage::disk('public')->exists($filePath)) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        // Trả về URL của ảnh
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
