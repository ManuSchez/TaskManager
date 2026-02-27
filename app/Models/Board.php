<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    /** @use HasFactory<\Database\Factories\BoardFactory> */
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function columns()
{
    return $this->hasMany(Column::class);
}
    }
