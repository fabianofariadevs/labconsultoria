<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\ClienteModelo;
use sistema\Nucleo\helpers;
/* Classe AdminClientes
 *
 * @author Fabiano Faria
 */
class AdminClientes extends AdminControlador
{
    public function listar(): void
    {
        echo $this->template->renderizar('clientes/listar.html', [
            'clientes'=> (new ClienteModelo())->busca()
        ]);
    }
    
    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        //var_dump($dados);
        if (isset($dados)) {
            (new ClienteModelo())->armazenar($dados);     
            helpers::redirecionar('admin/clientes/listar');
        }
        echo $this->template->renderizar('clientes/formulario.html', []);
    }

}
