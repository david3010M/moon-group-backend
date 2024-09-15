<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexSliderRequest;
use App\Http\Resources\SliderResource;
use App\Models\Slider;
use App\Http\Requests\StoreSliderRequest;
use App\Http\Requests\UpdateSliderRequest;

class SliderController extends Controller
{
    /**
     * @OA\Get (
     *     path="/moon-group-backend/public/api/slider",
     *     tags={"Slider"},
     *     summary="Get all slider images",
     *     description="Get all slider images",
     *     @OA\Parameter(parameter="all", name="all", in="query", required=false, description="Get all slider image", @OA\Schema(type="boolean")),
     *     @OA\Parameter(parameter="page", name="page", in="query", required=false, description="Page number", @OA\Schema(type="integer")),
     *     @OA\Parameter(parameter="per_page", name="per_page", in="query", required=false, description="Items per page", @OA\Schema(type="integer")),
     *     @OA\Parameter(parameter="sort", name="sort", in="query", required=false, description="Sort by column", @OA\Schema(type="string")),
     *     @OA\Parameter(parameter="direction", name="direction", in="query", required=false, description="Sort direction", @OA\Schema(type="string", enum={"asc", "desc"})),
     *     @OA\Response(response=200, description="Successful operation", @OA\JsonContent(ref="#/components/schemas/SliderCollection")),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Unauthenticated")),
     *     @OA\Response(response=422, description="Validation error", @OA\JsonContent(ref="#/components/schemas/ValidationError"))
     * )
     */
    public function index(IndexSliderRequest $request)
    {
        return $this->getFilteredResults(
            Slider::class,
            $request,
            Slider::filters,
            Slider::sorts,
            SliderResource::class
        );
    }

    public function store(StoreSliderRequest $request)
    {
        $images = $request->file('images') ?? [];
        foreach ($images as $index => $image) {
            $file = $image;

            $currentTime = now();

            $originalName = str_replace(' ', '_', $file->getClientOriginalName());

            $filename = ($index + 1) . '-' . $currentTime->format('YmdHis') . '_' . $originalName;
            $path = $file->storeAs('slider', $filename, 'public');
            $routeImage = 'https://develop.garzasoft.com/moon-group-backend/storage/app/public/' . $path;

            $dataImage = [
                'route' => $routeImage,
                'order' => ($index + 1),
                'status' => 1,
            ];
            Slider::create($dataImage);
        }
        return response()->json(['message' => 'Images uploaded successfully'], 201);
    }

    public function show(int $id)
    {
        //
    }

    public function update(UpdateSliderRequest $request, int $id)
    {
        //
    }

    public function destroy(int $id)
    {
        //
    }
}
