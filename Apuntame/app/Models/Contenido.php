<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenido extends Model
{
    protected $table = 'contenidos';

    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'tipo',
        'descripcion',
        'fecha_estreno',
        'duracion',
        'imagen',
        'estado_serie',
    ];

    public function temporadas()
    {
        return $this->hasMany(Temporada::class, 'contenido_id');
    }

    public function generos()
    {
        return $this->belongsToMany(
            Genero::class,
            'contenidos_generos',
            'contenido_id',
            'genero_id'
        );
    }
}
