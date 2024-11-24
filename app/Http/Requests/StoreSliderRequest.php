<?php

namespace App\Http\Requests;

/**
 * @OA\Schema (
 *     schema="StoreSliderRequest",
 *     title="StoreSliderRequest",
 *     type="object",
 *     required={"images[]"},
 *     @OA\Property (property="title", type="string", example="Title"),
 *     @OA\Property (property="images[]", type="array", @OA\Items(type="file", format="binary"))
 * )
 */
class StoreSliderRequest extends StoreRequest
{
    public function rules(): array
    {
        return [
            'title' => 'nullable|string',
            'images' => 'required|array',
            'images.*' => 'required|file|mimes:jpeg,png,jpg,gif,heic,webp,svg,avif,heif,ico,cur,apng',
        ];
    }
}
