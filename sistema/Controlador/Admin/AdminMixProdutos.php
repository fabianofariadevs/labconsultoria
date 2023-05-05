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
        $mix = new MixProdutosModelo();

        echo $this->template->renderizar('mixProdutos/listar.html', [
            'mixproduto' => $mix->busca()->ordem('id_tbl_produto_mix ASC')->resultado(true),
            'total' => [
                'mixproduto' => $mix->total(),
                'mixprodutoAtiva' => $mix->busca('status = 1')->total(),
                'mixprodutoInativa' => $mix->busca('status = 0')->total(),
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
                $mix = new MixProdutosModelo();
                $mix->usuario_id = $this->usuario->id;
                $mix->slug = Helpers::slug($dados['produto_mix']);
                $mix->cod_prod_mix = $dados['cod_prod_mix'];
                $mix->produto_mix = $dados['produto_mix'];
                $mix->departamento = $dados['departamento'];
                $mix->rendimento_receita_kg = $dados['rendimento_receita_kg'];
                $mix->rendimento_receita_unid = $dados['rendimento_receita_unid'];
                $mix->validade_produto = $dados['validade_produto'];
                $mix->categoria_produto = $dados['categoria_produto'];
                $mix->status = $dados['status'];

                if ($mix->salvar()) {
                    $this->mensagem->sucesso('Mix de Produtos cadastrado com sucesso')->flash();
                    Helpers::redirecionar('admin/mixProdutos/listar');
                } else {
                    $this->mensagem->erro($mix->erro())->flash();
                    Helpers::redirecionar('admin/mixProdutos/listar');
                }
            }
        }

        echo $this->template->renderizar('mixProdutos/formulario.html', [
            'mixproduto' => (new MixProdutosModelo())->busca()
        ]);
    }

}
