<?php

namespace App\Http\Requests;

/**
 * @OA\Schema(
 *     schema="StoreNewsRequest",
 *     title="StoreNewsRequest",
 *     type="object",
 *     required={"title", "date", "introduction", "description", "image"},
 *     @OA\Property(property="title", type="string", example="Title"),
 *     @OA\Property(property="date", type="string", format="date", example="2021-09-01"),
 *     @OA\Property(property="introduction", type="string", example="Introduction"),
 *     @OA\Property(property="description", type="string", example="Description"),
 *     @OA\Property(property="image", type="file", format="binary"),
 *     @OA\Property(property="category_id", type="integer", example="1")
 * )
 */
class StoreNewsRequest extends StoreRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'date' => 'required|date',
            'introduction' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image',
            'category_id' => 'nullable|integer',
        ];
    }
}
