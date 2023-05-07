<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\ReceitaModelo;
use sistema\Modelo\FornecedorModelo;
use sistema\Modelo\ClienteModelo;
use sistema\Nucleo\Helpers;

/**
 * Classe AdminReceitas
 *
 * @author Fabiano Faria
 */
class AdminReceitas extends AdminControlador
{

    /**
     * Lista Receitas
     * @return void
     */
    public function listar(): void
    {
        $receita = new ReceitaModelo();
        $fornecedor = new FornecedorModelo();
        $cliente = new ClienteModelo();

        echo $this->template->renderizar('receitas/listar.html', [
            'receitas' => $receita->busca()->ordem('nome_receita ASC')->resultado(true),
            'total' => [
                'receitas' => $receita->total(),
                'receitasAtiva' => $receita->busca('status = 1')->total(),
                'receitasInativa' => $receita->busca('status = 0')->total(),
            ],
            //listar dados tbl_cliente_fabrica
            'clientes' => $cliente->busca()->ordem('nome_cliente ASC')->resultado(true),
            'total' => [
                'clientes' => $cliente->total(),
                'clientesAtiva' => $cliente->busca('status = 1')->total(),
                'clientesInativa' => $cliente->busca('status = 0')->total(),
            ]
        ]);
    }

    /**
     * Cadastra Receita
     * @return void
     */
    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            if ($this->validarDados($dados)) {
                $receita = new ReceitaModelo();

                $receita->usuario_id = $this->usuario->id;
                $receita->nome_receita = $dados['nome_receita'];
                $receita->descricao_receita = $dados['descricao_receita'];
                $receita->modo_preparo = $dados['modo_preparo'];
                $receita->qtde_prevista_receita = $dados['qtde_prevista_receita'];
                $receita->validade_receita = $dados['validade_receita'];
                $receita->observacao_receita = $dados['observacao_receita'];
                $receita->status = $dados['status'];
                $receita->id_tbl_cliente_fabrica = $dados['id_tbl_cliente_fabrica'];
                $receita->tbl_produto_mix_id_tbl_produto_mix = $dados['tbl_produto_mix_id_tbl_produto_mix'];
                $receita->tbl_produto_mix_cod_prod_mix = $dados['tbl_produto_mix_cod_prod_mix'];
                $receita->slug = Helpers::slug($dados['nome_receita']);

                if ($receita->salvar()) {
                    $this->mensagem->sucesso('Receita cadastrada com sucesso')->flash();
                    Helpers::redirecionar('admin/receitas/listar');
                } else {
                    $this->mensagem->erro($receita->erro())->flash();
                    Helpers::redirecionar('admin/receitas/listar');
                }
            }
        }

        echo $this->template->renderizar('receitas/formulario.html', [
            'receitas' => (new ReceitaModelo())->busca()
        ]);
    }

}
