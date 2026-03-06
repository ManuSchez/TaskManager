<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Workspace extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'color', 'user_id'];

    // Relación: Un Workspace pertenece a un Usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un Workspace tiene muchos Tableros (Boards)
    public function boards()
    {
        return $this->hasMany(Board::class);
    }

    // Un pequeño truco: Crear el slug automáticamente al poner el nombre
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
