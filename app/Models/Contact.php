<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
