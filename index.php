<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

<?php
// Arquivo index responsável pela inicialização do sistema

//require_once 'sistema/configuracao.php';
//include_once 'sistema/Nucleo/helpers.php';
//include './sistema/Nucleo/Mensagem.php';
//***include './sistema/Nucleo/Controlador.php';
//use sistema\Modelo\PostModelo;
require 'vendor/autoload.php';



require 'rotas.php';

// AULA 71 LENDO BDADOS
/*use sistema\Modelo\Postmodelo;
 $posts = (new PostModelo())->busca();
foreach ($posts as $post) {
    echo $post->titulo.'<br/>';
}*/


/* //echo \sistema\Nucleo\helpers::cadastrar();
//aula 52 composer
$document = new \Bissolli\ValidadorCpfCnpj\CPF('123.456.789.00');
var_dump($document->isValid());
*/



