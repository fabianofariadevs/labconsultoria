<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\ReceitaModelo;

class AdminReceitas extends AdminControlador
{
    public function listar(): void
    {
        echo $this->template->renderizar('receitas/listar.html', [
            'receitas'=> (new ReceitaModelo())->busca()
        ]);
        
    }
    

}
