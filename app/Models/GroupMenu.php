<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema (
 *     schema="GroupMenu",
 *     title="GroupMenu",
 *     type="object",
 *     required={"id","name", "icon"},
 *     @OA\Property(property="id", type="number", example="1"),
 *     @OA\Property(property="name", type="string", example="Admin"),
 *     @OA\Property(property="icon", type="string", example="fas fa-user"),
 *     @OA\Property(property="order", type="number", example="1"),
 *     @OA\Property(property="route", type="string", example="slider"),
 * )
 */
class GroupMenu extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'icon',
        'order',
        'route',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function optionMenus()
    {
        return $this->hasMany(OptionMenu::class, 'groupmenu_id');
    }
}
