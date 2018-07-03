<?php

namespace Veraomat\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class EscolhaCursoVerao extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'escolhas_curso_verao';

    protected $fillable = [
        'programa_pretendido',
        'area_pos',
        'interesse_bolsa',
        'vinculo_empregaticio',
        'id_inscricao_verao',
    ];

    public function retorna_escolha_candidato($id_candidato,$id_inscricao_verao)
    {
        return $this->where("id_candidato", $id_candidato)->where("id_inscricao_verao", $id_inscricao_verao)->get()->first();
    }

    public function usuarios_nao_finalizados($id_inscricao_verao)
    {
        return $this->where('id_inscricao_verao', $id_inscricao_verao)->join('users', 'users.id_user', 'escolhas_curso_verao.id_candidato')->join('programa_pos_mat', 'programa_pos_mat.id_programa_pos', 'escolhas_curso_verao.programa_pretendido')->whereNotIn('escolhas_curso_verao.id_candidato', function($query) use ($id_inscricao_verao) {
            $query->select('id_candidato')->from('finaliza_inscricao')->where('id_inscricao_verao', $id_inscricao_verao);
        } )->select('users.nome', 'programa_pos_mat.tipo_programa_pos_ptbr')->orderBy('programa_pos_mat.tipo_programa_pos_ptbr');
    }

    public function grava_escolhas_curso_verao($id_candidato,$id_inscricao_verao,$request)
    {

        $candidato_fez_escolhas = $this->retorna_escolha_candidato($id_candidato,$id_inscricao_verao);

        if (!is_null($candidato_fez_escolhas)) {
            $atualiza_escolhas = $this->where('id_candidato', $id_candidato)->where('id_inscricao_verao',$id_inscricao_verao);
            $dados_escolhas['programa_pretendido'] = (int)$request->programa_pretendido;
            if ($request->programa_pretendido == 1) {
                $dados_escolhas['area_pos'] = 10;
            }else{
                $dados_escolhas['area_pos'] = (int)$request->area_pos;
            }
            $dados_escolhas['interesse_bolsa'] = (bool)$request->interesse_bolsa;
            $dados_escolhas['vinculo_empregaticio'] = (bool)$request->vinculo_empregaticio;
            $atualiza_escolhas->update($dados_escolhas);
        }else{
            $escolhas_curso_verao = new EscolhaCandidato();
            $escolhas_curso_verao->id_candidato = $id_candidato;
            $escolhas_curso_verao->programa_pretendido = (int)$request->programa_pretendido;

            if ($request->programa_pretendido == 1) {
                $escolhas_curso_verao->area_pos = 10;
            }else{
                $escolhas_curso_verao->area_pos = (int)$request->areas_pos;
            }
            $escolhas_curso_verao->interesse_bolsa = (bool)$request->interesse_bolsa;
            $escolhas_curso_verao->vinculo_empregaticio = (bool)$request->vinculo_empregaticio;
            $escolhas_curso_verao->id_inscricao_verao = $id_inscricao_verao;
            $escolhas_curso_verao->save();
        }
    }

    public function retorna_area_distintas($id_inscricao_verao)
    {
        return $this->select('area_pos')->where('id_inscricao_verao', $id_inscricao_verao)->where('programa_pretendido', '2')->distinct()->orderBy('area_pos')->pluck('area_pos');
    }

    public function retorna_inscritos_por_area_pos($area_pos, $id_inscricao_verao)
    {
        return $this->select('id_candidato')->where('programa_pretendido', '2')->where('area_pos', $area_pos)->where('id_inscricao_verao', $id_inscricao_verao)->get()->pluck('id_candidato');
    }
}
