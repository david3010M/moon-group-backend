<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema (
 *     schema="NewsResource",
 *     title="NewsResource",
 *     description="News resource",
 *     @OA\Property (property="id", type="integer", example="1"),
 *     @OA\Property (property="title", type="string", example="Title"),
 *     @OA\Property (property="date", type="string", format="date", example="2024-08-19"),
 *     @OA\Property (property="introduction", type="string", example="Introduction"),
 *     @OA\Property (property="description", type="string", example="Description"),
 *     @OA\Property (property="image", type="string", example="Image"),
 *     @OA\Property (property="active", type="boolean", example="1"),
 *     @OA\Property (property="category_id", type="integer", example="1")
 * )
 *
 * @OA\Schema (
 *     schema="NewsCollection",
 *     title="NewsCollection",
 *     description="News resource collection",
 *     @OA\Property (property="data", type="array", @OA\Items(ref="#/components/schemas/NewsResource")),
 *     @OA\Property (property="links", type="object", ref="#/components/schemas/PaginationLinks"),
 *     @OA\Property (property="meta", type="object", ref="#/components/schemas/PaginationMeta")
 * )
 *
 */
class NewsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'titleEn' => $this->titleEn,
            'date' => $this->date,
            'introduction' => $this->introduction,
            'introductionEn' => $this->introductionEn,
            'description' => $this->description,
            'descriptionEn' => $this->descriptionEn,
            'image' => $this->image,
            'active' => $this->active,
            'category_id' => $this->category_id,
        ];
    }
}
