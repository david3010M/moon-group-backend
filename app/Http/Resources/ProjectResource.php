<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema (
 *     schema="ProjectResource",
 *     title="ProjectResource",
 *     description="Project resource",
 *     @OA\Property (property="id", type="integer", example="1"),
 *     @OA\Property (property="title", type="string", example="Title"),
 *     @OA\Property (property="date", type="string", format="date", example="2024-08-19"),
 *     @OA\Property (property="introduction", type="string", example="Introduction"),
 *     @OA\Property (property="description", type="string", example="Description"),
 *     @OA\Property (property="active", type="boolean", example="1"),
 *     @OA\Property (property="headerImage", type="string", example="Image"),
 *     @OA\Property (property="images", type="array", @OA\Items(ref="#/components/schemas/Image"))
 * )
 *
 * @OA\Schema (
 *     schema="ProjectCollection",
 *     title="ProjectCollection",
 *     description="Project resource collection",
 *     @OA\Property (property="data", type="array", @OA\Items(ref="#/components/schemas/ProjectResource")),
 *     @OA\Property (property="links", type="object", ref="#/components/schemas/PaginationLinks"),
 *     @OA\Property (property="meta", type="object", ref="#/components/schemas/PaginationMeta")
 * )
 *
 */
class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'date' => $this->date,
            'introduction' => $this->introduction,
            'description' => $this->description,
            'active' => $this->active,
            'headerImage' => $this->headerImage,
            'images' => $this->images,
        ];
    }
}
