<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medias extends Model
{
    use HasFactory;


    // Mostra a Tentativa associada à Categoria
    public function Tentativa()
    {
        return $this->belongsTo(Tentativas::class, 'tentativa');
    }

    // Mostra todas as Respostas Submetidas nessa Categoria por certo Utilizador
    public function Respondidas()
    {
        return $this->hasMany(Respondidas::class, 'categoria');
    }
}
