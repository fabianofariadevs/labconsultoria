<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\CompraModelo;
use sistema\Nucleo\Helpers;

/**
 * Classe AdminCompras
 *
 * @author Fabiano Faria
 */
class AdminCompras extends AdminControlador
{
    /**
     * Lista compras
     * @return void
     */
    public function listar(): void
    {
        $compras = new CompraModelo();

        echo $this->template->renderizar('compras/listar.html', [
            'compras' => $compras->busca(),
            'total' => [
                'compras' => $compras->total(),
                'comprasAtiva' => $compras->total('status = 1'),
                'comprasInativa' => $compras->total('status = 0')
            ]
        ]);
    }
    
    /**
     * Listar histórico de compras
     * @return void
     */
    public function historico(): void
    {
        $compras = new CompraModelo();

        echo $this->template->renderizar('compras/historico.html', [
            'compras' => $compras->busca(),
            'total' => [
                'compras' => $compras->total(),
                'comprasAtiva' => $compras->total('status = 1'),
                'comprasInativa' => $compras->total('status = 0')
            ]
        ]);
    }
    
    public function consultar(): void
    {
        $post = new CompraModelo();

        echo $this->template->renderizar('compras/consultar.html', [
        ]);
    }

    /**
     * Cadastra uma compra
     * @return void
     */
    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            if ($this->validarDados($dados)) {
            $compras = new CompraModelo();

                $compras->usuario_id = $this->usuario->id;
                $compras->slug = Helpers::slug($dados['titulo']);
                $compras->titulo = $dados['titulo'];
                $compras->texto = $dados['texto'];
                $compras->status = $dados['status'];

                if ($compras->salvar()) {
                    $this->mensagem->sucesso('pedido de compra cadastrado com sucesso')->flash();
                    Helpers::redirecionar('admin/compras/listar');
                } else {
                    $this->mensagem->erro($compras->erro())->flash();
                    Helpers::redirecionar('admin/compras/listar');
                }
            }
        }

        echo $this->template->renderizar('compras/formulario.html', [
            'compras' => $dados]);
    }

    public function editar(int $id): void
    {
        $compras = (new CompraModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            if ($this->validarDados($dados)) {
                $compras = (new CompraModelo())->buscaPorId($compras->id);

                $compras->usuario_id = $this->usuario->id;
                $compras->slug = Helpers::slug($dados['titulo']);
                $compras->titulo = $dados['titulo'];
                $compras->texto = $dados['texto'];
                $compras->status = $dados['status'];
                $compras->atualizado_em = date('Y-m-d H:i:s');

                if ($compras->salvar()) {
                    $this->mensagem->sucesso('Compras atualizada com sucesso')->flash();
                    Helpers::redirecionar('admin/compras/listar');
                } else {
                    $this->mensagem->erro($compras->erro())->flash();
                    Helpers::redirecionar('admin/compras/listar');
                }
            }
        }
        echo $this->template->renderizar('compras/formulario.html', [
            'compras' => $compras
        ]);
    }
    /**
     * Valida os dados do formulário
     * @param array $dados
     * @return bool
     */
    private function validarDados(array $dados): bool
    {
        if (empty($dados['titulo'])) {
            $this->mensagem->alerta('Escreva um título para a Categoria!')->flash();
            return false;
        }
        return true;
    }

    /**
     * Deleta uma categoria pelo ID
     * @param int $id
     * @return void
     */
    public function deletar(int $id): void
    {
        if (is_int($id)) {
            $compras = (new CompraModelo())->buscaPorId($id);

            if (!$compras) {
                $this->mensagem->alerta('A compra que você está tentando deletar não existe!')->flash();
                Helpers::redirecionar('admin/compras/listar');
            } elseif ($compras->posts($compras->id)) {
                $this->mensagem->alerta("A compra {$compras->titulo} tem posts cadastrados, delete ou altere os posts antes de deletar!")->flash();
                Helpers::redirecionar('admin/compras/listar');
            } else {
                if ($compras->deletar()) {
                    $this->mensagem->sucesso('Compra deletada com sucesso!')->flash();
                    Helpers::redirecionar('admin/compras/listar');
                } else {
                    $this->mensagem->erro($compras->erro())->flash();
                    Helpers::redirecionar('admin/compras/listar');
                }
            }
        }
    }
        /**
     * Busca Pedidos de Compras 
     * @return void
     */
    public function buscar(): void
    {
        $busca = filter_input(INPUT_POST, 'busca', FILTER_DEFAULT);
        if (isset($busca)) {
            $compras = (new CompraModelo())->busca("status = 1 AND produto_mp LIKE '%{$busca}%'")->resultado(true);
            if ($compras) {
                foreach ($compras as $compra) {
                    echo "<li class='list-group-item fw-bold'><a href=" . Helpers::url('compra/') . $compra->id . ">$compra->produto_mp</a></li>";
                }
            }
        }
    }



}
