<?php

namespace Veraomat\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class EscolhaCandidato extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'escolhas_candidato';

    protected $fillable = [
        'programa_pretendido',
        'area_pos',
        'interesse_bolsa',
        'vinculo_empregaticio',
        'id_inscricao_pos',
    ];

    public function retorna_escolha_candidato($id_candidato,$id_inscricao_pos)
    {
        return $this->where("id_candidato", $id_candidato)->where("id_inscricao_pos", $id_inscricao_pos)->get()->first();
    }

    public function usuarios_nao_finalizados($id_inscricao_pos)
    {
        return $this->where('id_inscricao_pos', $id_inscricao_pos)->join('users', 'users.id_user', 'escolhas_candidato.id_candidato')->join('programa_pos_mat', 'programa_pos_mat.id_programa_pos', 'escolhas_candidato.programa_pretendido')->whereNotIn('escolhas_candidato.id_candidato', function($query) use ($id_inscricao_pos) {
            $query->select('id_candidato')->from('finaliza_inscricao')->where('id_inscricao_pos', $id_inscricao_pos);
        } )->select('users.nome', 'programa_pos_mat.tipo_programa_pos_ptbr')->orderBy('programa_pos_mat.tipo_programa_pos_ptbr');
    }

    public function grava_escolhas_candidato($id_candidato,$id_inscricao_pos,$request)
    {

        $candidato_fez_escolhas = $this->retorna_escolha_candidato($id_candidato,$id_inscricao_pos);

        if (!is_null($candidato_fez_escolhas)) {
            $atualiza_escolhas = $this->where('id_candidato', $id_candidato)->where('id_inscricao_pos',$id_inscricao_pos);
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
            $escolhas_candidato = new EscolhaCandidato();
            $escolhas_candidato->id_candidato = $id_candidato;
            $escolhas_candidato->programa_pretendido = (int)$request->programa_pretendido;

            if ($request->programa_pretendido == 1) {
                $escolhas_candidato->area_pos = 10;
            }else{
                $escolhas_candidato->area_pos = (int)$request->areas_pos;
            }
            $escolhas_candidato->interesse_bolsa = (bool)$request->interesse_bolsa;
            $escolhas_candidato->vinculo_empregaticio = (bool)$request->vinculo_empregaticio;
            $escolhas_candidato->id_inscricao_pos = $id_inscricao_pos;
            $escolhas_candidato->save();
        }
    }

    public function retorna_area_distintas($id_inscricao_pos)
    {
        return $this->select('area_pos')->where('id_inscricao_pos', $id_inscricao_pos)->where('programa_pretendido', '2')->distinct()->orderBy('area_pos')->pluck('area_pos');
    }

    public function retorna_inscritos_por_area_pos($area_pos, $id_inscricao_pos)
    {
        return $this->select('id_candidato')->where('programa_pretendido', '2')->where('area_pos', $area_pos)->where('id_inscricao_pos', $id_inscricao_pos)->get()->pluck('id_candidato');
    }
}
