<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        if ($request->has('image')) {
            $image = $request->image;
            $nameFile = uniqid('img-') . '.' . $image->getClientOriginalExtension();
            $path = Storage::putFileAs('public/images', $image, $nameFile);

            return response()->json([
                'status' => 'upload successfully',
                'image_path' => $path,
                'base_url' => url('/')
            ]);
        }
    }

    public function uploadMultipleImages(Request $request)
    {
        if ($request->has('images')) {
            $images = $request->images;
            $imagesPath = [];
            foreach ($images as $image) {
                $nameFile = uniqid('img-') . '.' . $image->getClientOriginalExtension();
                $path = Storage::putFileAs('public/images', $image, $nameFile);
                array_push($imagesPath, $path);
            }

            return response()->json([
                'status' => 'upload successfully',
                'images_path' => $imagesPath,
                'base_url' => url('/')
            ]);
        }
    }
}
