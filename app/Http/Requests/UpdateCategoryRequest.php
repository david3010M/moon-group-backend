<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema (
 *     schema="UpdateCategoryRequest",
 *     title="UpdateCategoryRequest",
 *     type="object",
 *     required={"name"},
 *     @OA\Property(property="name", type="string", example="Política")
 * )
 */
class UpdateCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('categories', 'name')
                    ->whereNull('deleted_at')
                    ->ignore($this->route('category')),
            ],
        ];

    }
}
