<?php

use Pecee\SimpleRouter\SimpleRouter;
use sistema\Nucleo\Helpers;

try {
//ROTAS SITE
    SimpleRouter::setDefaultNamespace('sistema\Controlador');

    SimpleRouter::get(URL_SITE, 'SiteControlador@index');
    SimpleRouter::get(URL_SITE . 'index.php', 'SiteControlador@index');
    SimpleRouter::get(URL_SITE . 'sobre-nos', 'SiteControlador@sobre');
    SimpleRouter::get(URL_SITE . 'contato', 'SiteControlador@contato');
    SimpleRouter::get(URL_SITE . 'servicos', 'SiteControlador@servicos');

    SimpleRouter::get(URL_SITE . 'post/{categoria}/{slug}', 'SiteControlador@post');
    SimpleRouter::get(URL_SITE . 'categoria/{slug}/{pagina?}', 'SiteControlador@categoria');
    SimpleRouter::post(URL_SITE . 'buscar', 'SiteControlador@buscar');
    SimpleRouter::get(URL_SITE . '404', 'SiteControlador@erro404');
    SimpleRouter::match(['get', 'post'], URL_SITE . 'contato', 'SiteControlador@contato');

//ROTAS ADMIN
    SimpleRouter::group(['namespace' => 'Admin'], function () {

//ADMIN LOGIN
        SimpleRouter::get(URL_ADMIN, 'AdminLogin@index');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'login', 'AdminLogin@login');

//DASHBOAD
        SimpleRouter::get(URL_ADMIN . 'dashboard', 'AdminDashboard@dashboard');
        SimpleRouter::get(URL_ADMIN . 'sair', 'AdminDashboard@sair');

//ADMIN USUARIOS
        SimpleRouter::get(URL_ADMIN . 'usuarios/listar', 'AdminUsuarios@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'usuarios/cadastrar', 'AdminUsuarios@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'usuarios/editar/{id}', 'AdminUsuarios@editar');
        SimpleRouter::get(URL_ADMIN . 'usuarios/deletar/{id}', 'AdminUsuarios@deletar');

//ADMIN POSTS
        SimpleRouter::get(URL_ADMIN . 'posts/listar', 'AdminPosts@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'posts/cadastrar', 'AdminPosts@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'posts/editar/{id}', 'AdminPosts@editar');
        SimpleRouter::get(URL_ADMIN . 'posts/deletar/{id}', 'AdminPosts@deletar');
        SimpleRouter::post(URL_ADMIN . 'posts/datatable', 'AdminPosts@datatable');

//ADMIN CATEGORIAS
        SimpleRouter::get(URL_ADMIN . 'categorias/listar', 'AdminCategorias@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'categorias/cadastrar', 'AdminCategorias@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'categorias/editar/{id}', 'AdminCategorias@editar');
        SimpleRouter::get(URL_ADMIN . 'categorias/deletar/{id}', 'AdminCategorias@deletar');
        SimpleRouter::post(URL_ADMIN . 'categorias/datatable', 'AdminCategorias@datatable');

//ADMIN CLIENTES
        SimpleRouter::get(URL_ADMIN . 'clientes/listar', 'AdminClientes@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'clientes/cadastrar', 'AdminClientes@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'clientes/editar/{id}', 'AdminClientes@editar');
        SimpleRouter::get(URL_ADMIN . 'clientes/deletar/{id}', 'AdminClientes@deletar');
        SimpleRouter::post(URL_ADMIN . 'clientes/datatable', 'AdminClientes@datatable');

//ADMIN RECEITAS
        SimpleRouter::get(URL_ADMIN . 'receitas/listar', 'AdminReceitas@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'receitas/cadastrar', 'AdminReceitas@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'receitas/editar/{id}', 'AdminReceitas@editar');
        SimpleRouter::get(URL_ADMIN . 'receitas/deletar/{id}', 'AdminReceitas@deletar');
        SimpleRouter::post(URL_ADMIN . 'receitas/datatable', 'AdminReceitas@datatable');

//ADMIN PLANEJAMENTO DE PRODUÇÃO
        SimpleRouter::get(URL_ADMIN . 'producao/listar', 'AdminProducao@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'producao/cadastrar', 'AdminProducao@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'producao/editar/{id}', 'AdminProducao@editar');
        SimpleRouter::get(URL_ADMIN . 'producao/deletar/{id}', 'AdminProducao@deletar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'producao/consultar', 'AdminProducao@consultar');
        SimpleRouter::post(URL_ADMIN . 'producao/datatable', 'AdminProducao@datatable');

//ADMIN FORNECEDORES
        SimpleRouter::get(URL_ADMIN . 'fornecedor/listar', 'AdminFornecedor@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'fornecedor/cadastrar', 'AdminFornecedor@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'fornecedor/editar/{id}', 'AdminFornecedor@editar');
        SimpleRouter::get(URL_ADMIN . 'fornecedor/deletar/{id}', 'AdminFornecedor@deletar');
        SimpleRouter::post(URL_ADMIN . 'fornecedor/datatable', 'AdminFornecedor@datatable');

//ADMIN MIX PRODUTOS
        SimpleRouter::get(URL_ADMIN . 'mixProdutos/listar', 'AdminMixProdutos@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'mixProdutos/cadastrar', 'AdminMixProdutos@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'mixProdutos/editar/{id}', 'AdminMixProdutos@editar');
        SimpleRouter::get(URL_ADMIN . 'mixProdutos/deletar/{id}', 'AdminMixProdutos@deletar');
        SimpleRouter::post(URL_ADMIN . 'mixProdutos/datatable', 'AdminMixProdutos@datatable');

//ADMIN PDVS
        SimpleRouter::get(URL_ADMIN . 'pdvs/listar', 'AdminPdv@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'pdvs/cadastrar', 'AdminPdv@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'pdvs/editar/{id}', 'AdminPdv@editar');
        SimpleRouter::get(URL_ADMIN . 'pdvs/deletar/{id}', 'AdminPdv@deletar');
        SimpleRouter::post(URL_ADMIN . 'pdvs/datatable', 'AdminPdv@datatable');

//ADMIN ESTOQUE M.PRIMA
        SimpleRouter::get(URL_ADMIN . 'estoqueMp/listar', 'AdminEstoqueMp@listar');
        SimpleRouter::get(URL_ADMIN . 'estoqueMp/inventario', 'AdminEstoqueMp@inventario');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'estoqueMp/cadastrar', 'AdminEstoqueMp@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'estoqueMp/editar/{id}', 'AdminEstoqueMp@editar');
        SimpleRouter::get(URL_ADMIN . 'estoqueMp/consultar', 'AdminEstoqueMp@consultar');
        SimpleRouter::get(URL_ADMIN . 'estoqueMp/deletar/{id}', 'AdminEstoqueMp@deletar');

//ADMIN COMPRAS
        SimpleRouter::get(URL_ADMIN . 'compras/listar', 'AdminCompras@listar');
        SimpleRouter::get(URL_ADMIN . 'compras/historico', 'AdminCompras@historico');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'compras/cadastrar', 'AdminCompras@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'compras/editar/{id}', 'AdminCompras@editar');
        SimpleRouter::get(URL_ADMIN . 'compras/consultar', 'AdminCompras@consultar');
        SimpleRouter::get(URL_ADMIN . 'compras/deletar/{id}', 'AdminCompras@deletar');
        SimpleRouter::get(URL_ADMIN . 'compras/buscar', 'AdminCompras@buscar');
    });

    SimpleRouter::start();
} catch (Pecee\SimpleRouter\Exceptions\NotFoundHttpException $ex) {
    if (Helpers::localhost()) {
        echo $ex->getMessage();
    } else {
        Helpers::redirecionar('404');
    }
}
