<?php

use Illuminate\Database\Seeder;

class FormacaoTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('formacao')->delete();
        
        \DB::table('formacao')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tipo_ptbr' => 'Bacharelado',
                'tipo_en' => 'Bachelor’s degree',
                'tipo_es' => 'Bachillerato',
                'nivel' => 'Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            1 => 
            array (
                'id' => 2,
                'tipo_ptbr' => 'Licenciatura',
                'tipo_en' => 'College degree',
                'tipo_es' => 'Licenciatura',
                'nivel' => 'Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            2 => 
            array (
                'id' => 3,
                'tipo_ptbr' => 'Ambos',
                'tipo_en' => 'Both',
                'tipo_es' => 'Ambos',
                'nivel' => 'Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            3 => 
            array (
                'id' => 4,
                'tipo_ptbr' => 'Não se Aplica',
                'tipo_en' => 'Not applicable',
                'tipo_es' => 'No se aplica',
                'nivel' => 'Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            4 => 
            array (
                'id' => 5,
                'tipo_ptbr' => 'Mestrado Acadêmico',
                'tipo_en' => 'Master’s degree',
                'tipo_es' => 'Magíster',
                'nivel' => 'Pós-Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            5 => 
            array (
                'id' => 6,
                'tipo_ptbr' => 'Mestrado Profissional',
                'tipo_en' => null,
                'tipo_es' => null,
                'nivel' => 'Pós-Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            6 => 
            array (
                'id' => 7,
                'tipo_ptbr' => 'Doutorado',
                'tipo_en' => 'PhD',
                'tipo_es' => 'Doctorado',
                'nivel' => 'Pós-Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            7 => 
            array (
                'id' => 8,
                'tipo_ptbr' => 'Especialização',
                'tipo_en' => null,
                'tipo_es' => null,
                'nivel' => 'Pós-Graduação',
                'created_at' => '2017-11-21 15:27:00',
                'updated_at' => '2017-11-21 15:27:00',
            ),
            // 8 => 
            // array (
            //     'id' => 9,
            //     'tipo' => 'Doutorado',
            //     'nivel' => 'Pós-Graduação',
            //     'created_at' => '2017-11-21 15:27:00',
            //     'updated_at' => '2017-11-21 15:27:00',
            // ),
        ));
        
        $tableToCheck = 'formacao';

        $highestId = DB::table($tableToCheck)->select(DB::raw('MAX(id)'))->first();
        $nextId = DB::table($tableToCheck)->select(DB::raw('nextval(\''.$tableToCheck.'_id_seq\')'))->first();

        DB::select('SELECT setval(\''.$tableToCheck.'_id_seq\', '.$highestId->max.')');
        
    }
}