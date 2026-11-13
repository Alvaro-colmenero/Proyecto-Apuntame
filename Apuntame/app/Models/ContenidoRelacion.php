<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContenidoRelacion extends Model
{
    protected $table = 'contenido_relaciones';

    protected $fillable = [
        'contenido_id',
        'relacionado_id',
        'tipo_relacion',
    ];

    public function contenido()
    {
        return $this->belongsTo(Contenido::class, 'contenido_id');
    }

    public function relacionado()
    {
        return $this->belongsTo(Contenido::class, 'relacionado_id');
    }
}
