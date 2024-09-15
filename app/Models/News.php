<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'date',
        'introduction',
        'description',
        'image',
        'category_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    const filters = [
        'title' => 'like',
        'date' => 'like',
        'introduction' => 'like',
        'description' => 'like',
        'image' => 'like',
        'active' => '=',
        'category_id' => '=',
    ];

    const sorts = [
        'title',
        'date',
        'introduction',
        'description',
        'image',
        'active',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
