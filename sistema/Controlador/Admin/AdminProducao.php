<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\ProducaoModelo;
use sistema\Modelo\ClienteModelo;
use sistema\Modelo\PdvModelo;
use sistema\Nucleo\Helpers;

/**
 * Classe AdminProdução
 *
 * @author Fabiano Faria
 */
class AdminProducao extends AdminControlador
{

    /**
     * Método responsável por exibir os dados tabulados utilizando o plugin datatables
     * @return void
     */
    public function datatable(): void
    {
        $datatable = $_REQUEST;
        $datatable = filter_var_array($datatable, FILTER_SANITIZE_SPECIAL_CHARS);

        $limite = $datatable['length'];
        $offset = $datatable['start'];
        $busca = $datatable['search']['value'];

        $colunas = [
            0 => 'id',
            1 => 'data_pedido_prod',
            2 => 'descricao_pedido',
            3 => 'qtde_pedido',
            4 => 'data_entrega_pedido',
            5 => 'id_loja_pdv',
            6 => 'id_cliente_fabrica',
            7 => 'status',
        ];

        $ordem = " " . $colunas[$datatable['order'][0]['column']] . " ";
        $ordem .= " " . $datatable['order'][0]['dir'] . " ";

        $producao = new ProducaoModelo();

        if (empty($busca)) {
            $producao->busca()->ordem($ordem)->limite($limite)->offset($offset);
            $total = (new ProducaoModelo())->busca(null, 'COUNT(id)', 'id')->total();
        } else {
            $producao->busca("id LIKE '%{$busca}%' OR descricao_pedido LIKE '%{$busca}%' ")->limite($limite)->offset($offset);
            $total = $producao->total();
        }

        $dados = [];

        if ($producao->resultado(true)) {
            foreach ($producao->resultado(true) as $prod) {
                $dados[] = [
                    $prod->id,
                    $prod->data_pedido_prod,
                    $prod->descricao_pedido,
                    $prod->qtde_pedido,
                    $prod->data_entrega_pedido,
                    $prod->pdv()->nome_loja ?? '-----',
                    $prod->cliente()->nome_cliente ?? '-----',
                    $prod->status
                ];
            }
        }
        $retorno = [
            "draw" => $datatable['draw'],
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $dados
        ];

        echo json_encode($retorno);
    }

    /**
     * Lista PEDIDOS PRODUÇÃO
     * @return void
     */
    public function listar(): void
    {
        $producao = new ProducaoModelo();
        $pdvs = new PdvModelo();

        echo $this->template->renderizar('producao/listar.html', [
            'total' => [
                'producao' => $producao->busca(null, 'COUNT(id)', 'id')->total(),
                'producaoAtiva' => $producao->busca('status = :s', 's=1 COUNT(status))', 'status')->total(),
                'producaoInativa' => $producao->busca('status = :s', 's=0 COUNT(status))', 'status')->total(),
            ],
            'pdvs' => $pdvs->busca(null, 'COUNT(id)', 'id')->total(),
            'pdvsAtivo' => $pdvs->busca('status = :s', 's=1 COUNT(status))', 'status')->total(),
            'pdvsInativo' => $pdvs->busca('status = :s', 's=0 COUNT(status)', 'status')->total(),
        ]);
    }

    /**
     * Cadastra Produção
     * @return void
     */
    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            if ($this->validarDados($dados)) {
                $producao = new ProducaoModelo();

                $producao->usuario_id = $this->usuario->id;
                $producao->data_pedido_prod = $dados['data_pedido_prod'];
                $producao->descricao_pedido = $dados['descricao_pedido'];
                $producao->qtde_pedido = $dados['qtde_pedido'];
                $producao->data_entrega_pedido = $dados['data_entrega_pedido'];
                $producao->id_loja_pdv = $dados['id_loja_pdv'];
                $producao->id_cliente_fabrica = $dados['id_cliente_fabrica'];
                $producao->status = $dados['status'];

                if ($producao->salvar()) {
                    $this->mensagem->sucesso('Produção cadastrada com sucesso')->flash();
                    Helpers::redirecionar('admin/producao/listar');
                } else {
                    $this->mensagem->erro($producao->erro())->flash();
                    Helpers::redirecionar('admin/producao/listar');
                }
            }
        }

        echo $this->template->renderizar('producao/formulario.html', [
            'prod' => $dados,
            'clientes' => (new ClienteModelo())->busca('status = 1')->resultado(true),
            'pdv' => (new PdvModelo())->busca('status = 1')->resultado(true)
        ]);
    }

    public function validarDados(array $dados): bool
    {

        if (empty($dados['descricao_pedido'])) {
            $this->mensagem->alerta('Escreva uma Descrição para o Pedido!')->flash();
            return false;
        }
        if (empty($dados['qtde_pedido'])) {
            $this->mensagem->alerta('Escreva uma Qtde para o Pedido!')->flash();
            return false;
        }
        if (empty($dados['data_entrega_pedido'])) {
            $this->mensagem->alerta('Escreva uma data_entrega_pedido para o Pedido!')->flash();
            return false;
        }

        return true;
    }

    public function editar(int $id): void
    {
        $producao = (new ProducaoModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            if ($this->validarDados($dados)) {
                $producao = (new ProducaoModelo())->buscaPorId($id);

                $producao->usuario_id = $this->usuario->id;
                $producao->data_pedido_prod = $dados['data_pedido_prod'];
                $producao->descricao_pedido = $dados['descricao_pedido'];
                $producao->qtde_pedido = $dados['qtde_pedido'];
                $producao->data_entrega_pedido = $dados['data_entrega_pedido'];
                $producao->id_loja_pdv = $dados['id_loja_pdv'];
                $producao->id_cliente_fabrica = $dados['id_cliente_fabrica'];
                $producao->status = $dados['status'];

                if ($producao->salvar()) {
                    $this->mensagem->sucesso('Mix_Produto atualizado com sucesso')->flash();
                    Helpers::redirecionar('admin/producao/listar');
                } else {
                    $this->mensagem->erro($producao->erro())->flash();
                    Helpers::redirecionar('admin/producao/listar');
                }
            }
        }

        echo $this->template->renderizar('producao/formulario.html', [
////**VER AQUI TAMBEM           
            'prod' => $producao,
            'clientes' => (new ClienteModelo())->busca('status = 1')->resultado(true)
        ]);
    }

    public
            function deletar(int $id): void
    {
//        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (is_int($id)) {
            $producao = (new ProducaoModelo())->buscaPorId($id);
            if (!$producao) {
                $this->mensagem->alerta('O Produto que você está tentando deletar não existe!')->flash();
                Helpers::redirecionar('admin/producao/listar');
            } else {
                if ($producao->deletar()) {
                    $this->mensagem->sucesso('Produção deletado com sucesso!')->flash();
                    Helpers::redirecionar('admin/producao/listar');
                } else {
                    $this->mensagem->erro($producao->erro())->flash();
                    Helpers::redirecionar('admin/producao/listar');
                }
            }
        }
    }

}
