<?php

namespace Veraomat\Http\Controllers\Candidato;

use Auth;
use DB;
use Mail;
use Session;
use Validator;
use Purifier;
use Notification;
use Carbon\Carbon;
use Veraomat\Models\User;
use Veraomat\Models\AssociaEmailsRecomendante;
use Veraomat\Models\ConfiguraInscricaoPos;
use Veraomat\Models\OfertaCursoVerao;
use Veraomat\Models\CartaMotivacao;
use Veraomat\Models\ProgramaPos;
use Veraomat\Models\DadoPessoalCandidato;
use Veraomat\Models\Formacao;
use Veraomat\Models\Estado;
use Veraomat\Models\DadoAcademico;
use Veraomat\Models\EscolhaCursoVerao;
use Veraomat\Models\DadoPessoalRecomendante;
use Veraomat\Models\ContatoRecomendante;
use Veraomat\Models\CartaRecomendacao;
use Veraomat\Models\FinalizaInscricao;
use Veraomat\Models\Documento;
use Veraomat\Models\Paises;
use Veraomat\Models\Cidade;
use Veraomat\Notifications\NotificaRecomendante;
use Veraomat\Notifications\NotificaCandidato;
use Illuminate\Http\Request;
use Veraomat\Mail\EmailVerification;
use Veraomat\Http\Controllers\Controller;
use Veraomat\Http\Controllers\AuthController;
use Veraomat\Http\Controllers\CidadeController;
use Veraomat\Http\Controllers\BaseController;
use Veraomat\Http\Controllers\APIController;
use Illuminate\Foundation\Auth\RegistersUsers;
use Veraomat\Http\Requests;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

/**
* Classe para manipulação do candidato.
*/
class EscolhaCandidatoController extends BaseController
{



	/*
/Gravação dos escolhas do Candidato
 */
	public function getEscolhaCandidato()
	{
		$user = $this->SetUser();
		
		$id_user = $user->id_user;

		$locale_candidato = Session::get('locale');
		
		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_verao = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_verao;
		$autoriza_inscricao = $edital_ativo->autoriza_inscricao();

		if ($autoriza_inscricao) {
			$programas_disponiveis = explode("_", $edital_ativo->retorna_inscricao_ativa()->tipo_evento);

			$nome_programa_pos = new ProgramaPos();


			foreach ($programas_disponiveis as $programa) {
				$programa_para_inscricao[$programa] = $nome_programa_pos->pega_programa_pos_mat($programa, $locale_candidato);
			}

			$finaliza_inscricao = new FinalizaInscricao();

			$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user,$id_inscricao_verao);

			if ($status_inscricao) {

				notify()->flash(trans('mensagens_gerais.inscricao_finalizada'),'warning');

				return redirect()->back();
			}

			$dados = [];
			$dados['programa_pretendido'] = null;
			$dados['area_pos'] = null;
			$dados['interesse_bolsa'] = null;
			$dados['vinculo_empregaticio'] = null;
					
			$dados['nome_recomendante_1'] = null;
			$dados['nome_recomendante_2'] = null;
			$dados['nome_recomendante_3'] = null;
			$dados['email_recomendante_1'] = null;
			$dados['email_recomendante_2'] = null;
			$dados['email_recomendante_3'] = null;
			$dados['nome_recomendante_1'] = null;
			$dados['nome_recomendante_2'] = null;
			$dados['nome_recomendante_3'] = null;
			$dados['email_recomendante_1'] = null;
			$dados['email_recomendante_2'] = null;
			$dados['email_recomendante_3'] = null;

			$escolha_candidato = new EscolhaCursoVerao();

			$candidato_ja_escolheu = $escolha_candidato->retorna_escolha_candidato($id_user, $id_inscricao_verao);

			if (!is_null($candidato_ja_escolheu)) {

				$canditato_recomendante = new ContatoRecomendante();

				$contatos_recomendantes = $canditato_recomendante->retorna_recomendante_candidato($id_user,$id_inscricao_verao);

				if (count($contatos_recomendantes) > 0) {
					$i = 1;
					foreach ($contatos_recomendantes as $recomendante) {
				
						$usuario_recomendante = User::find($recomendante->id_recomendante);
					
						$dado_recomendante = new DadoPessoalRecomendante();

						$dados_recomendante = $dado_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante);
					
						$dados['email_recomendante_'.$i] = $usuario_recomendante->email;
					
						$dados['nome_recomendante_'.$i] = $dados_recomendante->nome_recomendante;

						$i++;
					}
				}

				$dados['programa_pretendido'] = $candidato_ja_escolheu->programa_pretendido;
				$dados['area_pos'] = $candidato_ja_escolheu->area_pos;
				$dados['interesse_bolsa'] = $candidato_ja_escolheu->interesse_bolsa;
				$dados['vinculo_empregaticio'] = $candidato_ja_escolheu->vinculo_empregaticio;
			}

			switch ($locale_candidato) {
			 	case 'en':
			 		$nome_coluna = 'nome_en';
			 		break;

			 	case 'es':
			 		$nome_coluna = 'nome_es';
			 		break;
			 	
			 	default:
			 		$nome_coluna = 'nome_ptbr';
			 		break;
			 }

			$oferta_verao = new OfertaCursoVerao;

			$cursos_verao = $oferta_verao->retorna_cursos_ofertados($id_inscricao_verao, $locale_candidato);
			
			return view('templates.partials.candidato.escolha_candidato')->with(compact('disable','programa_para_inscricao','cursos_verao','dados','nome_coluna'));


		}else{
			
			notify()->flash(trans('mensagens_gerais.inscricao_inativa'),'warning');
			
			return redirect()->route('home');
		}
	}

	public function postEscolhaCandidato(Request $request)
	{

		$user = $this->SetUser();
		
		$id_candidato = $user->id_user;
		
		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_verao = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_verao;
		$autoriza_inscricao = $edital_ativo->autoriza_inscricao();

		if ($autoriza_inscricao) {
			
			$finaliza_inscricao = new FinalizaInscricao();

			$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_candidato,$id_inscricao_verao);

			if ($status_inscricao) {

				notify()->flash(trans('mensagens_gerais.inscricao_finalizada'),'warning');

				return redirect()->back();
			}

			$programas_disponiveis = explode("_", $edital_ativo->retorna_inscricao_ativa()->programa);

			$this->validate($request, [
				'programa_pretendido' => 'required',
			]);

			$programa_pretendido = (int)$request->programa_pretendido;
			
			if (is_null($request->curso_desejado) and ($request->programa_pretendido === '2')) {
				
				notify()->flash(trans('mensagens_gerais.informe_area'),'warning');

				return redirect()->back();
			}

			if ($programa_pretendido === 2) {
				
				foreach ($request->curso_desejado as $escolhido) {
					
					$escolhas_curso_verao = new EscolhaCursoVerao();

					$escolhas_curso_verao->id_candidato = $id_candidato;
            		$escolhas_curso_verao->programa_pretendido = $programa_pretendido;
            		$escolhas_curso_verao->curso_verao = $escolhido;
            		$escolhas_curso_verao->id_inscricao_verao = $id_inscricao_verao;
            		$escolhas_curso_verao->save();
				}
			}
			

			dd("aqui");

			

			$email_contatos_recomendantes = [];

			for ($i=0; $i < count($request->email_recomendante); $i++) { 
				
				$email_contatos_recomendantes[$i] = Purifier::clean(strtolower(trim($request->email_recomendante[$i])));

				$associa_email = new AssociaEmailsRecomendante;

				$existe_associacao = $associa_email->retorna_associacao($email_contatos_recomendantes[$i]);

				if (!is_null($existe_associacao)) {
					$email_contatos_recomendantes[$i] = $existe_associacao;
				}
			}


			$novo_usuario = new User();
			$array_erro = [];

			for ($i=0; $i < count($email_contatos_recomendantes); $i++) {

				$novo_recomendante['nome'] = Purifier::clean($request->nome_recomendante[$i]);
				
				$novo_recomendante['email'] = $email_contatos_recomendantes[$i];

				$novo_usuario_recomendante = $novo_usuario->registra_recomendante($novo_recomendante);

				if ($novo_usuario_recomendante) {
					$array_erro[$i] = $email_contatos_recomendantes[$i];
				}
			}

			if (!empty($array_erro)) {
				notify()->flash(trans('mensagens_gerais.inicio_erro_email_recomendantes').implode(", ", $array_erro).trans('mensagens_gerais.final_erro_email_recomendantes'),'warning');
				return redirect()->back();
			}

			$contatos_recomendantes = new ContatoRecomendante();

			$candidato_recomendantes = $contatos_recomendantes->processa_indicacoes($id_candidato, $id_inscricao_verao, $email_contatos_recomendantes);

			$carta_recomendacao = new CartaRecomendacao();

			$inicia_carta = $carta_recomendacao->inicia_carta_candidato($id_candidato, $id_inscricao_verao, $email_contatos_recomendantes);
			
			notify()->flash(trans('mensagens_gerais.mensagem_sucesso'),'success');
			
			return redirect()->route('motivacao.documentos');
		}else{
			notify()->flash(trans('mensagens_gerais.inscricao_inativa'),'warning');
			
			return redirect()->route('home');
		}
	}
}