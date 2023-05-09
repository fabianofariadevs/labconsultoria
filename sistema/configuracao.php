<?php
use sistema\Nucleo\Helpers;
//classe pai
// Arquivo de configuração do sistema
//fazer temporizador sistema****aula31
// define o fuso horario
date_default_timezone_set('America/Sao_Paulo');

//informações do Sistema
define('SITE_NOME', 'LAB Consultoria e Treinamento');
define('SITE_DESCRICAO', 'LAB - Consultoria e Treinamentos');

//urls do sistema
define('URL_PRODUCAO', 'https://labct.com.br');
define('URL_DESENVOLVIMENTO', 'http://localhost/labconsultoria');

//informações conexão com banco de dados
if (Helpers::localhost()) {
    //dados de acesso ao banco de dados em localhost
    define('DB_HOST', 'localhost');
    define('DB_PORTA', '3307');
    define('DB_NOME', 'db_labconsultoria');
    define('DB_USUARIO', 'root');
    define('DB_SENHA', '');
//const site_nome - 'Labct';
    define('URL_SITE', 'labconsultoria/');
//painel admin CONSTANTE ADMIN 
    define('URL_ADMIN', 'labconsultoria/admin/');
} else {
    //dados de acesso ao banco de dados na hospedagem
    define('DB_HOST', 'localhost');
    define('DB_PORTA', '3306');
    define('DB_NOME', '');
    define('DB_USUARIO', '');
    define('DB_SENHA', '');

    define('URL_SITE', '/');
    define('URL_ADMIN', '/admin/');
}

//autenticação do servidor de emails
define('EMAIL_HOST', 'smtp.hostinger.com');
define('EMAIL_PORTA', '465');
define('EMAIL_USUARIO', 'fabianofariadevs2022@gmail.com');
define('EMAIL_SENHA', 'UPHLg4uG6Jnb*Du');
define('EMAIL_REMETENTE', ['email' => EMAIL_USUARIO, 'nome' => SITE_NOME]);

//painel PRODUÇÃO CONSTANTE Producao 
//define('URL_PRODUCAO', 'labconsultoria/producao/');




