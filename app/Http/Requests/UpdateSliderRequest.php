<?php

namespace App\Http\Requests;

class UpdateSliderRequest extends UpdateRequest
{
    public function rules(): array
    {
        return [
            'images' => 'required|array',
            'images.*' => 'required|image',
        ];
    }
}
