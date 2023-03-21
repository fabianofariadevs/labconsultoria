<?php

namespace sistema\Controlador;
//filha do controlador aula 55
use sistema\Nucleo\Controlador;
//postmodelo chamando view index para apresentar os dados
use sistema\Modelo\PostModelo;
//use sistema\Modelo\UsuarioModelo;
//use sistema\Modelo\FornecedorModelo;
//use sistema\Modelo\MixProdutosModelo;
//use sistema\Modelo\ClienteModelo;
use sistema\Nucleo\Helpers;
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
        $posts = (new PostModelo())->busca("status = 1");
        
        echo $this->template->renderizar('index.html', [
            'posts' => $posts->resultado(true),
            'categorias' => $this->categorias(),
        ]);
    }
    
    /**
     * Sobre
     * @return void
     */
    public function sobre(): void
    {
        echo $this->template->renderizar('sobre.html', [
            'titulo' => 'SOBRE',
            'categorias' => $this->categorias(),
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
    public function buscar():void
    {
        $busca = filter_input(INPUT_POST,'busca', FILTER_DEFAULT);
        if(isset($busca)){
            $posts = (new PostModelo())->busca("status = 1 AND titulo LIKE '%{$busca}%'")->resultado(true);
            
            foreach ($posts as $post){
                echo "<li class='list-group-item fw-bold'><a href=".Helpers::url('post/').$post->id.">$post->titulo</a></li>";
            }
        }
        
    }
/**
     * Busca post por ID
     * @param int $id
     * @return void
     */
    public function post(string $slug):void
    {
        $post = (new PostModelo())->buscaPorId($slug);
        if(!$post){
            Helpers::redirecionar('404');
        }
        $post->salvarVisitas();
        
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
            'clientes' => $this->clientes(),
        ]);
    }    
    /**
     * Usuarios
     * @return array
     */
    public function usuarios(): array
    {
        return (new UsuarioModelo())->busca();
    }
    public function usuario(int $id):void
    {
        $posts = (new UsuarioModelo())->posts($id);
        
        echo $this->template->renderizar('listar.html', [
            'usuarios' => $posts,
            'categorias' => $this->usuarios(),
        ]);
    }   
    /**
     * Fornecedor
     * @return array
     */
    public function fornecedor(): array
    {
        return (new FornecedorModelo())->busca();
    }
    public function fornecedores(int $id):void
    {
        $posts = (new FornecedorModelo())->posts($id);
        
        echo $this->template->renderizar('listar.html', [
            'fornecedor' => $posts,
            'categorias' => $this->fornecedor(),
        ]);
    }   
    /**
     * MixProdutos
     * @return array
     */
    public function mixProdutos(): array
    {
        return (new MixProdutosModelo())->busca();
    }
    public function mixProduto(int $id):void
    {
        $posts = (new MixProdutosModelo())->posts($id);
        
        echo $this->template->renderizar('listar.html', [
            'mixProdutos' => $posts,
            'categorias' => $this->mixProdutos(),
        ]);
    }   
    
    /**
     * Categorias
     * @return array
     */
    public function categorias(): array
    {
        return (new CategoriaModelo())->busca("status = 1")->resultado(true);
    }
    /**
     * Lista posts por categoria
     * @param string $slug
     * @return void
     */
    public function categoria(string $slug):void
    {
        $categoria = (new CategoriaModelo())->buscaPorSlug($slug);
        if (!$categoria) {
            Helpers::redirecionar('404');
        }

        $categoria->salvarVisitas();

        echo $this->template->renderizar('categoria.html', [
            'posts' => (new CategoriaModelo())->posts($categoria->id),
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


