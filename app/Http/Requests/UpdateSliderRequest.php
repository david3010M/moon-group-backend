<?php

namespace App\Http\Requests;

/**
 * @OA\Schema (
 *     schema="UpdateSliderRequest",
 *     title="UpdateSliderRequest",
 *     type="object",
 *     @OA\Property (property="title", type="string", example="Title"),
 *     @OA\Property (property="order", type="integer", example=1),
 *     @OA\Property (property="active", type="string", example="true"),
 *     @OA\Property (property="image", type="file", format="binary"),
 * )
 */
class UpdateSliderRequest extends UpdateRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'order' => 'nullable|integer',
            'active' => 'nullable|string|in:true,false',
            'image' => 'nullable|image',
        ];
    }
}
