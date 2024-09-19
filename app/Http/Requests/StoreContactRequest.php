<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreContactRequest",
 *     required={"name", "subject", "email"},
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="subject", type="string", example="Subject"),
 *     @OA\Property(property="email", type="string", example="mail@gmail.com"),
 *     @OA\Property(property="message", type="string", example="Message")
 * )
 */
class StoreContactRequest extends StoreRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'nullable|string',
        ];
    }
}
