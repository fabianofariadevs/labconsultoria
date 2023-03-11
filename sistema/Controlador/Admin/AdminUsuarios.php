<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\UsuarioModelo;
/* Classe AdminUsuarios
 *
 * @author Fabiano Faria
 */
class AdminUsuarios extends AdminControlador
{
    public function listar(): void
    {
        echo $this->template->renderizar('usuarios/listar.html', [
            'usuarios'=> (new UsuarioModelo())->busca()
        ]);
    }
    
    public function cadastrar(): void
    {
        echo $this->template->renderizar('usuarios/formulario.html', []);
    }
    

}
