<?php

namespace sistema\Controlador;

//filha do controlador aula 55
use sistema\Nucleo\Controlador;
//postmodelo chamando view index para apresentar os dados
use sistema\Modelo\PostModelo;
//use sistema\Modelo\UsuarioModelo;
//use sistema\Modelo\FornecedorModelo;
use sistema\Modelo\MixProdutosModelo;
use sistema\Modelo\ClienteModelo;
use sistema\Nucleo\Helpers;
<<<<<<< HEAD
use Sistema\Modelo\CategoriaModelo;
use sistema\Biblioteca\Paginar;

=======
use Site\Modelo\CategoriaModelo;
use sistema\Biblioteca\Paginar;
>>>>>>> c06ed5afea1f1727b48a16770333bffac6744e2f
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
            'posts' => [
                'slides' => $posts->ordem('id DESC')->limite(3)->resultado(true),
                'posts' => $posts->ordem('id DESC')->limite(10)->offset(3)->resultado(true),
                'maisLidos' => (new PostModelo())->busca("status = 1")->ordem('visitas DESC')->limite(5)->resultado(true),
            ],
            'categorias' => $this->categorias(),
        ]);
    }
<<<<<<< HEAD

=======
    
    
>>>>>>> c06ed5afea1f1727b48a16770333bffac6744e2f
    public function base(): void
    {
        echo $this->template->renderizar('base.html', [
            'titulo' => 'teste BASE TItulo',
            'subtitulo' => 'teste BASE de subtitulo'
        ]);
    }
<<<<<<< HEAD

=======
>>>>>>> c06ed5afea1f1727b48a16770333bffac6744e2f
    public function contatos(): void
    {
        echo $this->template->renderizar('contatos.html', [
            'titulo' => 'contato Izabel fabiano',
            'subtitulo' => 'teste CONTATO de subtitulo'
        ]);
    }
<<<<<<< HEAD

=======
>>>>>>> c06ed5afea1f1727b48a16770333bffac6744e2f
    public function servicos(): void
    {
        echo $this->template->renderizar('servicos.html', [
            'titulo' => 'SERVIÇOS  TItulo',
            'subtitulo' => 'SERVIÇOS  de subtitulo'
        ]);
    }
<<<<<<< HEAD

=======
>>>>>>> c06ed5afea1f1727b48a16770333bffac6744e2f
    /**
     * Busca posts 
     * @return void
     */
<<<<<<< HEAD
    public function buscar(): void
    {
        $busca = filter_input(INPUT_POST, 'busca', FILTER_DEFAULT);
        if (isset($busca)) {
            $posts = (new PostModelo())->busca("status = 1 AND titulo LIKE '%{$busca}%'")->resultado(true);
            if ($posts) {
                foreach ($posts as $post) {
                    echo "<li class='list-group-item fw-bold'><a href=" . Helpers::url('post/') . $post->id . ">$post->titulo</a></li>";
                }
            }
        }
    }

    /**
=======
    public function buscar():void
    {
        $busca = filter_input(INPUT_POST,'busca', FILTER_DEFAULT);
        if(isset($busca)){
            $posts = (new PostModelo())->busca("status = 1 AND titulo LIKE '%{$busca}%'")->resultado(true);
            if ($posts) {
                foreach ($posts as $post) {
                    echo "<li class='list-group-item fw-bold'><a href=" .Helpers::url('post/') . $post->id . ">$post->titulo</a></li>";
                }
            }
        
        }
    }
/**
>>>>>>> c06ed5afea1f1727b48a16770333bffac6744e2f
     * Busca post por ID
     * @param int $slug
     * @return void
     */
<<<<<<< HEAD
    public function post(string $slug): void
    {
        $post = (new PostModelo())->buscaPorSlug($slug);
        if (!$post) {
            Helpers::redirecionar('404');
        }
        $post->salvarVisitas();

=======
    public function post(string $slug):void
    {
        $post = (new PostModelo())->buscaPorSlug($slug);
        if(!$post){
            Helpers::redirecionar('404');
        }
        $post->salvarVisitas();
        
>>>>>>> c06ed5afea1f1727b48a16770333bffac6744e2f
        echo $this->template->renderizar('post.html', [
            'post' => $post,
            'categorias' => $this->categorias(),
        ]);
    }
<<<<<<< HEAD

    /**
=======
     /**
>>>>>>> c06ed5afea1f1727b48a16770333bffac6744e2f
     * Categorias
     * @return array
     */
    public function categorias(): array
    {
        return (new CategoriaModelo())->busca("status = 1")->resultado(true);
    }
<<<<<<< HEAD

=======
>>>>>>> c06ed5afea1f1727b48a16770333bffac6744e2f
    /**
     * Lista posts por categoria
     * @param string $slug
     * @return void
     */
<<<<<<< HEAD
    public function categoria(string $slug): void
=======
    public function categoria(string $slug, int $pagina = null):void
>>>>>>> c06ed5afea1f1727b48a16770333bffac6744e2f
    {
        $categoria = (new CategoriaModelo())->buscaPorSlug($slug);
        if (!$categoria) {
            Helpers::redirecionar('404');
        }

        $categoria->salvarVisitas();
<<<<<<< HEAD
        
        echo $this->template->renderizar('categoria.html', [
            'posts' => (new CategoriaModelo())->posts($categoria->id),
            'categorias' => $this->categorias(),
        ]);
    }

=======
        $posts = (new PostModelo());
        $total = $posts->busca('categoria_id = :c', "c={$categoria->id} COUNT(id)", 'id')->total();

        $paginar = new Paginar(Helpers::url('categoria/' . $slug), ($pagina ?? 1), 6, 3, $total);

        echo $this->template->renderizar('categoria.html', [
            'posts' => $posts->busca("categoria_id = {$categoria->id}")->limite($paginar->limite())->offset($paginar->offset())->resultado(true),
            'paginacao' => $paginar->renderizar(),
            'paginacaoInfo' => $paginar->info(),
            'categorias' => $this->categorias(),
        ]);
    }    
>>>>>>> c06ed5afea1f1727b48a16770333bffac6744e2f
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
<<<<<<< HEAD

=======
>>>>>>> c06ed5afea1f1727b48a16770333bffac6744e2f
    /**
     * Clientes
     * @return array
     */
    public function cliente(): array
    {
        return (new ClienteModelo())->busca();
    }

    public function clientes(int $id): void
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

    public function usuario(int $id): void
    {
        $posts = (new UsuarioModelo())->posts($id);

        echo $this->template->renderizar('listar.html', [
            'usuarios' => $posts,
            'categorias' => $this->usuarios(),
                //    'tbl_cliente_fabrica' => $this->usuarios(),
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

    public function fornecedores(int $id): void
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

    public function mixProduto(int $id): void
    {
        $posts = (new MixProdutosModelo())->posts($id);

        echo $this->template->renderizar('listar.html', [
            'mixProdutos' => $posts,
            'categorias' => $this->mixProdutos(),
        ]);
<<<<<<< HEAD
    }

    /**
=======
    }   
    
   
        /**
>>>>>>> c06ed5afea1f1727b48a16770333bffac6744e2f
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
