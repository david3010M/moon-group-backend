<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/moon-group-backend/public/api/category",
     *     tags={"Categories"},
     *     summary="Get all categories",
     *     description="Get all categories",
     *     @OA\Parameter(parameter="all", name="all", in="query", required=false, description="Get all categories", @OA\Schema(type="boolean")),
     *     @OA\Parameter(parameter="page", name="page", in="query", required=false, description="Page number", @OA\Schema(type="integer")),
     *     @OA\Parameter(parameter="per_page", name="per_page", in="query", required=false, description="Items per page", @OA\Schema(type="integer")),
     *     @OA\Parameter(parameter="sort", name="sort", in="query", required=false, description="Sort by column", @OA\Schema(type="string")),
     *     @OA\Parameter(parameter="direction", name="direction", in="query", required=false, description="Sort direction", @OA\Schema(type="string", enum={"asc", "desc"})),
     *     @OA\Response(response=200, description="Successful operation", @OA\JsonContent(ref="#/components/schemas/CategoryCollection")),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Unauthenticated")),
     *     @OA\Response(response=422, description="Validation error", @OA\JsonContent(ref="#/components/schemas/ValidationError"))
     * )
     *
     */
    public function index()
    {
        return $this->getFilteredResults(
            Category::class,
            request(),
            Category::filters,
            Category::sorts,
            CategoryResource::class
        );
    }

    /**
     * @OA\Post(
     *     path="/moon-group-backend/public/api/category",
     *     tags={"Categories"},
     *     summary="Create a category",
     *     description="Create a category",
     *     @OA\RequestBody( required=true, description="Category data", @OA\JsonContent(ref="#/components/schemas/StoreCategoryRequest")),
     *     @OA\Response(response=200, description="Successful operation", @OA\JsonContent(ref="#/components/schemas/CategoryResource")),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Unauthenticated")),
     *     @OA\Response(response=422, description="Validation error", @OA\JsonContent(ref="#/components/schemas/ValidationError"))
     * )
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        $category = Category::find($category->id);
        return response()->json(new CategoryResource($category));
    }

    /**
     * @OA\Get(
     *     path="/moon-group-backend/public/api/category/{id}",
     *     tags={"Categories"},
     *     summary="Get category by id",
     *     description="Get category by id",
     *     @OA\Parameter(parameter="id", name="id", in="path", required=true, description="Category id", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Successful operation", @OA\JsonContent(ref="#/components/schemas/CategoryResource")),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Unauthenticated")),
     *     @OA\Response(response=404, description="Not found", @OA\JsonContent( @OA\Property(property="error", type="string", example="Categoría no encontrada")))
     * )
     */
    public function show(Category $category)
    {
        $category = Category::find($category->id);
        if (!$category) return response()->json(['error' => 'Categoría no encontrada'], 404);
        return response()->json(new CategoryResource($category));
    }

    /**
     * @OA\Put(
     *     path="/moon-group-backend/public/api/category/{id}",
     *     tags={"Categories"},
     *     summary="Update a category",
     *     description="Update a category",
     *     @OA\Parameter(parameter="id", name="id", in="path", required=true, description="Category id", @OA\Schema(type="integer")),
     *     @OA\RequestBody( required=true, description="Category data", @OA\JsonContent(ref="#/components/schemas/UpdateCategoryRequest")),
     *     @OA\Response(response=200, description="Successful operation", @OA\JsonContent(ref="#/components/schemas/CategoryResource")),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Unauthenticated")),
     *     @OA\Response(response=404, description="Not found", @OA\JsonContent( @OA\Property(property="error", type="string", example="Categoría no encontrada")))
     * )
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category = Category::find($category->id);
        if (!$category) return response()->json(['error' => 'Categoría no encontrada'], 404);
        $category->update($request->validated());
        $category = Category::find($category->id);
        return response()->json(new CategoryResource($category));
    }

    /**
     * @OA\Delete(
     *     path="/moon-group-backend/public/api/category/{id}",
     *     tags={"Categories"},
     *     summary="Delete a category",
     *     description="Delete a category",
     *     @OA\Parameter(parameter="id", name="id", in="path", required=true, description="Category id", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Successful operation", @OA\JsonContent( @OA\Property(property="message", type="string", example="Categoría eliminada"))),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Unauthenticated")),
     *     @OA\Response(response=404, description="Not found", @OA\JsonContent( @OA\Property(property="error", type="string", example="Categoría no encontrada")))
     * )
     */
    public function destroy(Category $category)
    {
        $category = Category::find($category->id);
        if (!$category) return response()->json(['error' => 'Categoría no encontrada'], 404);
        $category->delete();
        return response()->json(['message' => 'Categoría eliminada']);
    }
}
