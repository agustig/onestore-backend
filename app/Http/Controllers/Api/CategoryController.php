<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
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
        $categories = Category::all('id', 'name', 'description');
        $categoriesPageCount = $categories->count() / 10;

        if ($categoriesPageCount > 1) {
            return $this->onSuccess(
                CategoryResource::collection($categories->paginate(10)),
                'Categories retrieved',
                $categoriesPageCount,
            );
        }

        return $this->onSuccess(
            CategoryResource::collection($categories),
            'Categories retrieved'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        if ($this->isAdmin($user) || $this->isSuperAdmin($user)) {
            $validator = Validator::make(
                $request->all(),
                $this->categoryValidationRules()
            );
            if ($validator->passes()) {
                $category = Category::create($request->all());
                return $this->onSuccess(
                    CategoryResource::make($category),
                    'Category created',
                );
            }
            return $this->onError(400, $validator->errors());
        }
        return $this->onError(401, $user->role);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load('products');
        return $this->onSuccess(
            CategoryResource::make($category),
            'Category retrieved'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $user = $request->user();
        if ($this->isAdmin($user) || $this->isSuperAdmin($user)) {
            $validator = Validator::make(
                $request->all(),
                $this->categoryValidationRules()
            );
            if ($validator->passes()) {
                $category->update($request->all());
                return $this->onSuccess(
                    CategoryResource::make($category),
                    'Category updated',
                );
            }
            return $this->onError(400, $validator->errors());
        }
        return $this->onError(401, 'Unauthorized access');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category)
    {

        $user = $request->user();
        if ($this->isAdmin($user) || $this->isSuperAdmin($user)) {
            $category->delete();
            return $this->onSuccess(null, 'Category deleted');
        }
        return $this->onError(401, 'Unauthorized access');
    }
}
