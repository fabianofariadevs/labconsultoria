<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\EstoqueMpModelo;
use sistema\Nucleo\Helpers;

/**
 * Classe AdminPosts
 *
 * @author Ronaldo Aires
 */
class AdminEstoqueMp extends AdminControlador
{

    /**
     * Lista EstoqueMp
     * @autor Fabiano Faria
     * @return void
     */
    public function listar(): void
    {
        $post = new EstoqueMpModelo();

        echo $this->template->renderizar('estoqueMp/listar.html', [
            'tbl_materia_prima' => $post->busca()->ordem('status ASC, id DESC')->resultado(true),
            'total' => [
                'tbl_materia_prima' => $post->total(),
                'tbl_materia_prima' => $post->busca('status = 1')->total(),
                'tbl_materia_prima' => $post->busca('status = 0')->total()
            ]
        ]);
    }

    public function consultar(): void
    {
        $post = new EstoqueMpModelo();

        echo $this->template->renderizar('estoqueMp/consultar.html', [
        ]);
    }

    /**
     * Cadastra posts
     * @return void
     */
    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            if ($this->validarDados($dados)) {
                $post = new EstoqueMpModelo();

                $post->usuario_id = $this->usuario->id;
                $post->id_mp = $dados['id_mp'];
                $post->produto_mp = $dados['produto_mp'];
                $post->descricao_mp = $dados['descricao_mp'];
                $post->fornecedor_id = $dados['fornecedor_id'];
                $post->compra_unid_kg = $dados['compra_unid_kg'];
                $post->peso_pcte = $dados['peso_pcte'];
                $post->custo_ultima_compra = $dados['custo_ultima_compra'];
                $post->valor_kg = $dados['valor_kg'];
                $post->status = $dados['status'];

                if ($post->salvar()) {
                    $this->mensagem->sucesso('Produto cadastrado com sucesso')->flash();
                    Helpers::redirecionar('admin/EstoqueMp/listar');
                } else {
                    $this->mensagem->erro($post->erro())->flash();
                    Helpers::redirecionar('admin/EstoqueMp/listar');
                }
            }
        }

        echo $this->template->renderizar('estoqueMp/formulario.html', [
            'tbl_materia_prima' => (new EstoqueMpModelo())->busca()->resultado(true),
            'tbl_fornecedor' => $dados
        ]);
    }

    /**
     * Edita EstoqueMp pelo ID
     * @param int $id
     * @return void
     */
    public function editar(int $id): void
    {
        $post = (new EstoqueMpModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            if ($this->validarDados($dados)) {
                $post = (new EstoqueMpModelo())->buscaPorId($id);

                $post->usuario_id = $this->usuario->id;
                $post->id_mp = $dados['id_mp'];
                $post->produto_mp = $dados['produto_mp'];
                $post->descricao_mp = $dados['descricao_mp'];
                $post->fornecedor_id = $dados['fornecedor_id'];
                $post->compra_unid_kg = $dados['compra_unid_kg'];
                $post->peso_pcte = $dados['peso_pcte'];
                $post->custo_ultima_compra = $dados['custo_ultima_compra'];
                $post->valor_kg = $dados['valor_kg'];
                $post->status = $dados['status'];
                
                if ($post->salvar()) {
                    $this->mensagem->sucesso('Produto atualizado com sucesso')->flash();
                    Helpers::redirecionar('admin/estoqueMp/listar');
                } else {
                    $this->mensagem->erro($post->erro())->flash();
                    Helpers::redirecionar('admin/estoqueMp/listar');
                }
            }
        }

        echo $this->template->renderizar('estoqueMp/formulario.html', [
            'tbl_materia_prima' => $post,
            'tbl_fornecedor' => (new FornecedorModelo())->busca()->resultado(true)
        ]);
    }

    /**
     * Valida os dados do formulário
     * @param array $dados
     * @return bool
     */
    public function validarDados(array $dados): bool
    {
        if (empty($dados['produto_mp'])) {
            $this->mensagem->alerta('Escreva o nome do produto!')->flash();
            return false;
        }
        if (empty($dados['descricao_mp'])) {
            $this->mensagem->alerta('Escreva descrição do produto!')->flash();
            return false;
        }
        if (empty($dados['compra_unid_kg'])) {
            $this->mensagem->alerta('Escreva qual unidade de compra do produto!')->flash();
            return false;
        }
        if (empty($dados['peso_pcte'])) {
            $this->mensagem->alerta('Escreva o peso do produto!')->flash();
            return false;
        }
        if (empty($dados['custo_ultima_compra'])) {
            $this->mensagem->alerta('Qual custo da Ultima Compra desse produto?')->flash();
            return false;
        }
        if (empty($dados['valor_kg'])) {
            $this->mensagem->alerta('Escreva o valor KG do produto!')->flash();
            return false;
        }

        return true;
    }

    /**
     * Deleta posts por ID
     * @param int $id
     * @return void
     */
    public function deletar(int $id): void
    {
        if (is_int($id)) {
            $post = (new EstoqueMpModelo())->buscaPorId($id);
            if (!$post) {
                $this->mensagem->alerta('O Produto que você está tentando deletar não existe!')->flash();
                Helpers::redirecionar('admin/estoqueMp/listar');
            } else {
                if ($post->deletar()) {
                    $this->mensagem->sucesso('Produto deletado com sucesso!')->flash();
                    Helpers::redirecionar('admin/estoqueMp/listar');
                } else {
                    $this->mensagem->erro($post->erro())->flash();
                    Helpers::redirecionar('admin/estoqueMp/listar');
                }
            }
        }
    }

    ######

    public function inventario(): void
    {
        echo $this->template->renderizar('estoqueMp/inventario.html', [
                ]
        );
    }

}
