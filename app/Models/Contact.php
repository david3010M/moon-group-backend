<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Contact",
 *     required={"name", "subject", "email", "message"},
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="subject", type="string", example="Subject"),
 *     @OA\Property(property="email", type="string", example="mail@gmail.com"),
 *     @OA\Property(property="message", type="string", example="Message")
 * )
 */
class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'subject',
        'email',
        'message',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const filters = [
        'name' => 'like',
        'subject' => 'like',
        'email' => 'like',
        'message' => 'like',
    ];

    const sorts = [
        'name',
        'subject',
        'email',
        'message',
    ];
}
