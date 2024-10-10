<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

/**
 * @OA\Schema (
 *     schema="StoreCategoryRequest",
 *     title="StoreCategoryRequest",
 *     type="object",
 *     required={"name"},
 *     @OA\Property(property="name", type="string", example="Política")
 * )
 */
class StoreCategoryRequest extends StoreRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('categories', 'name')
                    ->whereNull('deleted_at')
            ]
        ];
    }
}
