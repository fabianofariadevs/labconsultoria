<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\ProducaoModelo;
use sistema\Nucleo\Helpers;

/**
 * Classe AdminProdução
 *
 * @author Fabiano Faria
 */
class AdminProducao extends AdminControlador
{

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
                $post = new ProducaoModelo();

                $post->usuario_id = $this->usuario->id;
                $post->categoria_id = $dados['categoria_id'];
                $post->slug = Helpers::slug($dados['titulo']);
                $post->titulo = $dados['titulo'];
                $post->texto = $dados['texto'];
                $post->status = $dados['status'];

                if ($post->salvar()) {
                    $this->mensagem->sucesso('Produção cadastrado com sucesso')->flash();
                    Helpers::redirecionar('admin/producao/listar');
                } else {
                    $this->mensagem->erro($post->erro())->flash();
                    Helpers::redirecionar('admin/producao/listar');
                }
            }
        }

        echo $this->template->renderizar('producao/formulario.html', [
            'producao' => (new ProducaoModelo())->busca()
        ]);
    }

}
