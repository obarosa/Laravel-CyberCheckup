<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tentativas extends Model
{
    use HasFactory;

    // Vai buscar o Utilizador associado à Tentativa
    public function User()
    {
        return $this->belongsTo(User::class, 'user');
    }

    // Vai buscar as Categorias e Médias associadas à Tentativa
    public function Medias()
    {
        return $this->hasMany(Medias::class, 'tentativa');
    }
}
