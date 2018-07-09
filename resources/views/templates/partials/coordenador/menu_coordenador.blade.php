<div class="row">
    <div class="col-sm-3 col-md-2">
        <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseDois"><span class="glyphicon glyphicon-file fa-fw">
                            </span>Inscrições</a>
                        </h4>
                    </div>
                    <div id="collapseDois" class="panel-collapse collapse {{ $keep_open_accordion_inscricoes }}">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('configura.inscricao') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-wrench fa-fw"></span><a href="{{ route('configura.inscricao') }}">Configurar Inscrição</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('cadastra.area.pos') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-pencil fa-fw"></span><a href="{{ route('cadastra.area.pos') }}">Cadastrar novo Curso</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('editar.area.pos') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-refresh fa-fw"></span><a href="{{ route('editar.area.pos') }}">Editar Formação</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('inscricoes.nao.finalizadas') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-list fa-fw"></span><a href="{{ route('inscricoes.nao.finalizadas') }}">Inscrições Não Finalizadas</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTres"><span class="glyphicon glyphicon-file fa-fw">
                            </span>Relatórios</a>
                        </h4>
                    </div>
                    <div id="collapseTres" class="panel-collapse collapse {{ $keep_open_accordion_relatorios }}">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('relatorio.atual') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-duplicate fa-fw"></span><a href="{{ route('relatorio.atual') }}">Edital Vigente</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('relatorio.anteriores') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-backward fa-fw"></span><a href="{{ route('relatorio.anteriores') }}">Edital Anterior</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('gera.ficha.individual') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-file fa-fw"></span><a href="{{ route('gera.ficha.individual') }}">Por Candidato</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('ver.charts') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-stats fa-fw"></span><a href="{{ route('ver.charts') }}">Gráficos</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <span class="glyphicon glyphicon-log-out fa-fw"></span><a href="{{ route('auth.logout') }}">Sair</a>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-10">
            <div class="menuadmin well">
                @yield('cadastra_area_pos')
                @yield('configura_inscricao')
                @yield('edita_area_pos')
                @yield('nao_finalizadas')
                @yield('relatorio_pos_edital_vigente')
                @yield('relatorio_pos_editais_anteriores')
                @yield('ficha_individual')
                @yield('graficos')
            </div>
        </div>
    </div>