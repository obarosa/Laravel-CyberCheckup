<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respostas extends Model
{
    use HasFactory;

    public $fillable = [
        'nome',
        'pontos',
    ];

    // Vai buscar a Questão associada à Resposta
    public function Questao()
    {
        return $this->belongsTo(Questoes::class, 'questao')->orderBy('ordem');
    }
}
