<?php

namespace sistema\Controlador;
//filha do controlador aula 55
use sistema\Nucleo\Controlador;
//postmodelo chamando view index para apresentar os dados
//use sistema\Modelo\PostModelo;
use sistema\Modelo\UsuarioModelo;
//use sistema\Modelo\FornecedorModelo;
//use sistema\Modelo\MixProdutosModelo;
//use sistema\Modelo\ClienteModelo;
use sistema\Nucleo\Helpers;
//use Site\Modelo\CategoriaModelo;
use sistema\Nucleo\Sessao;
//classe filha chamando o pai
class UsuarioControlador extends Controlador
{
    public function __construct()
    //diretorio definido
    { 
        parent::__construct('templates/site/views');
    } 
    /**Busca usuário pela sessão
     * Home Page
     * @return UsuarioModelo / null
     */
    public static function usuario(): ?UsuarioModelo
     {
        $sessao = new Sessao();
        if(!$sessao->checar('usuarioId')){
            return null;
        }
        
        return (new UsuarioModelo())->buscaPorId($sessao->usuarioId);
    }

}


