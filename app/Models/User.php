<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="User model",
 *     @OA\Property( property="id", type="integer", example="1" ),
 *     @OA\Property( property="names", type="string", example="John" ),
 *     @OA\Property( property="lastnames", type="string", example="Doe" ),
 *     @OA\Property( property="username", type="string", example="johndoe" ),
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'names',
        'lastnames',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    const filters = [
        'names' => 'like',
        'lastnames' => 'like',
        'username' => 'like',
        'typeuser_id' => 'like',
    ];

    const sorts = [
        'id',
        'names',
        'lastnames',
        'username',
        'typeuser_id',
    ];
}
