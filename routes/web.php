<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/get-cidades/{idEstado}', '\Posmat\Http\Controllers\CandidatoController@getCidades');

Route::get('api/dependent-dropdown','APIController@index');
Route::get('api/get-state-list','APIController@getStateList');
Route::get('api/get-city-list','APIController@getCityList');

/*
*Área do candidato
*/


Route::prefix('candidato')->middleware('user.role:candidato,admin','define.locale')->group(function () {
	
	Route::get('/', '\Posmat\Http\Controllers\Candidato\CandidatoController@getMenu')->name('menu.candidato');

	Route::get('dados/pessoais', '\Posmat\Http\Controllers\Candidato\DadosPessoaisController@getDadosPessoais')->name('dados.pessoais');

	Route::get('dados/pessoais/editar', '\Posmat\Http\Controllers\Candidato\DadosPessoaisController@getDadosPessoaisEditar')->name('dados.pessoais.editar');

	Route::post('dados/pessoais', '\Posmat\Http\Controllers\Candidato\DadosPessoaisController@postDadosPessoais')->name('dados.pessoais.salvar');

	Route::get('dados/academicos', '\Posmat\Http\Controllers\Candidato\DadosAcademicosController@getDadosAcademicos')->name('dados.academicos');

	Route::post('dados/academicos', '\Posmat\Http\Controllers\Candidato\DadosAcademicosController@postDadosAcademicos');

	Route::get('dados/escolhas', '\Posmat\Http\Controllers\Candidato\EscolhaCandidatoController@getEscolhaCandidato')->name('dados.escolhas');

	Route::post('dados/escolhas', '\Posmat\Http\Controllers\Candidato\EscolhaCandidatoController@postEscolhaCandidato');

	Route::get('motivacao/documentos', '\Posmat\Http\Controllers\Candidato\MotivacaoDocumentosController@getMotivacaoDocumentos')->name('motivacao.documentos');

	Route::post('motivacao/documentos', '\Posmat\Http\Controllers\Candidato\MotivacaoDocumentosController@postMotivacaoDocumentos');

	Route::get('finalizar/inscricao', '\Posmat\Http\Controllers\Candidato\FinalizarInscricaoController@getFinalizarInscricao')->name('finalizar.inscricao');

	Route::post('finalizar/inscricao', '\Posmat\Http\Controllers\Candidato\FinalizarInscricaoController@postFinalizarInscricao');

	Route::get('status/cartas', '\Posmat\Http\Controllers\Candidato\StatusCartasController@getStatusCartas')->name('status.cartas');

	Route::post('status/cartas', '\Posmat\Http\Controllers\Candidato\StatusCartasController@postStatusCartas');
});



/*
*Área do Recomendante
*/
Route::prefix('recomendante')->middleware('user.role:recomendante,admin','define.locale')->group(function () {

	Route::get('/', '\Posmat\Http\Controllers\Recomendante\RecomendanteController@getMenu')->name('menu.recomendante');

	Route::get('dados/pessoais', '\Posmat\Http\Controllers\Recomendante\DadosPessoaisRecomendanteController@getDadosPessoaisRecomendante')->name('dados.recomendante');

	Route::get('dados/pessoais/editar', '\Posmat\Http\Controllers\Recomendante\DadosPessoaisRecomendanteController@getDadosPessoaisRecomendanteEditar')->name('dados.recomendante.editar');

	Route::post('dados/pessoais', '\Posmat\Http\Controllers\Recomendante\DadosPessoaisRecomendanteController@postDadosPessoaisRecomendante')->name('dados.recomendante.salvar');

	Route::get('cartas/pendentes', '\Posmat\Http\Controllers\Recomendante\CartasPendentesController@getCartasPendentes')->name('cartas.pendentes');

	Route::post('cartas/pendentes', '\Posmat\Http\Controllers\Recomendante\CartasPendentes\PreencherCartaController@postCartasPendentes');

	Route::post('carta/inicial', '\Posmat\Http\Controllers\Recomendante\PreencherCartaController@postCartaInicial')->name('carta.inicial');

	Route::post('salva/carta/inicial', '\Posmat\Http\Controllers\Recomendante\PreencherCartaController@postPreencherCarta')->name('salva.carta.inicial');

	Route::get('preencher/carta/final', '\Posmat\Http\Controllers\Recomendante\PreencherCartaController@getFinalizarCarta')->name('finalizar.carta');

	Route::post('preencher/carta/final', '\Posmat\Http\Controllers\Recomendante\PreencherCartaController@postFinalizarCarta')->name('finalizar.carta');

	Route::get('cartas/anteriores', '\Posmat\Http\Controllers\Recomendante\CartasAnterioresController@getCartasAnteriores')->name('cartas.anteriores');

	Route::get('visualiza/anteriores', '\Posmat\Http\Controllers\Recomendante\CartasAnterioresController@GeraCartasAnteriores')->name('ver.anterior');
});

/*
*Área do Admin
 */

Route::prefix('admin')->middleware('user.role:admin', 'impersonate.user')->group(function () {

	Route::get('/', '\Posmat\Http\Controllers\Admin\AdminController@getMenu')->name('menu.admin');

	Route::get('contas/users/impersonate','\Posmat\Http\Controllers\Admin\ImpersonateController@index')->name('admin.impersonate');

	Route::post('contas/users/impersonate','\Posmat\Http\Controllers\Admin\ImpersonateController@store');

	Route::delete('contas/users/impersonate','\Posmat\Http\Controllers\Admin\ImpersonateController@destroy');

	Route::get('contas/users/link/senha', '\Posmat\Http\Controllers\Admin\LinkSenhaController@getPesquisaLinkMudarSenha')->name('pesquisa.email.muda.senha');

	Route::post('contas/users/link/senha', '\Posmat\Http\Controllers\Admin\LinkSenhaController@postPesquisaLinkMudarSenha')->name('pesquisa.email.muda.senha');

	Route::get('contas/pesquisa/conta', '\Posmat\Http\Controllers\Admin\PesquisaContaController@getPesquisaConta')->name('pesquisa.usuario');

	Route::post('contas/pesquisa/conta', '\Posmat\Http\Controllers\Admin\PesquisaContaController@postPesquisaConta')->name('pesquisa.usuario');

	Route::post('contas/altera/conta', '\Posmat\Http\Controllers\Admin\PesquisaContaController@postAlteraAtivaConta')->name('altera.ativa.conta');

	Route::get('contas/lista/inativos', '\Posmat\Http\Controllers\Admin\ListaInativosController@getListaInativos')->name('lista.inativos');

	Route::post('contas/lista/inativos', '\Posmat\Http\Controllers\Admin\ListaInativosController@postListaInativos')->name('lista.inativos');

	Route::get('contas/associa/email/recomendante', '\Posmat\Http\Controllers\Admin\AssociaEmailController@getAssociaEmail')->name('associa.recomendantes');

	Route::post('contas/associa/email/recomendante', '\Posmat\Http\Controllers\Admin\AssociaEmailController@postAssociaEmail')->name('associa.recomendantes');

	Route::get('contas/visualiza/associacoes', '\Posmat\Http\Controllers\Admin\VisualizaAssociacoesController@getAssociacoes')->name('visualiza.associacoes');

	Route::get('inscricao/editar', '\Posmat\Http\Controllers\Admin\EditarInscricaoController@getEditarInscricao')->name('editar.inscricao');

	Route::post('inscricao/editar', '\Posmat\Http\Controllers\Admin\EditarInscricaoController@postEditarInscricao');

	Route::get('inscricao/reativar/candidato', '\Posmat\Http\Controllers\Admin\ReativarInscricaoCandidatoController@getReativarInscricaoCandidato')->name('reativar.candidato');

	Route::post('inscricao/pesquisa/candidato', '\Posmat\Http\Controllers\Admin\ReativarInscricaoCandidatoController@postInscricaoParaReativar')->name('pesquisa.candidato');

	Route::get('inscricao/salvar/alteracao', '\Posmat\Http\Controllers\Admin\ReativarInscricaoCandidatoController@getSalvaReativacao')->name('salvar.alteracao');

	Route::post('inscricao/salvar/alteracao', '\Posmat\Http\Controllers\Admin\ReativarInscricaoCandidatoController@postReativarInscricaoCandidato')->name('salvar.alteracao');

	Route::get('inscricao/pesquisa/recomendantes', '\Posmat\Http\Controllers\Admin\MudaRecomendanteController@getPesquisarRecomendantes')->name('pesquisa.recomendantes');

	Route::post('inscricao/pesquisa/recomendantes', '\Posmat\Http\Controllers\Admin\MudaRecomendanteController@postPesquisarRecomendantes')->name('pesquisa.recomendantes');

	Route::post('inscricao/altera/recomendante','\Posmat\Http\Controllers\Admin\MudaRecomendanteController@postAlteraRecomendante')->name('altera.recomendante');


	Route::get('inscricao/pesquisa/cartas/enviadas', '\Posmat\Http\Controllers\Admin\PesquisaRecomendanteController@getPesquisarCartaEnviada')->name('pesquisa.carta');

	Route::post('inscricao/pesquisa/cartas/enviadas', '\Posmat\Http\Controllers\Admin\PesquisaRecomendanteController@postPesquisarCartaEnviada')->name('pesquisa.carta');

	Route::post('inscricao/reativar/carta/enviada', '\Posmat\Http\Controllers\Admin\PesquisaRecomendanteController@postReativarCartaEnviada')->name('reativar.carta');

	Route::get('inscricao/acha/indicacoes', '\Posmat\Http\Controllers\Admin\ListaQuemIndicouController@getAchaIndicacoes')->name('pesquisa.indicacoes');

	Route::post('inscricao/acha/indicacoes', '\Posmat\Http\Controllers\Admin\ListaQuemIndicouController@postAchaIndicacoes')->name('pesquisa.indicacoes');

	Route::get('chart', '\Posmat\Http\Controllers\GraficosController@index')->name('ver.charts');

	Route::get('inscricoes/nao/finalizadas', '\Posmat\Http\Controllers\Admin\ListaInscricaoNaoFinalizadasController@getInscricoesNaoFinalizadas')->name('inscricoes.nao.finalizadas');

});

Route::resource('admin/datatable/users', 'DataTable\UserController');



/*
*Área do coordenador
 */

Route::prefix('coordenador')->middleware('user.role:coordenador,admin')->group(function () {

	Route::get('/','\Posmat\Http\Controllers\Coordenador\CoordenadorController@getMenu')->name('menu.coordenador');

	Route::get('configura/inscricao', '\Posmat\Http\Controllers\Coordenador\ConfiguraInscricaoPosController@getConfiguraInscricaoPos')->name('configura.inscricao');

	Route::post('configura/inscricao', '\Posmat\Http\Controllers\Coordenador\ConfiguraInscricaoPosController@postConfiguraInscricaoPos');

	Route::get('cadastra/area/pos', '\Posmat\Http\Controllers\Coordenador\CadastraAreaPosController@getCadastraAreaPos')->name('cadastra.area.pos');

	Route::post('cadastra/area/pos', '\Posmat\Http\Controllers\Coordenador\CadastraAreaPosController@postCadastraAreaPos');

	Route::get('editar/area/pos', '\Posmat\Http\Controllers\Coordenador\EditarAreaPosController@getEditarAreaPos')->name('editar.area.pos');

	Route::post('editar/area/pos', '\Posmat\Http\Controllers\Coordenador\EditarAreaPosController@postEditarAreaPos');

	Route::get('editar/formacao', '\Posmat\Http\Controllers\Coordenador\EditarFormacaoController@getEditarFormacao')->name('editar.formacao');

	Route::post('editar/formacao', '\Posmat\Http\Controllers\Coordenador\EditarFormacaoController@postEditarFormacao');

	Route::get('relatorio/{id_monitoria}', '\Posmat\Http\Controllers\RelatorioController@geraRelatorio')->name('gera.relatorio');

	Route::get('relatorio', '\Posmat\Http\Controllers\RelatorioController@getListaRelatorios')->name('relatorio.atual');

	Route::get('relatorio/link/acesso', '\Posmat\Http\Controllers\Coordenador\LinkAcessoController@getLinkAcesso')->name('link.acesso');

	Route::post('relatorio/link/acesso', '\Posmat\Http\Controllers\Coordenador\LinkAcessoController@postLinkAcesso')->name('link.acesso');

	Route::get('gera/ficha/individual', '\Posmat\Http\Controllers\Coordenador\RelatorioPosController@getFichaInscricaoPorCandidato')->name('gera.ficha.individual');

	Route::get('ver/ficha/individual', '\Posmat\Http\Controllers\Coordenador\RelatorioPosController@GeraPdfFichaIndividual')->name('ver.ficha.individual');

	Route::get('relatorios/anteriores/{id_monitoria}', '\Posmat\Http\Controllers\RelatorioController@geraRelatoriosAnteriores')->name('gera.anteriores');

	Route::get('relatorios/anteriores', '\Posmat\Http\Controllers\RelatorioController@getListaRelatoriosAnteriores')->name('relatorio.anteriores');

	Route::get('inscricao/lista/recomendacoes', '\Posmat\Http\Controllers\Admin\ListaTodasIndicacoesController@getListaIndicacoes')->name('lista.recomendacoes');

	Route::post('inscricao/lista/recomendacoes', '\Posmat\Http\Controllers\Admin\ListaTodasIndicacoesController@postListaIndicacoes');
});



/**
* Logout
 */

Route::get('/logout', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\AuthController@getLogout',
		'as'	=> 'auth.logout',
		'middleware' => ['define.locale'],
]);

Route::post('/login', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\AuthController@postLogin',
]);

/**
* Logar
 */

Route::get('/login', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\AuthController@getLogin',
		'as'	=> 'auth.login',
		'middleware' => ['guest', 'define.locale'],
]);

Route::post('/login', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\AuthController@postLogin',
		'middleware' => ['guest', 'define.locale'],
]);

Route::get('register/verify/{token}',[
	'uses' => '\Posmat\Http\Controllers\Auth\AuthController@verify',
	'middleware' => ['guest'],
]);

/**
* Registrar
 */
Route::get('/registrar', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\AuthController@getSignup',
		'as'	=> 'auth.registrar',
		'middleware' => ['guest','autoriza.inscricao','define.locale']
]);

Route::post('/registrar', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\AuthController@postSignup',
		'middleware' => ['guest','autoriza.inscricao','define.locale']
]);

/*
*Password Reset Routes
 */

Route::get('esqueci/senha', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm',
		'as'	=> 'password.request',
		'middleware' => ['guest', 'define.locale'],
]);

Route::post('esqueci/senha/link', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail',
		'as' => 'password.email',
		'middleware' => ['guest', 'define.locale'],
]);

Route::get('/esqueci/senha/{token}', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\ResetPasswordController@showResetForm',
		'as' => 'password.reset',
		'middleware' => ['guest', 'define.locale'],
]);

Route::post('/esqueci/senha/{token}', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\ResetPasswordController@reset',
		'as' => 'password.reset',
		'middleware' => ['guest', 'define.locale'],
]);

Route::get('/mudousenha', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\AuthController@getMudouSenha',
		'as'	=> 'mudou.senha',
		'middleware' => ['guest', 'define.locale'],
]);

/**
* Alertas
 */
Route::get('/alert', function () {
	return redirect()->route('home')->with('info', 'Sucess.');
});

/**
* Home
 */
Route::get('/', [
		'uses'	=> '\Posmat\Http\Controllers\HomeController@index',
		'as'	=> 'home',
		'middleware' => ['define.locale'],
]);

/*
*Seleção de Idioma
*/

Route::get('/ptbr', [
	'uses' => '\Posmat\Http\Controllers\HomeController@getLangPortuguese',
	'as'   => 'lang.portuguese',
	'middleware' => ['define.locale'],
]);

Route::get('/en', [
	'uses' => '\Posmat\Http\Controllers\HomeController@getLangEnglish',
	'as'   => 'lang.english',
	'middleware' => ['define.locale'],
]);

Route::get('/es', [
	'uses' => '\Posmat\Http\Controllers\HomeController@getLangSpanish',
	'as'   => 'lang.spanish',
	'middleware' => ['define.locale'],
]);

Route::get('/migracao', [
	'uses' => '\Posmat\Http\Controllers\MigracaoController@getMigracao',
	'as'   => 'migra.dados',
	'middleware' =>['user.role:admin']
]);

Route::get('/acesso/arquivos', '\Posmat\Http\Controllers\Coordenador\AcessoArquivosController@getVerArquivos')->name('ver.arquivos')->middleware('validaassinatura');