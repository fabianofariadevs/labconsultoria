<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\ClienteModelo;
use sistema\Nucleo\Helpers;

/* Classe AdminClientes
 *
 * @author Fabiano Faria
 */

class AdminClientes extends AdminControlador
{

    public function listar(): void
    {
        $clientes = new ClienteModelo();
        echo $this->template->renderizar('clientes/listar.html', [
            'clientes' => $clientes->busca()->ordem('nome_cliente ASC')->resultado(true),
            'total' => [
                'clientes' => $clientes->total(),
                'clientesAtivo' => $clientes->busca('status = 1')->total(),
                'clientesInativo' => $clientes->busca('status = 0')->total()
        ]]);
    }

    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            if ($this->validarDados($dados)) {
                $clientes = new ClienteModelo();

                $clientes->nome_cliente = $dados['nome_cliente'];
                $clientes->endereco_cliente = $dados['endereco_cliente'];
                $clientes->bairro_cli = $dados['bairro_cli'];
                $clientes->cidade_cli = $dados['cidade_cli'];
                $clientes->estado_cli = $dados['estado_cli'];
                $clientes->telefone_cli = $dados['telefone_cli'];
                $clientes->email_cli = $dados['email_cli'];
                $clientes->responsavel_empresa = $dados['responsavel_empresa'];
                $clientes->whatsapp = $dados['whatsapp'];
                $clientes->cnpj_fabrica = $dados['cnpj_fabrica'];
                $clientes->slug = Helpers::slug($dados['nome_cliente']);
                $clientes->status = $dados['status'];

                if ($clientes->salvar()) {
                    $this->mensagem->sucesso('Cliente cadastrado com sucesso')->flash();
                    Helpers::redirecionar('admin/clientes/listar');
                }
            }
        }

        echo $this->template->renderizar('clientes/formulario.html', [
            ///***ver qual classe cliente????          
            'clientes' => $dados]);
    }

    public function editar(int $id): void
    {
        $clientes = (new ClienteModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            $clientes = (new ClienteModelo())->buscaPorId($id);

            $clientes->nome_cliente = $dados['nome_cliente'];
            $clientes->endereco_cliente = $dados['endereco_cliente'];
            $clientes->bairro_cli = $dados['bairro_cli'];
            $clientes->cidade_cli = $dados['cidade_cli'];
            $clientes->estado_cli = $dados['estado_cli'];
            $clientes->telefone_cli = $dados['telefone_cli'];
            $clientes->email_cli = $dados['email_cli'];
            $clientes->responsavel_empresa = $dados['responsavel_empresa'];
            $clientes->whatsapp = $dados['whatsapp'];
            $clientes->cnpj_fabrica = $dados['cnpj_fabrica'];
            $clientes->status = $dados['status'];

            if ($clientes->salvar()) {
                $this->mensagem->sucesso('Cliente atualizado com sucesso')->flash();
                Helpers::redirecionar('admin/clientes/listar');
            }
        }

        echo $this->template->renderizar('clientes/formulario.html', [
            ////**VER AQUI TAMBEM           
            'clientes' => $dados,
            'categorias' => (new CategoriaModelo())->busca()
        ]);
    }

    public function deletar(int $id): void
    {
//        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (is_int($id)) {
            $clientes = (new ClienteModelo())->buscaPorId($id);
            if (!$clientes) {
                $this->mensagem->alerta('O Cliente que você está tentando deletar não existe!')->flash();
                Helpers::redirecionar('admin/clientes/listar');
            } else {
                if ($clientes->deletar()) {
                    $this->mensagem->sucesso('Cliente deletado com sucesso!')->flash();
                    Helpers::redirecionar('admin/clientes/listar');
                } else {
                    $this->mensagem->erro($clientes->erro())->flash();
                    Helpers::redirecionar('admin/clientes/listar');
                }
            }
        }
    }

}
