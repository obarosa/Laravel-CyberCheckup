<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Categorias extends Model
{
    use HasFactory;

    public $fillable = [
        'nome',
    ];


    // Vai buscar todas as Questões associadas à Categoria
    public function Questoes()
    {
        return $this->hasMany(Questoes::class, 'categoria')->orderBy('ordem');
    }

    // Mostra a Categoria apenas se tiver Questões
    public function QuestoesValidas()
    {
        return $this->Questoes()->groupBy('id')->having(DB::raw('count(*)'), '>', 0);
    }

}
