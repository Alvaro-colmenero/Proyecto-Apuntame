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
        'poster',
        'banner',
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

    // Contenidos relacionados desde esta ficha.
    public function relaciones()
    {
        return $this->belongsToMany(
            Contenido::class,
            'contenido_relaciones',
            'contenido_id',
            'relacionado_id'
        )->withPivot('tipo_relacion')
            ->withTimestamps();
    }

    // Contenidos que tienen esta ficha como relacionada.
    public function relacionadosInversos()
    {
        return $this->belongsToMany(
            Contenido::class,
            'contenido_relaciones',
            'relacionado_id',
            'contenido_id'
        )->withPivot('tipo_relacion')
            ->withTimestamps();
    }
}
