<?php

use Illuminate\Database\Seeder;

class CursoVeraoMatTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('curso_verao_mat')->delete();
        
        \DB::table('curso_verao_mat')->insert(array (
            0 => 
            array (
                'id_curso_verao' => 1,
                'nome_ptbr' => 'Álgebra',
                'nome_en' => 'Algebra',
                'nome_es' => 'Álgebra',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            1 => 
            array (
                'id_curso_verao' => 2,
                'nome_ptbr' => 'Análise',
                'nome_en' => 'Analysis',
                'nome_es' => 'Análisis',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            2 => 
            array (
                'id_curso_verao' => 3,
                'nome_ptbr' => 'Análise Numérica',
                'nome_en' => 'Numerical Analysis',
                'nome_es' => 'Análisis Numérico',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            3 => 
            array (
                'id_curso_verao' => 4,
                'nome_ptbr' => 'Dinâmica de Fluidos',
                'nome_en' => 'Fluid Dynamics',
                'nome_es' => 'Dinamica de Fluidos',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            4 => 
            array (
                'id_curso_verao' => 5,
                'nome_ptbr' => 'Geometria',
                'nome_en' => 'Geometry',
                'nome_es' => 'Geometría',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            5 => 
            array (
                'id_curso_verao' => 6,
                'nome_ptbr' => 'Probabilidade',
                'nome_en' => 'Probability',
                'nome_es' => 'Probabilidad ',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            6 => 
            array (
                'id_curso_verao' => 7,
                'nome_ptbr' => 'Sistemas Dinâmicos',
                'nome_en' => 'Dynamical Systems',
                'nome_es' => 'Sistemas Dinámicos',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            7 => 
            array (
                'id_curso_verao' => 8,
                'nome_ptbr' => 'Teoria da Computação',
                'nome_en' => 'Theory of Computation',
                'nome_es' => 'Teoría de la Computación',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            8 => 
            array (
                'id_curso_verao' => 9,
                'nome_ptbr' => 'Teoria dos Números',
                'nome_en' => 'Number Theory',
                'nome_es' => 'Teoría de los Números',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
        ));

        $tableToCheck = 'curso_verao_mat';

        $highestId = DB::table($tableToCheck)->select(DB::raw('MAX(id_curso_verao)'))->first();
        $nextId = DB::table($tableToCheck)->select(DB::raw('nextval(\''.$tableToCheck.'_id_curso_verao_seq\')'))->first();

        DB::select('SELECT setval(\''.$tableToCheck.'_id_curso_verao_seq\', '.$highestId->max.')');   
    }
}