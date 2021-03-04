<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    protected $table = 'noticias';

    protected $fillable = [
        'titulo',
        'fonte',
        'url',
        'subtitulo',
        'data_pub',
        'data_coleta',
        'texto',
        'tags'        
    ];
}