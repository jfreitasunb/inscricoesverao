<?php

namespace Veraomat\Http\Controllers\Admin;

use Auth;
use DB;
use Mail;
use Session;
use Notification;
use Carbon\Carbon;
use Veraomat\Models\{User, ConfiguraInscricaoPos, AreaPosMat, ProgramaPos, RelatorioController, FinalizaInscricao, ContatoRecomendante, DadoPessoalRecomendante, DadoPessoalCandidato, EscolhaCandidato, CartaRecomendacao, AssociaEmailsRecomendante};
use Illuminate\Http\Request;
use Veraomat\Mail\EmailVerification;
use Veraomat\Http\Controllers\Controller;
use Veraomat\Http\Controllers\AuthController;
use Veraomat\Http\Controllers\CoordenadorController;
use Veraomat\Http\Controllers\DataTable\UserController;
use Veraomat\Notifications\NotificaRecomendante;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;

/**
* Classe para visualização da página inicial.
*/
class ReativarInscricaoCandidatoController extends AdminController
{

	public function getReativarInscricaoCandidato()
	{

		$modo_pesquisa = true;

		$email_candidato = '';

		return view('templates.partials.admin.reativar_inscricao_candidato')->with(compact('modo_pesquisa', 'email_candidato'));
	}

	public function getPesquisaCandidato($email_candidato)
	{
	
		$user = new User;

		return $user->retorna_user_por_email($email_candidato)->id_user;
	}

	public function postInscricaoParaReativar(Request $request)
	{

		$this->validate($request, [
			'email_candidato' => 'required|email',
		]);

		$email_candidato = strtolower(trim($request->email_candidato));

		$id_user = $this->getPesquisaCandidato($email_candidato);

		$edital = new ConfiguraInscricaoPos;

		$edital_vigente = $edital->retorna_edital_vigente();

		$finaliza_inscricao = new FinalizaInscricao;

		$finalizou = $finaliza_inscricao->retorna_usuario_inscricao_finalizada($edital_vigente->id_inscricao_pos, $id_user, $this->locale_default);

		if (!is_null($finalizou)) {
			

			$modo_pesquisa = false;

			return view('templates.partials.admin.reativar_inscricao_candidato')->with(compact('modo_pesquisa','finalizou','email_candidato'));

		}else{
			
			notify()->flash('O candidato com e-mail: '.$email_candidato.' ainda não finalizou a inscrição!','error');

			$modo_pesquisa = true;

			return view('templates.partials.admin.reativar_inscricao_candidato')->with(compact('modo_pesquisa'));
		}
	}

	public function postReativarInscricaoCandidato(Request $request)
	{
		$this->validate($request, [
			'finalizada' => 'required',
		]);

		$id = (int)$request->id;
		$id_inscricao_pos = (int)$request->id_inscricao_pos;
		$id_user = (int)$request->id_user;
		$email_candidato = $request->email_candidato;


		$finalizada = (strtolower(trim($request->finalizada)) == 'sim' ? 1 : 0);

		if (!$finalizada) {
			$inscricao_finalizada = new FinalizaInscricao;

			DB::table('finaliza_inscricao')->where('id', $id)->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->update(['finalizada' => 'false', 'updated_at' => date('Y-m-d H:i:s') ]);

			notify()->flash('A inscrição do candidato com e-mail: '.$email_candidato.' foi reativada com sucesso!','success');

			return redirect()->route('reativar.candidato');
		}else{

			notify()->flash('Nenhuma alteração feita na inscrição do candidato: '.$email_candidato,'info');

			return redirect()->route('reativar.candidato');
		}
	}
}