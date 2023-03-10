<?php

namespace sistema\Controlador\Admin;
//chamando a classe pai controlador
use sistema\Nucleo\Controlador;
//Classe ADMIN Controlador
class AdminControlador extends Controlador
{
    public function __construct()
    {
         //diretorio definido
        parent::__construct('templates/admin/views');
    }
       
    
}
