<?php

namespace App\Http\Requests;

/**
 * @OA\Schema (
 *     schema="UpdateProjectRequest",
 *     title="UpdateProjectRequest",
 *     type="object",
 *     @OA\Property (property="title", type="string", example="Title"),
 *     @OA\Property (property="titleEn", type="string", example="Title"),
 *     @OA\Property (property="date", type="string", format="date", example="2024-08-19"),
 *     @OA\Property (property="introduction", type="string", example="Introduction"),
 *     @OA\Property (property="introductionEn", type="string", example="Introduction"),
 *     @OA\Property (property="description", type="string", example="Description"),
 *     @OA\Property (property="descriptionEn", type="string", example="Description"),
 *     @OA\Property (property="headerImage", type="file", format="binary"),
 *     @OA\Property (property="images[]", type="array", @OA\Items(type="file", format="binary"))
 * )
 */
class UpdateProjectRequest extends UpdateRequest
{
    public function rules(): array
    {
        return [
            'title' => 'nullable|string',
            'titleEn' => 'nullable|string',
            'date' => 'nullable|date',
            'introduction' => 'nullable|string',
            'introductionEn' => 'nullable|string',
            'description' => 'nullable|string',
            'descriptionEn' => 'nullable|string',
            'headerImage' => 'nullable|image',
            'images' => 'nullable|array',
            'images.*' => 'required|image',
        ];
    }
}
