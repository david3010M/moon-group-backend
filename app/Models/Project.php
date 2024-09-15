<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'date',
        'introduction',
        'description',
        'active',
        'headerImage',
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
        'active' => 'like',
    ];

    const sorts = [
        'id',
        'title',
        'date',
        'introduction',
        'description',
        'active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

}
