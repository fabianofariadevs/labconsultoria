<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\MixProdutosModelo;
use sistema\Nucleo\Helpers;

/**
 * Classe AdminMixProdutos
 *
 * @author Fabiano Faria
 */
class AdminMixProdutos extends AdminControlador
{

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
            'mixproduto' => $dados]);
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
            'mixproduto' => $mixproduto]);
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
