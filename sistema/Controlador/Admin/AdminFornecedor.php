<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\FornecedorModelo;
use sistema\Nucleo\Helpers;

/* Classe AdminFornecedor
 *
 * @author Fabiano Faria
 */

class AdminFornecedor extends AdminControlador
{

    /**
     * Lista FORNECEDOR
     * @return void
     */
    public function listar(): void
    {
        $fornecedor = new FornecedorModelo();
        echo $this->template->renderizar('fornecedor/listar.html', [
            'fornecedor' => $fornecedor->busca()->ordem('nome_fornec ASC')->resultado(true),
            'total' => [
                'fornecedor' => $fornecedor->total(),
                'fornecedorAtiva' => $fornecedor->busca('status = 1')->total(),
                'fornecedorInativa' => $fornecedor->busca('status = 0')->total(),
            ]]);
    }

    /**
     * Cadastra FORNECEDOR
     * @return void
     */
    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            if ($this->validarDados($dados)) {
                $fornecedor = new fornecedorModelo();
                
                $fornecedor->usuario_id = $this->usuario->id;
                $fornecedor->cnpj_forn = $dados['cnpj_forn'];
                $fornecedor->nome_fornec = $dados['nome_fornec'];
                $fornecedor->endereco_fornec = $dados['endereco_fornec'];
                $fornecedor->contato_whatsapp = $dados['contato_whatsapp'];
                $fornecedor->email_fornec = $dados['email_fornec'];
                $fornecedor->slug = Helpers::slug($dados['nome_fornec']);
                $fornecedor->status = $dados['status'];

                if ($fornecedor->salvar()) {
                    $this->mensagem->sucesso('Fornecedor cadastrado com sucesso')->flash();
                    Helpers::redirecionar('admin/fornecedor/listar');
                } else {
                    $this->mensagem->erro($fornecedor->erro())->flash();
                    Helpers::redirecionar('admin/fornecedor/listar');
                }
            }
        }

        echo $this->template->renderizar('fornecedor/formulario.html', [
            'fornecedor' => $dados]);
    }

    public function validarDados(array $dados): bool
    {

        if (empty($dados['cnpj_forn'])) {
            $this->mensagem->alerta('Escreva um CNPJ para o fornecedor!')->flash();
            return false;
        }
        if (empty($dados['nome_fornec'])) {
            $this->mensagem->alerta('Escreva um Nome para o fornecedor!')->flash();
            return false;
        }
        if (empty($dados['endereco_fornec'])) {
            $this->mensagem->alerta('Escreva um endereço para o fornecedor!')->flash();
            return false;
        }
        if (empty($dados['contato_whatsapp'])) {
            $this->mensagem->alerta('Escreva uma contato para o fornecedor!')->flash();
            return false;
        }
        if (empty($dados['email_fornec'])) {
            $this->mensagem->alerta('Escreva um email para o fornecedor!')->flash();
            return false;
        }
        return true;
    }

    public function editar(int $id): void
    {
        $fornecedor = (new FornecedorModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            if ($this->validarDados($dados)) {
                $fornecedor = (new FornecedorModelo())->buscaPorId($id);
                
                $fornecedor->usuario_id = $this->usuario->id;
                $fornecedor->cnpj_forn = $dados['cnpj_forn'];
                $fornecedor->nome_fornec = $dados['nome_fornec'];
                $fornecedor->endereco_fornec = $dados['endereco_fornec'];
                $fornecedor->contato_whatsapp = $dados['contato_whatsapp'];
                $fornecedor->email_fornec = $dados['email_fornec'];
                $fornecedor->slug = Helpers::slug($dados['nome_fornec']);
                $fornecedor->status = $dados['status'];

                if ($fornecedor->salvar()) {
                    $this->mensagem->sucesso('Fornecedor atualizado com sucesso')->flash();
                    Helpers::redirecionar('admin/fornecedor/listar');
                } else {
                    $this->mensagem->erro($fornecedor->erro())->flash();
                    Helpers::redirecionar('admin/fornecedor/listar');
                }
            }
        }

        echo $this->template->renderizar('fornecedor/formulario.html', [
            ////**VER AQUI TAMBEM           
            'fornecedor' => $fornecedor]);
    }

    public
            function deletar(int $id): void
    {
//        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (is_int($id)) {
            $fornecedor = (new FornecedorModelo())->buscaPorId($id);
            if (!$fornecedor) {
                $this->mensagem->alerta('O Fornecedor que você está tentando deletar não existe!')->flash();
                Helpers::redirecionar('admin/fornecedor/listar');
            } else {
                if ($fornecedor->deletar()) {
                    $this->mensagem->sucesso('Fornecedor deletado com sucesso!')->flash();
                    Helpers::redirecionar('admin/fornecedor/listar');
                } else {
                    $this->mensagem->erro($fornecedor->erro())->flash();
                    Helpers::redirecionar('admin/fornecedor/listar');
                }
            }
        }
    }

}
