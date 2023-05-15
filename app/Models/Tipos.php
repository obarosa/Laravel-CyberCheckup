<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipos extends Model
{
    use HasFactory;

    public $fillable = [
        'tipo'
    ];

    // Vai buscar todos os Utilizadores associados ao Tipo de Utilizador
    public function Users()
    {
        return $this->hasMany(User::class, 'tipo');
    }

    // Vai buscar todas as Questões associadas ao Tipo de Utilizador
    public function Questoes()
    {
        return $this->belongsToMany(Questoes::class);
    }

}
