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

// Grupo Controler painel Admin" Namespace class
SimpleRouter::group(['namespace' => 'Admin'], function () {
    SimpleRouter::get(URL_ADMIN.'dashboard', 'AdminDashboard@dashboard');
    
    //ADMIN POSTS
    SimpleRouter::get(URL_ADMIN.'posts/listar', 'AdminPosts@listar');
    
    //ADMIN CATEGORIAS
    SimpleRouter::get(URL_ADMIN.'categorias/listar', 'AdminCategorias@listar');
    
    //ADMIN RECEITAS
    SimpleRouter::get(URL_ADMIN.'receitas/listar', 'AdminReceitas@listar');
    
    //ADMIN USUARIOS
    SimpleRouter::get(URL_ADMIN.'usuarios/listar', 'AdminUsuarios@listar');
    
    //ADMIN PRODUÇÃO
    SimpleRouter::get(URL_ADMIN.'producao/listar', 'AdminProducao@listar');
    
    //ADMIN FORNECEDORES
    SimpleRouter::get(URL_ADMIN.'fornecedor/listar', 'AdminFornecedor@listar');
    
    //ADMIN PLANEJAMENTO DE PRODUÇÃO
    SimpleRouter::get(URL_ADMIN.'producao/listar', 'AdminProducao@listar');
    
    //ADMIN MIX PRODUTOS
    SimpleRouter::get(URL_ADMIN.'mixProdutos/listar', 'AdminMixProdutos@listar');
    
    //ADMIN CLIENTES
    SimpleRouter::get(URL_ADMIN.'clientes/listar', 'AdminClientes@listar');
});

SimpleRouter::start();

} catch (Pecee\SimpleRouter\Exceptions\NotFoundHttpException $ex) {
    if(Helpers::localhost()) {
        echo $ex->getMessage();
    } else {
        Helpers::redirecionar('404');
    }
}


