<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\ProducaoModelo;
use sistema\Modelo\ClienteModelo;
use sistema\Modelo\FornecedorModelo;
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
            5 => 'tbl_loja_pdv_id_tbl_loja_pdv',
            6 => 'id_cliente_fabrica',
            7 => 'status',
        ];

        $ordem = " " . $colunas[$datatable['order'][0]['column']] . " ";
        $ordem .= " " . $datatable['order'][0]['dir'] . " ";

        $mixproduto = new MixProdutosModelo();

        if (empty($busca)) {
            $mixproduto->busca()->ordem($ordem)->limite($limite)->offset($offset);
            $mixproduto = (new MixProdutosModelo())->busca(null, 'COUNT(id)', 'id')->total();
        } else {
            $mixproduto->busca("id LIKE '%{$busca}%' OR produto_mix LIKE '%{$busca}%' ")->limite($limite)->offset($offset);
            $total = $mixproduto->total();
        }

        $dados = [];

        if ($mixproduto->resultado(true)) {
            foreach ($mixproduto->resultado(true) as $mix) {
                $dados[] = [
                    $mix->id,
                    $mix->data_pedido_prod,
                    $mix->descricao_pedido,
                    $mix->qtde_pedido,
                    $mix->data_entrega_pedido,
                    $mix->tbl_loja_pdv_id_tbl_loja_pdv,
                    $mix->id_cliente_fabrica,
                    $mix->status
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

        echo $this->template->renderizar('producao/listar.html', [
            'producao' => $producao->busca()->ordem('data_pedido_prod ASC')->resultado(true),
            'total' => [
                'producao' => $producao->total(),
                'producaoAtiva' => $producao->busca('status = 1')->total(),
                'producaoInativa' => $producao->busca('status = 0')->total(),
            ]
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
                $producao->tbl_loja_pdv_id_tbl_loja_pdv = $dados['tbl_loja_pdv_id_tbl_loja_pdv '];
                $producao->id_cliente_fabrica = $dados['id_cliente_fabrica '];
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
            'producao' => $dados
         //   'cliente' => (new ClienteModelo())->busca('status = 1')->resultado(true)
        ]);
    }

    public function validarDados(array $dados): bool
    {

        if (empty($dados['descricao_pedido'])) {
            $this->mensagem->alerta('Escreva uma Descrição para o Produção!')->flash();
            return false;
        }
        if (empty($dados['qtde_pedido'])) {
            $this->mensagem->alerta('Escreva uma Qtde para o Produção!')->flash();
            return false;
        }
        if (empty($dados['data_entrega_pedido'])) {
            $this->mensagem->alerta('Escreva uma data_entrega_pedido para o Produção!')->flash();
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
                $producao->tbl_loja_pdv_id_tbl_loja_pdv = $dados['tbl_loja_pdv_id_tbl_loja_pdv '];
                $producao->id_cliente_fabrica = $dados['id_cliente_fabrica '];
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
            'producao' => $producao,
            'cliente' => (new ClienteModelo())->busca('status = 1')->resultado(true)
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
