<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class libros extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'autor',
        'fagregado',
        'actualizado',
        'version',
        'aceptado',
        'idcategoria',
    ];

    protected $table = 'libros';

    protected $primaryKey = 'id';
}
