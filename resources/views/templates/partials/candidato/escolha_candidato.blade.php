@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
@endsection

@section('escolha_monitoria')
<fieldset class="scheduler-border">
  <legend class="scheduler-border"></legend>
    <div class="row">
      {{trans('tela_escolha_candidato.texto_programa')}}
    </div>
</fieldset>

{!! Form::open(array('route' => 'dados.escolhas', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{trans('tela_escolha_candidato.programa_disponivel')}}</legend>
      <div class="row">
        @foreach($programa_para_inscricao as $programa => $key)
          <div class="col-md-4">
            <label class="radio-inline">{!! Form::radio('programa_pretendido', $programa, $dados['programa_pretendido'] == $programa ?: '', ['required' => '']) !!} {!! $key !!}</label>
          </div>
        @endforeach
      </div>
  </fieldset>

  @if(isset($cursos_verao))
    <fieldset class="scheduler-border">
      <legend class="scheduler-border">{{trans('tela_escolha_candidato.texto_cursos_verao')}}</legend>
        <div class="row"">
            @foreach ($cursos_verao as $curso)
              <div class="col-md-4">
                <label class="radio-inline">{!! Form::checkbox('curso_desejado[]', $curso->id_curso_verao, False , []) !!}{{ " ".$curso->$nome_coluna }}{{ $curso->seleciona_pos ? " (Seleciona para a Pós)" : "" }}</label>
              </div>    
            @endforeach
        </div>
    </fieldset>
  @endif

  <fieldset class="scheduler-border">
  <legend class="scheduler-border"></legend>
    <div class="row">
      {{trans('tela_escolha_candidato.texto_recomendantes')}}
    </div>
  </fieldset>

  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{trans('tela_escolha_candidato.recomendante')}}</legend>
      <div class="row">
        <div class="col-md-4">
          {!! Form::label('recomendante_1', '1) '.trans('tela_escolha_candidato.nome'), ['class' => 'control-label emailrecomendante']) !!}
          {!! Form::text('nome_recomendante[]', $dados['nome_recomendante_1'] ?: '' , ['class' => 'emailrecomendante', 'required' => '']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('email_1', 'E-mail: ', ['class' => 'control-label']) !!}
          {!! Form::text('email_recomendante[]', $dados['email_recomendante_1'] ?: '' , ['id' => 'email_recomendante_1', 'class' => 'emailrecomendante', 'required' => '', 'data-parsley-type' => 'email']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('email_1', trans('tela_escolha_candidato.confirmar_email'), ['class' => 'control-label']) !!}
          {!! Form::text('confirmar_email_recomendante[]',null , ['class' => 'emailrecomendante', 'required' => '', 'data-parsley-type' => 'email', 'data-parsley-equalto' => '#email_recomendante_1']) !!}
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          {!! Form::label('recomendante_2', '2) '.trans('tela_escolha_candidato.nome'), ['class' => 'control-label emailrecomendante']) !!}
          {!! Form::text('nome_recomendante[]', $dados['nome_recomendante_2'] ?: '' , ['class' => 'emailrecomendante', 'required' => '']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('email_2', 'E-mail: ', ['class' => 'control-label']) !!}
          {!! Form::text('email_recomendante[]',$dados['email_recomendante_2'] ?: '' , ['id' => 'email_recomendante_2', 'class' => 'emailrecomendante', 'required' => '', 'data-parsley-type' => 'email']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('email_2', trans('tela_escolha_candidato.confirmar_email'), ['class' => 'control-label']) !!}
          {!! Form::text('confirmar_email_recomendante[]',null , ['class' => 'emailrecomendante', 'required' => '', 'data-parsley-type' => 'email', 'data-parsley-equalto' => '#email_recomendante_2']) !!}
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          {!! Form::label('recomendante_3', '3) '.trans('tela_escolha_candidato.nome'), ['class' => 'control-label emailrecomendante']) !!}
          {!! Form::text('nome_recomendante[]', $dados['nome_recomendante_3'] ?: '' , ['class' => 'emailrecomendante', 'required' => '']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('email_3', 'E-mail: ', ['class' => 'control-label']) !!}
          {!! Form::text('email_recomendante[]',$dados['email_recomendante_3'] ?: '' , ['id' => 'email_recomendante_3', 'class' => 'emailrecomendante', 'required' => '', 'data-parsley-type' => 'email']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('email_3', trans('tela_escolha_candidato.confirmar_email'), ['class' => 'control-label']) !!}
          {!! Form::text('confirmar_email_recomendante[]',null , ['class' => 'emailrecomendante', 'required' => '', 'data-parsley-type' => 'email', 'data-parsley-equalto' => '#email_recomendante_3']) !!}
        </div>
      </div>
  </fieldset>
  
      <div class="form-group">
        <div class="row">
          <div class="col-md-6 col-md-offset-3 text-center">
            {!! Form::submit(trans('tela_escolha_candidato.menu_enviar'), ['class' => 'btn btn-primary btn-lg register-submit']) !!}
          </div>
        </div>
      </div>
      {!! Form::close() !!}
  
@endsection

@section('scripts')
  {!! Html::script( asset('js/parsley.min.js') ) !!}
  {!! Html::script( asset('i18n/pt-br.js') ) !!}
@endsection
