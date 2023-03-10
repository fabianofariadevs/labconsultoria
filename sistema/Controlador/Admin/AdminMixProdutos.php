<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\MixProdutosModelo;

class AdminMixProdutos extends AdminControlador
{
    public function listar(): void
    {
        echo $this->template->renderizar('MixProdutos/listar.html', [
            'MixProdutos'=> (new MixProdutosModelo())->busca()
        ]);
        
    }
    

}
