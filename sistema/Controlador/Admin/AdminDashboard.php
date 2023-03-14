<?php

namespace sistema\Controlador\Admin;

class AdminDashboard extends AdminControlador
{
    public function dashboard(): void
    {
        echo $this->template->renderizar('dashboard.html', []);
        
    }
    
    public function sair(): void
    {
        $sessao = new Sessao();
        $sessao->limpar('usuarioId');
        
        $this->mensagem->informa('Você saiu do painel de controle!')->flash();
        Helpers::redirecionar('admin/login');
    }
    

}
