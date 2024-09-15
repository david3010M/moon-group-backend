<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema (
 *     schema="Image",
 *     title="Image",
 *     description="Image model",
 *     @OA\Property (property="id", type="integer", example="1"),
 *     @OA\Property (property="route", type="string", example="Image"),
 *     @OA\Property (property="project_id", type="integer", example="1"),
 *     @OA\Property (property="news_id", type="integer", example="1")
 * )
 */
class Image extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'route',
        'project_id',
        'news_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const filters = [
        'route' => 'like',
        'project_id' => 'like',
        'news_id' => 'like',
    ];

    const sorts = [
        'id',
        'route',
        'project_id',
        'news_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }


}
