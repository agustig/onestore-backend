<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    use ApiHelpers;

    public function uploadImage(Request $request)
    {
        if ($request->has('image')) {
            $image = $request->image;
            $nameFile = uniqid('img-') . '.' . $image->getClientOriginalExtension();
            $path = Storage::putFileAs('public/images', $image, $nameFile);

            return $this->onSuccess(
                [
                    'image_path' => $path,
                    'base_url' => url('/')
                ],
                'Upload successfully'
            );
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

            return $this->onSuccess([
                'images_path' => $imagesPath,
                'base_url' => url('/')
            ], 'Upload successfully');
        }
    }
}
