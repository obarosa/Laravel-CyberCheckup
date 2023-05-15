<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questoes extends Model
{
    use HasFactory;

    public $fillable = [
        'nome',
        'info',
        'obrigatoria',
    ];

    // Vai buscar a Categoria associada à Questão
    public function Categoria(){
        return $this->belongsTo(Categorias::class, 'categoria');
    }

    // Vai buscar todas as Respostas associadas à Questão
    public function Respostas(){
        return $this->hasMany(Respostas::class, 'questao')->orderBy('ordem');
    }

    // Vai buscar todos os Tipos de Utilizador associados à Questão
    public function Tipos()
    {
        return $this->belongsToMany(Tipos::class);
    }

    // Verifica se o Tipo está associado à Questão
    public function checkTipo($id)
    {
        return $this->Tipos()->where('id', '=', $id)->exists();
    }
}
