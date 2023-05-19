<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\MixProdutosModelo;
use sistema\Modelo\ClienteModelo;
use sistema\Nucleo\Helpers;

/**
 * Classe AdminMixProdutos
 *
 * @author Fabiano Faria
 */
class AdminMixProdutos extends AdminControlador
{

    private string $capa;

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
            1 => 'cod_prod_mix',
            2 => 'produto_mix',
            3 => 'departamento',
            4 => 'rendimento_receita_kg',
            5 => 'rendimento_receita_unid',
            6 => 'validade_produto',
            7 => 'categoria_produto',
            8 => 'id_cli_fabrica',
            9 => 'status',
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
                    $mix->cod_prod_mix,
                    $mix->produto_mix,
                    $mix->departamento,
                    $mix->rendimento_receita_kg,
                    $mix->rendimento_receita_unid,
                    $mix->validade_produto,
                    $mix->categoria_produto,
                    $mix->cliente()->nome_cliente ?? '-----',
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
     * Lista MIX Produtos
     * @return void
     */
    public function listar(): void
    {
        $mixproduto = new MixProdutosModelo();

        echo $this->template->renderizar('mixProdutos/listar.html', [
            'mixproduto' => $mixproduto->busca()->ordem('id ASC')->resultado(true),
            'total' => [
                'mixproduto' => $mixproduto->total(),
                'mixprodutoAtiva' => $mixproduto->busca('status = 1')->total(),
                'mixprodutoInativa' => $mixproduto->busca('status = 0')->total(),
            ]
        ]);
    }

    /**
     * Cadastra Novo MixProduto
     * @return void
     */
    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            if ($this->validarDados($dados)) {
                $mixproduto = new MixProdutosModelo();

                $mixproduto->usuario_id = $this->usuario->id;
                $mixproduto->slug = Helpers::slug($dados['produto_mix']);
                $mixproduto->cod_prod_mix = $dados['cod_prod_mix'];
                $mixproduto->produto_mix = $dados['produto_mix'];
                $mixproduto->departamento = $dados['departamento'];
                $mixproduto->rendimento_receita_kg = $dados['rendimento_receita_kg'];
                $mixproduto->rendimento_receita_unid = $dados['rendimento_receita_unid'];
                $mixproduto->validade_produto = $dados['validade_produto'];
                $mixproduto->categoria_produto = $dados['categoria_produto'];
                $mixproduto->id_cli_fabrica = $dados['id_cli_fabrica'];
                $mixproduto->status = $dados['status'];

                if ($mixproduto->salvar()) {
                    $this->mensagem->sucesso('Mix de Produtos cadastrado com sucesso')->flash();
                    Helpers::redirecionar('admin/mixProdutos/listar');
                } else {
                    $this->mensagem->erro($mixproduto->erro())->flash();
                    Helpers::redirecionar('admin/mixProdutos/listar');
                }
            }
        }

        echo $this->template->renderizar('mixProdutos/formulario.html', [
            'clientes' => (new ClienteModelo())->busca('status = 1')->resultado(true),
            'mixproduto' => $dados
        ]);
    }

    public function validarDados(array $dados): bool
    {

        if (empty($dados['cod_prod_mix'])) {
            $this->mensagem->alerta('Escreva um Código para o Produto!')->flash();
            return false;
        }
        if (empty($dados['produto_mix'])) {
            $this->mensagem->alerta('Escreva um Nome para o Produto!')->flash();
            return false;
        }
        if (empty($dados['departamento'])) {
            $this->mensagem->alerta('Escreva um departamento para o Produto!')->flash();
            return false;
        }
        if (empty($dados['rendimento_receita_kg'])) {
            $this->mensagem->alerta('Define o rendimento da receita!')->flash();
            return false;
        }
        if (empty($dados['rendimento_receita_unid'])) {
            $this->mensagem->alerta('Define uma Validade para a receita!')->flash();
            return false;
        }
        if (empty($dados['validade_produto'])) {
            $this->mensagem->alerta('Define uma Validade para o Produto!')->flash();
            return false;
        }
        if (empty($dados['categoria_produto'])) {
            $this->mensagem->alerta('Define uma Categoria para o Produto!')->flash();
            return false;
        }
        return true;
    }

    public function editar(int $id): void
    {
        $mixproduto = (new MixProdutosModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            if ($this->validarDados($dados)) {
                $mixproduto = (new MixProdutosModelo())->buscaPorId($id);

                $mixproduto->usuario_id = $this->usuario->id;
                $mixproduto->slug = Helpers::slug($dados['produto_mix']);
                $mixproduto->cod_prod_mix = $dados['cod_prod_mix'];
                $mixproduto->produto_mix = $dados['produto_mix'];
                $mixproduto->departamento = $dados['departamento'];
                $mixproduto->rendimento_receita_kg = $dados['rendimento_receita_kg'];
                $mixproduto->rendimento_receita_unid = $dados['rendimento_receita_unid'];
                $mixproduto->validade_produto = $dados['validade_produto'];
                $mixproduto->categoria_produto = $dados['categoria_produto'];
                $mixproduto->id_cli_fabrica = $dados['id_cli_fabrica'];
                $mixproduto->atualizado_em = date('Y-m-d H:i:s');
                $mixproduto->status = $dados['status'];

                if ($mixproduto->salvar()) {
                    $this->mensagem->sucesso('Mix_Produto atualizado com sucesso')->flash();
                    Helpers::redirecionar('admin/mixProdutos/listar');
                } else {
                    $this->mensagem->erro($mixproduto->erro())->flash();
                    Helpers::redirecionar('admin/mixProdutos/listar');
                }
            }
        }

        echo $this->template->renderizar('mixProdutos/formulario.html', [
////**VER AQUI TAMBEM           
            'mixproduto' => $mixproduto,
            'cliente' => (new ClienteModelo())->busca('status = 1')->resultado(true)
        ]);
    }

    public
            function deletar(int $id): void
    {
//        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (is_int($id)) {
            $mixproduto = (new MixProdutosModelo())->buscaPorId($id);
            if (!$mixproduto) {
                $this->mensagem->alerta('O Produto que você está tentando deletar não existe!')->flash();
                Helpers::redirecionar('admin/mixProdutos/listar');
            } else {
                if ($mixproduto->deletar()) {
                    $this->mensagem->sucesso('Mix_Produto deletado com sucesso!')->flash();
                    Helpers::redirecionar('admin/mixProdutos/listar');
                } else {
                    $this->mensagem->erro($mixproduto->erro())->flash();
                    Helpers::redirecionar('admin/mixProdutos/listar');
                }
            }
        }
    }

}
