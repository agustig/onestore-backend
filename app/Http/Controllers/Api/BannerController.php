<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use ApiHelpers;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all('id', 'name', 'banner_url', 'is_enabled');
        return $this->onSuccess(
            BannerResource::collection($banners),
            'Banners retrieved',
        );
    }
}
