<?php

namespace App\Http\Requests;

/**
 * @OA\Schema(
 *     schema="UpdateNewsRequest",
 *     title="Update News Request",
 *     type="object",
 *     required={"title", "date", "introduction", "description", "image"},
 *     @OA\Property(property="title", type="string", example="Title"),
 *     @OA\Property(property="titleEn", type="string", example="Title"),
 *     @OA\Property(property="date", type="string", format="date", example="2021-09-01"),
 *     @OA\Property(property="introduction", type="string", example="Introduction"),
 *     @OA\Property(property="introductionEn", type="string", example="Introduction"),
 *     @OA\Property(property="description", type="string", example="Description"),
 *     @OA\Property(property="descriptionEn", type="string", example="Description"),
 *     @OA\Property(property="image", type="file", format="binary"),
 *     @OA\Property(property="category_id", type="integer", example="1")
 * )
 */
class UpdateNewsRequest extends UpdateRequest
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
            'image' => 'nullable|image',
            'category_id' => 'nullable|integer',
        ];
    }
}
