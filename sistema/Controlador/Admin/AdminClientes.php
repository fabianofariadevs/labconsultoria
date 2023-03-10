<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\ClienteModelo;
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
    

}
