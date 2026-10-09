<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    protected $table = 'generos';

    public $timestamps = false;

    public function contenidos()
    {
        return $this->belongsToMany(
            Contenido::class,
            'contenidos_generos',
            'genero_id',
            'contenido_id'
        );
    }
}
