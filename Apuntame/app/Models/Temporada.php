<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temporada extends Model
{
    protected $table = 'temporadas';

    public $timestamps = false;

    public function contenido()
    {
        return $this->belongsTo(Contenido::class, 'contenido_id');
    }

    public function episodios()
    {
        return $this->hasMany(Episodio::class, 'temporada_id');
    }
}
