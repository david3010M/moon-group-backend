<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexNewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;

class NewsController extends Controller
{
    /**
     * @OA\Get (
     *     path="/moon-group-backend/public/api/news",
     *     tags={"News"},
     *     summary="Get all news",
     *     description="Get all news",
     *     @OA\Parameter(parameter="all", name="all", in="query", required=false, description="Get all news", @OA\Schema(type="boolean")),
     *     @OA\Parameter(parameter="page", name="page", in="query", required=false, description="Page number", @OA\Schema(type="integer")),
     *     @OA\Parameter(parameter="per_page", name="per_page", in="query", required=false, description="Items per page", @OA\Schema(type="integer")),
     *     @OA\Parameter(parameter="sort", name="sort", in="query", required=false, description="Sort by column", @OA\Schema(type="string")),
     *     @OA\Parameter(parameter="direction", name="direction", in="query", required=false, description="Sort direction", @OA\Schema(type="string", enum={"asc", "desc"})),
     *     @OA\Response(response=200, description="Successful operation", @OA\JsonContent(ref="#/components/schemas/NewsCollection")),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Unauthenticated")),
     *     @OA\Response(response=422, description="Validation error", @OA\JsonContent(ref="#/components/schemas/ValidationError"))
     * )
     */
    public function index(IndexNewsRequest $request)
    {
        return $this->getFilteredResults(
            News::class,
            $request,
            News::filters,
            News::sorts,
            NewsResource::class
        );
    }

    public function store(StoreNewsRequest $request)
    {
        //
    }

    /**
     * @OA\Get (
     *     path="/moon-group-backend/public/api/news/{id}",
     *     tags={"News"},
     *     summary="Get news by id",
     *     description="Get news by id",
     *     @OA\Parameter(parameter="id", name="id", in="path", required=true, description="News id", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Successful operation", @OA\JsonContent(ref="#/components/schemas/NewsResource")),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Unauthenticated")),
     *     @OA\Response(response=404, description="Not found", @OA\JsonContent( @OA\Property(property="error", type="string", example="Noticia no encontrada")))
     * )
     */
    public function show(int $id)
    {
        $news = News::find($id);
        if (!$news) return response()->json(['error' => 'Noticia no encontrada'], 404);
        return response()->json(new NewsResource($news));
    }

    public function update(UpdateNewsRequest $request, int $id)
    {
        //
    }

    public function destroy(int $id)
    {
        //
    }
}
