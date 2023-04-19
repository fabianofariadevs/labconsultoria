<?php

use Pecee\SimpleRouter\SimpleRouter;
use sistema\Nucleo\Helpers;

try {
    SimpleRouter::setDefaultNamespace('sistema\Controlador');
    
    
    SimpleRouter::get(URL_SITE, 'SiteControlador@index');
    SimpleRouter::get(URL_SITE .'index.php', 'SiteControlador@index');
    SimpleRouter::get(URL_SITE .'sobre', 'SiteControlador@sobre');
    SimpleRouter::get(URL_SITE .'base', 'SiteControlador@base');
    SimpleRouter::get(URL_SITE .'contatos', 'SiteControlador@contatos');
    SimpleRouter::get(URL_SITE .'servicos', 'SiteControlador@servicos');

    SimpleRouter::get(URL_SITE .'post/{slug}', 'SiteControlador@post');
    SimpleRouter::get(URL_SITE .'categoria/{slug}', 'SiteControlador@categoria');
    SimpleRouter::post(URL_SITE .'buscar', 'SiteControlador@buscar');
    SimpleRouter::get(URL_SITE .'404', 'SiteControlador@erro404');

// ROTAS ADMIN Grupo Controler painel Admin" Namespace class
    SimpleRouter::group(['namespace' => 'Admin'], function () {

//ADMIN LOGIN
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'login', 'AdminLogin@login');
        
//DASHBOAD Admin
        SimpleRouter::get(URL_ADMIN . 'dashboard', 'AdminDashboard@dashboard');
        SimpleRouter::get(URL_ADMIN . 'sair', 'AdminDashboard@sair');

//ADMIN USUARIOS
        SimpleRouter::get(URL_ADMIN .'usuarios/listar', 'AdminUsuarios@listar');
        SimpleRouter::match(['get','post'], URL_ADMIN.'usuarios/cadastrar', 'AdminUsuarios@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'usuarios/editar/{id}', 'AdminUsuarios@editar');
        SimpleRouter::get(URL_ADMIN . 'usuarios/deletar/{id}', 'AdminUsuarios@deletar');


//ADMIN POSTS
        SimpleRouter::get(URL_ADMIN . 'posts/listar', 'AdminPosts@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'posts/cadastrar', 'AdminPosts@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'posts/editar/{id}', 'AdminPosts@editar');
        SimpleRouter::get(URL_ADMIN . 'posts/deletar/{id}', 'AdminPosts@deletar');

//ADMIN CATEGORIAS
        SimpleRouter::get(URL_ADMIN . 'categorias/listar', 'AdminCategorias@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'categorias/cadastrar', 'AdminCategorias@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'categorias/editar/{id}', 'AdminCategorias@editar');
        SimpleRouter::get(URL_ADMIN . 'categorias/deletar/{id}', 'AdminCategorias@deletar');



//ADMIN CLIENTES
        SimpleRouter::get(URL_ADMIN .'clientes/listar', 'AdminClientes@listar');
        SimpleRouter::match(['get','post'], URL_ADMIN . 'clientes/cadastrar', 'AdminClientes@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'clientes/editar/{id}', 'AdminClientes@editar');
        SimpleRouter::get(URL_ADMIN . 'clientes/deletar/{id}', 'AdminClientes@deletar');

//ADMIN RECEITAS
        SimpleRouter::get(URL_ADMIN .'receitas/listar', 'AdminReceitas@listar');
        SimpleRouter::match(['get','post'], URL_ADMIN .'receitas/cadastrar', 'AdminReceitas@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'receitas/editar/{id}', 'AdminReceitas@editar');
        SimpleRouter::get(URL_ADMIN . 'receitas/deletar/{id}', 'AdminReceitas@deletar');

//ADMIN PLANEJAMENTO DE PRODUÇÃO
        SimpleRouter::get(URL_ADMIN .'producao/listar', 'AdminProducao@listar');
        SimpleRouter::match(['get','post'], URL_ADMIN .'producao/cadastrar', 'AdminProducao@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'producao/editar/{id}', 'AdminProducao@editar');
        SimpleRouter::get(URL_ADMIN . 'producao/deletar/{id}', 'AdminProducao@deletar');

//ADMIN FORNECEDORES
        SimpleRouter::get(URL_ADMIN .'fornecedor/listar', 'AdminFornecedor@listar');
        SimpleRouter::match(['get','post'], URL_ADMIN .'fornecedor/cadastrar', 'AdminFornecedor@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'fornecedor/editar/{id}', 'AdminFornecedor@editar');
        SimpleRouter::get(URL_ADMIN . 'fornecedor/deletar/{id}', 'AdminFornecedor@deletar');

//ADMIN COMPRAS / PEDIDOS
        SimpleRouter::get(URL_ADMIN .'compras/listar', 'AdminCompras@listar');
        SimpleRouter::match(['get','post'], URL_ADMIN .'compras/cadastrar', 'AdminCompras@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'compras/editar/{id}', 'AdminCompras@editar');
        SimpleRouter::get(URL_ADMIN . 'compras/deletar/{id}', 'AdminCompras@deletar');
        
//ADMIN MIX PRODUTOS
        SimpleRouter::get(URL_ADMIN .'mixProdutos/listar', 'AdminmixProdutos@listar');
        SimpleRouter::match(['get','post'], URL_ADMIN .'mixProdutos/cadastrar', 'AdminmixProdutos@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'mixProdutos/editar/{id}', 'AdminmixProdutos@editar');
        SimpleRouter::get(URL_ADMIN . 'mixProdutos/deletar/{id}', 'AdminmixProdutos@deletar');
        
});

// ROTAS PRODUÇÃO, para  Grupo Controler painel Clientes/Produção" Namespace class
    SimpleRouter::group(['namespace' => 'Producao'], function () {
        
//DASHBOAD Produção
        SimpleRouter::get(URL_PRODUCAO . 'dashboard', 'ProducaoDashboard@dashboard');
        SimpleRouter::get(URL_PRODUCAO . 'sair', 'ProducaoDashboard@sair');



<<<<<<< HEAD
//PRODUCAO PRODUÇÃO
        SimpleRouter::get(URL_PRODUCAO .'producao/listar', 'ProducaoProducao@listar');
        SimpleRouter::match(['get','post'], URL_PRODUCAO .'producao/cadastrar', 'ProducaoProducao@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_PRODUCAO . 'producao/editar/{id}', 'ProducaoProducao@editar');
        SimpleRouter::get(URL_PRODUCAO . 'producao/deletar/{id}', 'ProducaoProducao@deletar');
=======
//ADMIN RECEITAS
        SimpleRouter::get(URL_PRODUCAO .'receitas/listar', 'ProducaoReceitas@listar');
        SimpleRouter::match(['get','post'], URL_PRODUCAO .'receitas/cadastrar', 'ProducaoReceitas@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_PRODUCAO . 'receitas/editar/{id}', 'ProducaoReceitas@editar');
        SimpleRouter::get(URL_PRODUCAO . 'receitas/deletar/{id}', 'ProducaoReceitas@deletar');
>>>>>>> c06ed5afea1f1727b48a16770333bffac6744e2f

//PRODUCAO FORNECEDORES
        SimpleRouter::get(URL_PRODUCAO .'fornecedor/listar', 'ProducaoFornecedor@listar');
        SimpleRouter::match(['get','post'], URL_PRODUCAO .'fornecedor/cadastrar', 'ProducaoFornecedor@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_PRODUCAO . 'fornecedor/editar/{id}', 'ProducaoFornecedor@editar');
        SimpleRouter::get(URL_PRODUCAO . 'fornecedor/deletar/{id}', 'ProducaoFornecedor@deletar');

<<<<<<< HEAD
//PRODUCAO PLANEJAMENTO DE PRODUÇÃO
        
        
//PRODUCAO MIX PRODUTOS
        SimpleRouter::get(URL_PRODUCAO .'mixProdutos/listar', 'ProducaomixProdutos@listar');
        SimpleRouter::match(['get','post'], URL_PRODUCAO .'mixProdutos/cadastrar', 'ProducaomixProdutos@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_PRODUCAO . 'mixProdutos/editar/{id}', 'ProducaomixProdutos@editar');
        SimpleRouter::get(URL_PRODUCAO . 'mixProdutos/deletar/{id}', 'ProducaomixProdutos@deletar');
=======

//ADMIN PRODUÇÃO
        SimpleRouter::get(URL_PRODUCAO .'producao/listar', 'ProducaoProducao@listar');

//ADMIN FORNECEDORES
        SimpleRouter::get(URL_PRODUCAO .'fornecedor/listar', 'ProducaoFornecedor@listar');

//ADMIN PLANEJAMENTO DE PRODUÇÃO
        SimpleRouter::get(URL_PRODUCAO .'producao/listar', 'ProducaoProducao@listar');

//ADMIN MIX PRODUTOS
        SimpleRouter::get(URL_PRODUCAO .'mixProdutos/listar', 'ProducaomixProdutos@listar');
        SimpleRouter::match(['get','post'], URL_PRODUCAO .'mixProdutos/cadastrar', 'ProducaomixProdutos@cadastrar');
>>>>>>> c06ed5afea1f1727b48a16770333bffac6744e2f


});


SimpleRouter::start();

} catch (Pecee\SimpleRouter\Exceptions\NotFoundHttpException $ex) {
    if(Helpers::localhost()) {
        echo $ex->getMessage();
    } else {
        Helpers::redirecionar('404');
    }
}


