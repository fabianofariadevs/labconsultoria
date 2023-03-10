<?php
//classe pai
// Arquivo de configuração do sistema
//fazer temporizador sistema****aula31

date_default_timezone_set ('America/Sao_Paulo');

//informações conexão com banco de dados
define('DB_HOST', 'localhost');
define('DB_PORTA', '3307');
define('DB_NOME', 'db_labconsultoria');
define('DB_USUARIO', 'root');
define('DB_SENHA', '');

//informações do site
define('SITE_NOME', 'LAB Consultoria e Treinamentos');
define('SITE_DESCRICAO', 'LAB - Consultoria e Treinamentos');

//urls do sistema
define('URL_PRODUCAO', 'https://labct.com.br');
define('URL_DESENVOLVIMENTO', 'https://localhost/labconsultoria');

//const site_nome - 'Labct';
define('URL_SITE', 'labconsultoria/');

//painel admin CONSTANTE ADMIN 
define('URL_ADMIN', 'labconsultoria/admin/');



