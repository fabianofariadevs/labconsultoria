<?php

use Pecee\SimpleRouter\SimpleRouter;
use sistema\Nucleo\Helpers;

try {
    SimpleRouter::setDefaultNamespace('sistema\Controlador');
    
    
SimpleRouter::get(URL_SITE, 'SiteControlador@index');
SimpleRouter::get(URL_SITE.'index', 'SiteControlador@index');
SimpleRouter::get(URL_SITE.'sobre', 'SiteControlador@sobre');
SimpleRouter::get(URL_SITE.'base', 'SiteControlador@base');
SimpleRouter::get(URL_SITE.'contatos', 'SiteControlador@contatos');
SimpleRouter::get(URL_SITE.'servicos', 'SiteControlador@servicos');

SimpleRouter::get(URL_SITE.'post/{id}', 'SiteControlador@post');
SimpleRouter::get(URL_SITE.'categoria/{id}', 'SiteControlador@categoria');
SimpleRouter::get(URL_SITE.'buscar', 'SiteControlador@buscar');
SimpleRouter::get(URL_SITE.'404', 'SiteControlador@erro404');

// ROTAS ADMIN Grupo Controler painel Admin" Namespace class
SimpleRouter::group(['namespace' => 'Admin'], function () {
    SimpleRouter::get(URL_ADMIN.'dashboard', 'AdminDashboard@dashboard');
    
    //ADMIN LOGIN
    SimpleRouter::match(['get', 'post'], URL_ADMIN . 'login', 'AdminLogin@login');
        
    //DASHBOAD
    SimpleRouter::get(URL_ADMIN . 'dashboard', 'AdminDashboard@dashboard');
    SimpleRouter::get(URL_ADMIN . 'sair', 'AdminDashboard@sair');

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

    //ADMIN RECEITAS
    SimpleRouter::get(URL_ADMIN.'receitas/listar', 'AdminReceitas@listar');
    SimpleRouter::match(['get','post'], URL_ADMIN.'receitas/cadastrar', 'AdminReceitas@cadastrar');
    SimpleRouter::match(['get', 'post'], URL_ADMIN . 'receitas/editar/{id}', 'AdminReceitas@editar');
    SimpleRouter::get(URL_ADMIN . 'receitas/deletar/{id}', 'AdminReceitas@deletar');

    
    //ADMIN USUARIOS
    SimpleRouter::get(URL_ADMIN.'usuarios/listar', 'AdminUsuarios@listar');
    SimpleRouter::match(['get','post'], URL_ADMIN.'usuarios/cadastrar', 'AdminUsuarios@cadastrar');
    
    //ADMIN PRODUÇÃO
    SimpleRouter::get(URL_ADMIN.'producao/listar', 'AdminProducao@listar');
    
    //ADMIN FORNECEDORES
    SimpleRouter::get(URL_ADMIN.'fornecedor/listar', 'AdminFornecedor@listar');
    
    //ADMIN PLANEJAMENTO DE PRODUÇÃO
    SimpleRouter::get(URL_ADMIN.'producao/listar', 'AdminProducao@listar');
    
    //ADMIN MIX PRODUTOS
    SimpleRouter::get(URL_ADMIN.'mixProdutos/listar', 'AdminMixProdutos@listar');
    SimpleRouter::match(['get','post'], URL_ADMIN.'mixProdutos/cadastrar', 'AdminmixProdutos@cadastrar');
    
    //ADMIN CLIENTES
    SimpleRouter::get(URL_ADMIN.'clientes/listar', 'AdminClientes@listar');
    SimpleRouter::match(['get','post'], URL_ADMIN.'clientes/cadastrar', 'AdminClientes@cadastrar');
    SimpleRouter::match(['get', 'post'], URL_ADMIN . 'clientes/editar/{id}', 'AdminClientes@editar');
    SimpleRouter::get(URL_ADMIN . 'clientes/deletar/{id}', 'AdminClientes@deletar');
   
});

SimpleRouter::start();

} catch (Pecee\SimpleRouter\Exceptions\NotFoundHttpException $ex) {
    if(Helpers::localhost()) {
        echo $ex->getMessage();
    } else {
        Helpers::redirecionar('404');
    }
}


