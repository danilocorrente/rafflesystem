<?php

function onlyNumbers($number){
    return preg_replace('/[^0-9]/', '', $number);
}
function makeDirPath($path) {
    return file_exists($path) || mkdir($path, 0777, true);
  }
  function tirarAcentos($string){

    $comAcentos = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú');

    $semAcentos = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', '0', 'U', 'U', 'U');

    $replace = str_replace($comAcentos, $semAcentos, $string);
    return strtolower($replace);

    // return preg_replace("[^a-zA-Z0-9_]", "", strtr($string, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
    // return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}

  function saudacao( $nome = '' ) {
	date_default_timezone_set('America/Sao_Paulo');
	$hora = date('H');
	if( $hora >= 6 && $hora <= 12 )
		return 'Bom dia' . (empty($nome) ? '' : ', ' . $nome);
	else if ( $hora > 12 && $hora <=18  )
		return 'Boa tarde' . (empty($nome) ? '' : ', ' . $nome);
	else
		return 'Boa noite' . (empty($nome) ? '' : ', ' . $nome);
}
function codUnRetrieve($unidade){

    switch ($unidade) {
        case 'patriarca':
            $cod_un = 1;
            break;
        case 'imperador':
            $cod_un = 2;
            break;
        case 'boteco':
            $cod_un = 3;
            break;
        default:
            $cod_un = 0;
            break;
    }

    return $cod_un;
}
function reverseCodName($cod_unidade){
    switch ($cod_unidade) {
        case 1:
            $nome_unidade = "Patriarca";
            break;
        case 2:
            $nome_unidade = "Imperador";
            break;
        case 3:
            $nome_unidade = "Boteco";
            break;
        default:
            $nome_unidade = "{$cod_unidade} | Não localizado. ";
            break;
    }

    return $nome_unidade;
}

function selectDiasSemana(){
    return [0 => 'Domingo', 1 => 'Segunda-feira', 2 => 'Terça-feira', 3 => 'Quarta-feira', 4 => 'Quinta-Feira' , 5 => 'Sexta-Feira' , 6 => 'Sábado'];
}

function positivoOuNegativo($valor){
    return ($valor < 0 ) ? "<span class='label label-danger'>R$".number_format($valor,2,',','.')."</span>" : "R$".number_format($valor,2,',','.');
}
