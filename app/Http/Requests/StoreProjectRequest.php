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
            'titleEn' => 'required|string|max:255',
            'date' => 'required|date',
            'introduction' => 'required|string',
            'introductionEn' => 'required|string',
            'description' => 'required|string',
            'descriptionEn' => 'required|string',
            'headerImage' => 'nullable|file',
            'images' => 'required|array',
            'images.*' => 'required|file|mimes:jpeg,png,jpg,gif,heic,webp,svg,avif,heif,ico,cur,apng',
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $maxTotalSize = 40 * 1024 * 1024; // 40MB en bytes
            $totalSize = 0;

            if ($this->hasFile('headerImage')) {
                $totalSize += $this->file('headerImage')->getSize();
            }
            if ($this->hasFile('images')) {
                foreach ($this->file('images') as $image) {
                    $totalSize += $image->getSize();
                }
            }
            if ($totalSize > $maxTotalSize) {
                $validator->errors()->add('images', 'El peso total de las imágenes no debe superar los 40MB.');
            }
        });
    }
}
