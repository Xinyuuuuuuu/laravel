<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{   
    // Esto permite insertar name en masa
    protected $fillable = ['name'];

    public function challenges()
    {
        return $this->hasMany(Challenge::class);
    }
}
