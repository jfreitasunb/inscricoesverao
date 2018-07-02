<?php

namespace Veraomat\Http\Controllers\Coordenador;

use Auth;
use DB;
use Mail;
use Session;
use File;
use PDF;
use Notification;
use Carbon\Carbon;
use Veraomat\Models\User;
use Veraomat\Models\ConfiguraInscricaoPos;
use Veraomat\Models\CursoVeraoMat;
use Veraomat\Models\CartaRecomendacao;
use Veraomat\Models\Formacao;
use Veraomat\Models\ProgramaPos;
use Veraomat\Models\FinalizaInscricao;
use Veraomat\Notifications\NotificaNovaInscricao;
use Illuminate\Http\Request;
use Veraomat\Mail\EmailVerification;
use Veraomat\Http\Controllers\BaseController;
use Veraomat\Http\Controllers\CidadeController;
use Veraomat\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\RegistersUsers;


/**
* Classe para visualização da página inicial.
*/
class ConfiguraInscricaoPosController extends CoordenadorController
{

	public function getConfiguraInscricaoPos()
	{

		$inscricao_pos = new ConfiguraInscricaoPos();

		$programas_pos_mat = ProgramaPos::get()->all();

        $cursos_verao_mat = CursoVeraoMat::get()->all();

		return view('templates.partials.coordenador.configurar_inscricao')->with(compact('programas_pos_mat', 'cursos_verao_mat'));
	}

	public function postConfiguraInscricaoPos(Request $request)
	{

		$this->validate($request, [
			'inicio_inscricao' => 'required|date_format:"d/m/Y"|before:fim_inscricao|after:today',
			'fim_inscricao' => 'required|date_format:"d/m/Y"|after:inicio_inscricao|after:today',
			'escolhas_coordenador' => 'required',
		]);


		$configura_nova_inscricao_pos = new ConfiguraInscricaoPos();

		$user = Auth::user();
    
    	$inicio = Carbon::createFromFormat('d/m/Y', $request->inicio_inscricao);
    	$fim = Carbon::createFromFormat('d/m/Y', $request->fim_inscricao);
    	$prazo = Carbon::createFromFormat('d/m/Y', $request->prazo_carta);

    	$data_inicio = $inicio->format('Y-m-d');
    	$data_fim = $fim->format('Y-m-d');
    	$prazo_carta = $prazo->format('Y-m-d');


    	if ($configura_nova_inscricao_pos->autoriza_configuracao_inscricao($data_inicio)) {

    		$configura_nova_inscricao_pos->inicio_inscricao = $data_inicio;
			$configura_nova_inscricao_pos->fim_inscricao = $data_fim;
			$configura_nova_inscricao_pos->prazo_carta = $prazo_carta;
			$configura_nova_inscricao_pos->edital = $request->edital_ano."-".$request->edital_numero;
			$configura_nova_inscricao_pos->programa = implode("_", $request->escolhas_coordenador);
			$configura_nova_inscricao_pos->id_coordenador = $user->id_user;

			$temp_file = $request->edital->store("arquivos_temporarios");

        	$nome_temporario_edital = $local_documentos.$temp_file;

	        $nome_final_edital = $arquivos_editais."Edital_MAT_".$configura_nova_inscricao_pos->edital.".pdf";

			if (File::copy($nome_temporario_edital,$nome_final_edital)) {
				
				File::delete($nome_temporario_edital);
				$configura_nova_inscricao_pos->save();

				$dados_email['inicio_inscricao'] = $request->inicio_inscricao;
				$dados_email['fim_inscricao'] = $request->fim_inscricao;
				$dados_email['prazo_carta'] = $request->prazo_carta;

				foreach ($request->escolhas_coordenador as $key) {
					
					$nome_programa_pos = new ProgramaPos();

					$temp[] = $nome_programa_pos->pega_programa_pos_mat($key, $this->locale_default);
				}

				$dados_email['programa'] = implode('/', $temp);

				Notification::send(User::find('1'), new NotificaNovaInscricao($dados_email));

				notify()->flash('Inscrição configurada com sucesso.','success');
				return redirect()->route('configura.inscricao');


			}else{
				notify()->flash('Houve um problema na hora de enviar o edital. Tente novamente.','error');
				return redirect()->route('configura.inscricao');
			}
    	}else{
    		notify()->flash('Já existe uma inscrição ativa para esse período.','error');
			return redirect()->back('configura.inscricao');
    	}
	}
}