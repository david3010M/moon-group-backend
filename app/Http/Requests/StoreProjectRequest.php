<?php

namespace App\Http\Requests;

/**
 * @OA\Schema(
 *     schema="StoreProjectRequest",
 *     title="Store Project Request",
 *     type="object",
 *     required={"title", "date", "introduction", "description", "images[]"},
 *     @OA\Property(property="title", type="string", example="Title"),
 *     @OA\Property(property="titleEn", type="string", example="Title"),
 *     @OA\Property(property="date", type="string", format="date", example="2021-09-01"),
 *     @OA\Property(property="introduction", type="string", example="Introduction"),
 *     @OA\Property(property="introductionEn", type="string", example="Introduction"),
 *     @OA\Property(property="description", type="string", example="Description"),
 *     @OA\Property(property="descriptionEn", type="string", example="Description"),
 *     @OA\Property(property="headerImage", type="file", format="binary"),
 *     @OA\Property(property="images[]", type="array", @OA\Items(type="file", format="binary"))
 * )
 */
class StoreProjectRequest extends StoreRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'titleEn' => 'nullable|string|max:255',
            'date' => 'required|date',
            'introduction' => 'required|string',
            'introductionEn' => 'nullable|string',
            'description' => 'required|string',
            'descriptionEn' => 'nullable|string',
            'headerImage' => 'nullable|image',
            'images' => 'required|array',
            'images.*' => 'required|image',
        ];
    }
}
