<?php

namespace sistema\Controlador;
//filha do controlador aula 55
use sistema\Nucleo\Controlador;
//postmodelo chamando view index para apresentar os dados
use sistema\Modelo\Postmodelo;
use sistema\Modelo\Usuariomodelo;
use sistema\Modelo\clienteModelo;
use sistema\Nucleo\helpers;
use Site\Modelo\CategoriaModelo;
//classe filha chamando o pai
class SiteControlador extends Controlador
{
    public function __construct()
    //diretorio definido
    { 
        parent::__construct('templates/site/views');
    } 
    /**
     * Home Page
     * @return void
     */
    public function index(): void
    {
        $posts = (new PostModelo())->busca();

        echo $this->template->renderizar('index.html', [
            'posts' => $posts,
           // 'categorias' => $this->categorias(),
                ]);
    }
    /**
     * Sobre
     * @return void
     */
    public function sobre(): void
    {
        echo $this->template->renderizar('sobre.html', [
            'titulo' => 'SOBRE'
        ]);
    }
    public function base(): void
    {
        echo $this->template->renderizar('base.html', [
            'titulo' => 'teste BASE TItulo',
            'subtitulo' => 'teste BASE de subtitulo'
        ]);
    }
    public function contatos(): void
    {
        echo $this->template->renderizar('contatos.html', [
            'titulo' => 'contato Izabel fabiano',
            'subtitulo' => 'teste CONTATO de subtitulo'
        ]);
    }
    public function servicos(): void
    {
        echo $this->template->renderizar('servicos.html', [
            'titulo' => 'SERVIÇOS  TItulo',
            'subtitulo' => 'SERVIÇOS  de subtitulo'
        ]);
    }
    
    //tbl_receita ver no local post
    public function buscar(): void
    {
        $busca = filter_input(INPUT_POST,'busca', FILTER_DEFAULT);
        if(isset($busca)){
            $posts = (new PostModelo())->pesquisa($busca);
            foreach ($posts as $post) {
                echo "<li class-'list-group-item fw-bold'><a href=".helpers::url('post/').$post->id.">$post->titulo</a></li>";
        }
    }
    }
/**
     * Busca post por ID
     * @param int $id
     * @return void
     */
    public function post(int $id):void
    {
        $post = (new PostModelo())->buscaPorId($id);
        if(!$post){
            Helpers::redirecionar('404');
        }
        
        echo $this->template->renderizar('post.html', [
            'post' => $post,
            'categorias' => $this->categorias(),
        ]);
    }
    /**
     * Clientes
     * @return array
     */
    public function cliente(): array
    {
        return (new ClienteModelo())->busca();
    }
    public function clientes(int $id):void
    {
        $posts = (new ClienteModelo())->posts($id);
        
        echo $this->template->renderizar('listar.html', [
            'clientes' => $posts,
            'categorias' => $this->clientes(),
        ]);
    }    
/**
     * Usuarios
     * @return array
     */
    public function Usuario(): array
    {
        return (new UsuarioModelo())->busca();
    }
    public function Usuarios(int $id):void
    {
        $posts = (new UsuarioModelo())->posts($id);
        
        echo $this->template->renderizar('listar.html', [
            'Usuarios' => $posts,
            //'categorias' => $this->clientes(),
        ]);
    }   
    
    /**
     * Categorias
     * @return array
     */
    public function categorias(): array
    {
        return (new CategoriaModelo())->busca();
    }

    public function categoria(int $id):void
    {
        $posts = (new CategoriaModelo())->posts($id);
        
        echo $this->template->renderizar('categoria.html', [
            'posts' => $posts,
            'categorias' => $this->categorias(),
        ]);
    }    
    
        /**
     * ERRO 404
     * @return void
     */
    public function erro404(): void
    {
        echo $this->template->renderizar('404.html', [
            'titulo' => 'Página não encontrada'
        ]);
    }    

}


