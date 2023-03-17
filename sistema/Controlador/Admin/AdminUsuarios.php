<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\UsuarioModelo;
use sistema\Modelo\CategoriaModelo;
use sistema\Nucleo\Helpers;
/* Classe AdminUsuarios
 *
 * @author Fabiano Faria
 */
class AdminUsuarios extends AdminControlador
{
    public function listar(): void
    {
        $post = new UsuarioModelo();
        
        echo $this->template->renderizar('usuarios/listar.html', [
            'clientes' => $post->busca()->ordem('status ASC, id_tbl_Usuario DESC')->resultado(true),
            'total' => [
                'clientes' => $post->total(),
                'clientesAtivo' => $post->busca('status = 1')->total(),
                'clientesInativo' => $post->busca('status = 0')->total()
            ]
        ]);
    }

    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            $post = new UsuarioModelo();

            $post->nome_usuario = $dados['nome_usuario'];
            $post->sobrenome_usuario = $dados['sobrenome_usuario'];
            $post->email_usuario = $dados['email_usuario'];
            $post->level = $dados['level'];
            $post->senha_usuario = $dados['senha_usuario'];
            $post->empresa_colab = $dados['empresa_colab'];
            $post->status = $dados['status'];
           
            if ($post->salvar()) {
                $this->mensagem->sucesso('Usuário cadastrado com sucesso')->flash();
                Helpers::redirecionar('admin/usuarios/listar');
            }
        }

        echo $this->template->renderizar('usuarios/formulario.html', [
    /////ver aquiiiii cat???        
            //'categorias' => (new CategoriaModelo())->busca()
        ]);
    }

    public function editar(int $id): void
    {
        $post = (new UsuarioModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            $post->nome_usuario = $dados['nome_usuario'];
            $post->sobrenome_usuario = $dados['sobrenome_usuario'];
            $post->email_usuario = $dados['email_usuario'];
            $post->level = $dados['level'];
            $post->senha_usuario = $dados['senha_usuario'];
            $post->empresa_colab = $dados['empresa_colab'];
            $post->status = $dados['status'];

            if ($post->salvar()) {
                $this->mensagem->sucesso('Usuário atualizado com sucesso')->flash();
                Helpers::redirecionar('admin/usuarios/listar');
            }
        }

        echo $this->template->renderizar('usuarios/formulario.html', [
    ////ver aqui tb???        
     //       'post' => $post,
       //     'categorias' => (new CategoriaModelo())->busca()
        ]);
    }

    public function deletar(int $id): void
    {
//        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (is_int($id)) {
            $post = (new UsuarioModelo())->buscaPorId($id);
            if (!$post) {
                $this->mensagem->alerta('O Usuário que você está tentando deletar não existe!')->flash();
                Helpers::redirecionar('admin/usuarios/listar');
            } else {
                if($post->deletar()){
                    $this->mensagem->sucesso('Usuário deletado com sucesso!')->flash();
                Helpers::redirecionar('admin/usuarios/listar');
                }else {
                    $this->mensagem->erro($post->erro())->flash();
                Helpers::redirecionar('admin/usuarios/listar');
                }
                
                
            }
        }
    }


}
