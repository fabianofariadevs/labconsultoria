
<?php
// Arquivo index responsável pela inicialização do sistema

//require_once 'sistema/configuracao.php';
//include_once 'sistema/Nucleo/helpers.php';
//include './sistema/Nucleo/Mensagem.php';
//include './sistema/Nucleo/Controlador.php';
//use sistema\Modelo\PostModelo;
require 'vendor/autoload.php';



require 'rotas.php';

// AULA 71 LENDO BDADOS
/*use sistema\Modelo\Postmodelo;
 $posts = (new PostModelo())->busca();
foreach ($posts as $post) {
    echo $post->titulo.'<br/>';
}*/


/*
 * 
 *  //echo \sistema\Nucleo\helpers::cadastrar();
//aula 52 composer
$document = new \Bissolli\ValidadorCpfCnpj\CPF('123.456.789.00');
var_dump($document->isValid());
*/



