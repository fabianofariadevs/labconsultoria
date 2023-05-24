<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\ReceitaModelo;
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
            1 => 'nome_receita',
            2 => 'descricao_receita',
            3 => 'modo_preparo',
            4 => 'qtde_prevista_receita',
            5 => 'validade_receita',
            6 => 'id_tbl_cliente_fabrica',
            7 => 'status',
        ];

        $ordem = " " . $colunas[$datatable['order'][0]['column']] . " ";
        $ordem .= " " . $datatable['order'][0]['dir'] . " ";

        $receitas = new ReceitaModelo();

        if (empty($busca)) {
            $receitas->busca()->ordem($ordem)->limite($limite)->offset($offset);
            $total = (new ReceitaModelo())->busca(null, 'COUNT(id)', 'id')->total();
        } else {
            $receitas->busca("id LIKE '%{$busca}%' OR nome_receita LIKE '%{$busca}%' ")->limite($limite)->offset($offset);
            $total = $receitas->total();
        }

        $dados = [];

        if ($receitas->resultado(true)) {
            foreach ($receitas->resultado(true) as $receita) {
                $dados[] = [
                    $receita->id,
                    $receita->nome_receita,
                    $receita->descricao_receita,
                    $receita->modo_preparo,
                    $receita->qtde_prevista_receita,
                    $receita->validade_receita,
                    $receita->cliente()->nome_cliente ?? '-----',
                    $receita->status
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
     * Lista Receitas
     * @return void
     */
    public function listar(): void
    {
        $receita = new ReceitaModelo();

        echo $this->template->renderizar('receitas/listar.html', [
            'total' => [
                'receitas' => $receita->busca(null, 'COUNT(id)', 'id')->total(),
                'receitasAtiva' => $receita->busca('status = :s', 's=1 COUNT(status))', 'status')->total(),
                'receitasInativa' => $receita->busca('status = :s', 's=0 COUNT(status)', 'status')->total(),
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
                $receita->id_tbl_cliente_fabrica = $dados['id_tbl_cliente_fabrica'];
                $receita->status = $dados['status'];
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
            'clientes' => (new ClienteModelo())->busca('status = 1')->resultado(true),
            'receita' => $dados
        ]);
    }

    public function editar(int $id): void
    {
        $receita = (new ReceitaModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            if ($this->validarDados($dados)) {
                $receita = (new ReceitaModelo())->buscaPorId($id);

                $receita->usuario_id = $this->usuario->id;
                $receita->nome_receita = $dados['nome_receita'];
                $receita->descricao_receita = $dados['descricao_receita'];
                $receita->modo_preparo = $dados['modo_preparo'];
                $receita->qtde_prevista_receita = $dados['qtde_prevista_receita'];
                $receita->validade_receita = $dados['validade_receita'];
                $receita->observacao_receita = $dados['observacao_receita'];
                $receita->id_tbl_cliente_fabrica = $dados['id_tbl_cliente_fabrica'];
                $receita->status = $dados['status'];
                $receita->slug = Helpers::slug($dados['nome_receita']);

                if ($receita->salvar()) {
                    $this->mensagem->sucesso('Receita atualizada com sucesso')->flash();
                    Helpers::redirecionar('admin/receitas/listar');
                } else {
                    $this->mensagem->erro($receita->erro())->flash();
                    Helpers::redirecionar('admin/receitas/listar');
                }
            }
        }
        echo $this->template->renderizar('receitas/formulario.html', [
////**VER AQUI TAMBEM           
            'receita' => $receita,
            'clientes' => (new ClienteModelo())->busca('status = 1')->resultado(true)
        ]);
    }

    /**
     * Valida os dados do formulário
     * @param array $dados
     * @return bool
     */
    public function validarDados(array $dados): bool
    {

        if (empty($dados['nome_receita'])) {
            $this->mensagem->alerta('Escreva um Nome para a Receita!')->flash();
            return false;
        }
        if (empty($dados['descricao_receita'])) {
            $this->mensagem->alerta('Escreva uma Descrição para a Receita!')->flash();
            return false;
        }
        if (empty($dados['modo_preparo'])) {
            $this->mensagem->alerta('Escreva um modo preparo para a Receita!')->flash();
            return false;
        }
        if (empty($dados['qtde_prevista_receita'])) {
            $this->mensagem->alerta('Escreva uma qtde prevista para a Receita!')->flash();
            return false;
        }

        return true;
    }

    /**
     * Deleta RECEITAS pelo ID
     * @param int $id
     * @return void
     */
    public function deletar(int $id): void
    {
//        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (is_int($id)) {
            $receita = (new ReceitaModelo())->buscaPorId($id);
            if (!$receita) {
                $this->mensagem->alerta('A Receita que você está tentando deletar não existe!')->flash();
                Helpers::redirecionar('admin/receitas/listar');
            } else {
                if ($receita->deletar()) {
                    $this->mensagem->sucesso('Receita deletada com sucesso!')->flash();
                    Helpers::redirecionar('admin/receitas/listar');
                } else {
                    $this->mensagem->erro($receita->erro())->flash();
                    Helpers::redirecionar('admin/receitas/listar');
                }
            }
        }
    }

}
