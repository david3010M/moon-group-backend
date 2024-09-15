<?php

namespace App\Http\Requests;

class StoreProjectRequest extends StoreRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'introduction' => 'required|string',
            'description' => 'required|string',
            'headerImage' => 'nullable|image',
            'images' => 'required|array',
            'images.*' => 'required|image',
        ];
    }
}
