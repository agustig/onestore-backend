<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use ApiHelpers;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->onSuccess(
            ProductResource::collection(Product::select(
                'id',
                'name',
                'description',
                'price',
                'image_url',
            )->paginate(10),),
            'Products retrieved',
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            $this->productValidationRules()
        );
        if ($validator->passes()) {
            $product = Product::create([
                ...$request->all(),
                'user_id' => $request->user()->id
            ]);
            return $this->onSuccess($product, 'Product created');
        }
        return $this->onError(400, $validator->errors());
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category', 'user');
        return $this->onSuccess(
            ProductResource::make($product),
            'Product retrieved',
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $requestUser = $request->user();
        $productUserId = $product->user_id;
        if (
            $requestUser->id == $productUserId ||
            $this->isAdmin($requestUser) ||
            $this->isSuperAdmin($requestUser)
        ) {
            $validator = Validator::make(
                $request->all(),
                $this->productValidationRules()
            );
            if ($validator->passes()) {
                $product->update($request->all());
                return $this->onSuccess(
                    ProductResource::make($product),
                    'Product updated'
                );
            }
            return $this->onError(400, $validator->errors());
        }
        return $this->onError(401, 'Unauthorized access');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Product $product)
    {
        $requestUser = $request->user();
        $productUserId = $product->user_id;
        if (
            $requestUser->id == $productUserId ||
            $this->isAdmin($requestUser) ||
            $this->isSuperAdmin($requestUser)
        ) {
            $product->delete();
            return $this->onSuccess(null, 'Product deleted');
        }
        return $this->onError(401, 'Unauthorized access');
    }
}
