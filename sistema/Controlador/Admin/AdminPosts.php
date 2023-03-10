<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\PostModelo;

class AdminPosts extends AdminControlador
{
    public function listar(): void
    {
        echo $this->template->renderizar('posts/listar.html', [
            'posts'=> (new PostModelo())->busca()
        ]);
        
    }
    

}
