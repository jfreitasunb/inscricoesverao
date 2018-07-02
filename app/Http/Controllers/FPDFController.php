<?php

namespace Veraomat\Http\Controllers;

use Auth;
use DB;
use Mail;
use Session;
use File;
use ZipArchive;
use Fpdf;
use Carbon\Carbon;
use Veraomat\Models\User;
use Veraomat\Models\ConfiguraInscricaoPos;
use Veraomat\Models\FinalizaInscricao;
use Veraomat\Models\DadoPessoal;
use Veraomat\Models\Paises;
use Veraomat\Models\Estado;
use Veraomat\Models\Cidade;
use Veraomat\Models\DadoAcademico;
use Veraomat\Models\EscolhaCandidato;
use Veraomat\Models\ContatoRecomendante;
use Veraomat\Models\CartaMotivacao;
use Veraomat\Models\AreaPosMat;
use Veraomat\Models\ProgramaPos;
use Illuminate\Http\Request;
use Veraomat\Mail\EmailVerification;
use Veraomat\Http\Controllers\Controller;
use Veraomat\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\RegistersUsers;
use League\Csv\Writer;
use Storage;

/**
* Classe para visualização da página inicial.
*/
class FPDFController extends Fpdf
{

    public function __construct(array &$dados_candidato_para_relatorio)
    {
        $this->dados = $dados_candidato_para_relatorio;
    }

    public function pdfRelatorio()
    {
        Fpdf::AddPage();
        Fpdf::SetTitle(utf8_decode('Relatório Inscrição Pós'));

        Fpdf::SetFont('Arial', '', 12);


        //Restore font and colors
        Fpdf::SetFont('Arial', '', 10);

        Fpdf::SetTextColor(0);

        Fpdf::SetFont('Arial', 'I', 10);
        $texto = "Cod: 12dfsdfdf";
        Fpdf::Cell(20, 2, utf8_decode($texto),0,1,'C');
    }


    public function fechaPDF()
    {
        $local_relatorios = public_path("/relatorios/edital_".$this->dados['edital']."/");

        File::isDirectory($local_relatorios) or File::makeDirectory($local_relatorios,077,true,true);
        

        $arquivo_relatorio = $local_relatorios.'Relatorio_'.$this->dados['id_aluno'].'.pdf';

        Fpdf::Output($arquivo_relatorio,'F');
        Fpdf::Close($arquivo_relatorio);
    }
}