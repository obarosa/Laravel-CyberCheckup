<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //tipos
        DB::table('tipos')->insert([
            'tipo' => 'guest',
        ]);
        DB::table('tipos')->insert([
            'tipo' => 'admin',
        ]);
        DB::table('tipos')->insert([
            'tipo' => 'tecnico',
        ]);

        //Users
        DB::table('users')->insert(
            [
                'name' => 'admin',
                'email' => 'admin@admin.pt',
                'password' => bcrypt('123456789'),
                'perfil' => 'admin',
                'tipo' => 2,
            ]
        );
        DB::table('users')->insert(
            [
                'name' => 'teste',
                'email' => 'teste@teste.pt',
                'password' => bcrypt('123456789'),
                'perfil' => 'cliente',
                'tipo' => 1,
            ]
        );

        //categorias, questoes e respostas
        DB::table('categorias')->insert([
            'nome' => 'CateriTeste1',
            'ordem' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('questoes')->insert([
            'nome' => 'A organização segue um plano de recuperação durante ou após um incidente?',
            'obrigatoria' => 1,
            'categoria' => 1,
            'pontuacao' => 1,
            'ordem' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('respostas')->insert([
            'nome' => 'Existem procedimentos ad hoc de cópias de segurança',
            'questao' => 1,
            'pontos' => 1,
            'ordem' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('respostas')->insert([
            'nome' => 'Estão formalizadas regras e procedimentos para recuperação de incidentes com recurso a cópias de segurança e está estabelecido um processo de gestão de cópias de segurança',
            'questao' => 1,
            'pontos' => 2,
            'ordem' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('respostas')->insert([
            'nome' => 'São realizadas ações de consciencialização proativamente',
            'questao' => 1,
            'pontos' => 3,
            'ordem' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('questoes')->insert([
            'nome' => 'Os eventos são coletados e correlacionados a partir de várias fontes e sensores?',
            'obrigatoria' => 0,
            'pontuacao' => 1,
            'categoria' => 1,
            'ordem' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('respostas')->insert([
            'nome' => 'Os eventos de segurança são geridos e analisados',
            'questao' => 2,
            'pontos' => 1,
            'ordem' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('respostas')->insert([
            'nome' => 'O registo de eventos é coletado num sistema central',
            'questao' => 2,
            'pontos' => 2,
            'ordem' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nome' => 'CateriTeste2',
            'ordem' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('questoes')->insert([
            'nome' => 'Os dispositivos físicos, redes e sistemas de informação da sua organização encontram-se inventariados?',
            'obrigatoria' => 1,
            'pontuacao' => 0,
            'categoria' => 2,
            'ordem' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('respostas')->insert([
            'nome' => 'Existem registos em ficheiros isolados e de forma ad hoc',
            'questao' => 3,
            'pontos' => 1,
            'ordem' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('respostas')->insert([
            'nome' => 'Encontram-se registados em ferramenta de gestão de ativos físicos',
            'questao' => 3,
            'pontos' => 2,
            'ordem' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('respostas')->insert([
            'nome' => 'Existem processos e ferramentas para a descoberta automática',
            'questao' => 3,
            'pontos' => 3,
            'ordem' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        //questoes_tipo
        DB::table('questoes_tipos')->insert([
            'questoes_id' => 1,
            'tipos_id' => 1,
        ]);
        DB::table('questoes_tipos')->insert([
            'questoes_id' => 2,
            'tipos_id' => 1,
        ]);
        DB::table('questoes_tipos')->insert([
            'questoes_id' => 3,
            'tipos_id' => 3,

        ]);
    }
}
