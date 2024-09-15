<?php

namespace App\Http\Requests;

class StoreSliderRequest extends StoreRequest
{
    public function rules(): array
    {
        return [
            'images' => 'required|array',
            'images.*' => 'required|image',
        ];
    }
}
