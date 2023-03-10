<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\UsuarioModelo;

class AdminUsuarios extends AdminControlador
{
    public function listar(): void
    {
        echo $this->template->renderizar('Usuarios/listar.html', [
            'Usuarios'=> (new UsuarioModelo())->busca()
        ]);
        
    }
    

}
