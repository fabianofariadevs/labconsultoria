<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\PdvModelo;
use sistema\Nucleo\Helpers;

/* Classe AdminClientes
 *
 * @author Fabiano Faria
 */

class AdminPdv extends AdminControlador
{
    /**
     * Método responsável por exibir os dados tabulados utilizando o plugin datatables
     * @return void
     */

    /**
     * Lista CLIENTES
     * @return void
     */
    public function listar(): void
    {
        $pdvs = new PdvModelo();

        echo $this->template->renderizar('pdvs/listar.html', [
            'total' => [
                'pdvs' => $pdvs->busca(null, 'COUNT(id)', 'id')->total(),
                'pdvsAtivo' => $pdvs->busca('status = :s', 's=1 COUNT(status))', 'status')->total(),
                'pdvsInativo' => $pdvs->busca('status = :s', 's=0 COUNT(status)', 'status')->total(),
        ]]);
    }

    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            if ($this->validarDados($dados)) {
                $pdvs = new PdvModelo();

                $pdvs->usuario_id = $this->usuario->id;
                $pdvs->cod_pdv = $dados['cod_pdv'];
                $pdvs->id_cliente_fabrica = $dados['id_cliente_fabrica'];
                $pdvs->cnpj_loja = $dados['cnpj_loja'];
                $pdvs->nome_loja = $dados['nome_loja'];
                $pdvs->responsavel_loja = $dados['responsavel_loja'];
                $pdvs->endereco_loja = $dados['endereco_loja'];
                $pdvs->bairro_loja = $dados['bairro_loja'];
                $pdvs->cidade_loja = $dados['cidade_loja'];
                $pdvs->uf_loja = $dados['uf_loja'];
                $pdvs->telefone = $dados['telefone'];
                $pdvs->status = $dados['status'];

                if ($pdvs->salvar()) {
                    $this->mensagem->sucesso('Cliente cadastrado com sucesso')->flash();
                    Helpers::redirecionar('admin/pdvs/listar');
                } else {
                    $this->mensagem->erro($pdvs->erro())->flash();
                    Helpers::redirecionar('admin/pdvs/listar');
                }
            }
        }
        echo $this->template->renderizar('pdvs/formulario.html', [
            ///***ver qual classe cliente????          
            'clientes' => (new ClienteModelo())->busca('status = 1')->resultado(true),
            'pdv' => $dados]);
    }

    public function validarDados(array $dados): bool
    {

        if (empty($dados['nome_loja'])) {
            $this->mensagem->alerta('Escreva um nome para o PDV!')->flash();
            return false;
        }
        if (empty($dados['endereco_loja'])) {
            $this->mensagem->alerta('Escreva um endereço para o PDV!')->flash();
            return false;
        }
        if (empty($dados['bairro_loja'])) {
            $this->mensagem->alerta('Escreva um bairro para o PDV!')->flash();
            return false;
        }
        return true;
    }

    public function editar(int $id): void
    {
        $pdvs = (new PdvModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            if ($this->validarDados($dados)) {
                $pdvs = (new PdvModelo())->buscaPorId($id);

                $pdvs->usuario_id = $this->usuario->id;
                $pdvs->id_cliente_fabrica = $dados['id_cliente_fabrica'];
                $pdvs->cnpj_loja = $dados['cnpj_loja'];
                $pdvs->nome_loja = $dados['nome_loja'];
                $pdvs->responsavel_loja = $dados['responsavel_loja'];
                $pdvs->endereco_loja = $dados['endereco_loja'];
                $pdvs->bairro_loja = $dados['bairro_loja'];
                $pdvs->cidade_loja = $dados['cidade_loja'];
                $pdvs->uf_loja = $dados['uf_loja'];
                $pdvs->telefone = $dados['telefone'];
                $pdvs->status = $dados['status'];

                if ($pdvs->salvar()) {
                    $this->mensagem->sucesso('Cliente atualizado com sucesso')->flash();
                    Helpers::redirecionar('admin/pdvs/listar');
                } else {
                    $this->mensagem->erro($pdvs->erro())->flash();
                    Helpers::redirecionar('admin/pdvs/listar');
                }
            }
        }

        echo $this->template->renderizar('pdvs/formulario.html', [
            ////**VER AQUI TAMBEM           
            'clientes' => (new ClienteModelo())->busca('status = 1')->resultado(true),
            'pdv' => $pdvs,
        ]);
    }

    public
            function deletar(int $id): void
    {
//        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (is_int($id)) {
            $pdvs = (new ClienteModelo())->buscaPorId($id);
            if (!$pdvs) {
                $this->mensagem->alerta('O Cliente que você está tentando deletar não existe!')->flash();
                Helpers::redirecionar('admin/pdvs/listar');
            } else {
                if ($pdvs->deletar()) {
                    $this->mensagem->sucesso('Cliente deletado com sucesso!')->flash();
                    Helpers::redirecionar('admin/pdvs/listar');
                } else {
                    $this->mensagem->erro($pdvs->erro())->flash();
                    Helpers::redirecionar('admin/pdvs/listar');
                }
            }
        }
    }

}
