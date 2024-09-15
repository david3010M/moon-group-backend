<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema (
 *     schema="SliderResource",
 *     title="SliderResource",
 *     description="Slider resource",
 *     @OA\Property (property="id", type="integer", example="1"),
 *     @OA\Property (property="route", type="string", example="Image"),
 *     @OA\Property (property="title", type="string", example="Title"),
 *     @OA\Property (property="order", type="integer", example="1"),
 *     @OA\Property (property="active", type="boolean", example="1"),
 * )
 *
 * @OA\Schema (
 *     schema="SliderCollection",
 *     title="SliderCollection",
 *     description="Slider resource collection",
 *     @OA\Property (property="data", type="array", @OA\Items(ref="#/components/schemas/SliderResource")),
 *     @OA\Property (property="links", type="object", ref="#/components/schemas/PaginationLinks"),
 *     @OA\Property (property="meta", type="object", ref="#/components/schemas/PaginationMeta")
 * )
 *
 */
class SliderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'route' => $this->route,
            'title' => $this->title,
            'order' => $this->order,
            'active' => $this->active,
        ];
    }
}
