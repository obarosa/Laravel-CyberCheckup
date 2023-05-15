<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respondidas extends Model
{
    use HasFactory;

    // Vai buscar a Categoria e Média associada à Resposta submetida
    public function Categoria()
    {
        return $this->belongsTo(Medias::class, 'categoria');
    }
}
