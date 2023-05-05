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
            ]
        ]);
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
                $fornecedor->cnpj_forn = $dados['cnpj_forn'];
                $fornecedor->nome_fornec = $dados['nome_fornec'];
                $fornecedor->endereco_fornec = $dados['endereco_fornec'];
                $fornecedor->contato_whatsapp = $dados['contato_whatsapp'];
                $fornecedor->email_fornec = $dados['email_fornec'];
                $fornecedor->status = $dados['status'];

                if ($fornecedor->salvar()) {
                    $this->mensagem->sucesso('Fornecedor cadastrado com sucesso')->flash();
                    Helpers::redirecionar('admin/producao/listar');
                } else {
                    $this->mensagem->erro($fornecedor->erro())->flash();
                    Helpers::redirecionar('admin/fornecedor/listar');
                }
            }
        }

        echo $this->template->renderizar('fornecedor/formulario.html', [
            'fornecedor' => (new FornecedorModelo())->busca()
        ]);
    }

}
