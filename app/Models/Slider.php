<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'route',
        'title',
        'order',
        'active',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const filters = [
        'route' => 'like',
        'title' => 'like',
        'order' => 'like',
        'active' => 'like',
    ];

    const sorts = [
        'id',
        'route',
        'title',
        'order',
        'active',
    ];


}
