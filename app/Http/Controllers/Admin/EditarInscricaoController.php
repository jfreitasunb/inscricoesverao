<?php

namespace Posmat\Http\Controllers\Admin;

use Auth;
use DB;
use Mail;
use Session;
use Notification;
use Carbon\Carbon;
use Posmat\Models\{User, ConfiguraInscricaoPos, AreaPosMat, ProgramaPos, RelatorioController, FinalizaInscricao, ContatoRecomendante, DadoRecomendante, DadoPessoal, EscolhaCandidato, CartaRecomendacao, AssociaEmailsRecomendante};
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\Controller;
use Posmat\Http\Controllers\AuthController;
use Posmat\Http\Controllers\CoordenadorController;
use Posmat\Http\Controllers\DataTable\UserController;
use Posmat\Notifications\NotificaRecomendante;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;

/**
* Classe para visualização da página inicial.
*/
class EditarInscricaoController extends AdminController
{

	public function getEditarInscricao()
	{

		$edital = new ConfiguraInscricaoPos();

      	$edital_vigente = $edital->retorna_edital_vigente();

      	return view('templates.partials.admin.editar_inscricao')->with(compact('edital_vigente'));
	}

	public function postEditarInscricao(Request $request)
	{

		$this->validate($request, [
			'inicio_inscricao' => 'required|date_format:"Y-m-d"|before:fim_inscricao',
			'fim_inscricao' => 'required|date_format:"Y-m-d"|after:inicio_inscricao',
			'prazo_carta' => 'required|date_format:"Y-m-d"|after:inicio_inscricao',
			'edital' => 'required',
			'programa' => 'required',
		]);

		$edital_vigente = ConfiguraInscricaoPos::find((int)$request->id_inscricao_pos);

		$novos_dados_edital['inicio_inscricao'] = $request->inicio_inscricao;
		$novos_dados_edital['fim_inscricao'] = $request->fim_inscricao;
		$novos_dados_edital['prazo_carta'] = $request->prazo_carta;
		$novos_dados_edital['programa'] = $request->programa;
		$novos_dados_edital['edital'] = $request->edital;

		$edital_vigente->update($novos_dados_edital);

		notify()->flash('Inscrição alterada com sucesso!','success', ['timer' => 3000,]);

		return redirect()->route('editar.inscricao');
	}
}