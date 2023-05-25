<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\PdvModelo;
use sistema\Modelo\ClienteModelo;
use sistema\Nucleo\Helpers;

/* Classe PDVs
 *
 * @author Fabiano Faria
 */

class AdminPdv extends AdminControlador
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
            1 => 'nome_loja',
            2 => 'id_cliente_fabrica',
            3 => 'responsavel_loja',
            4 => 'endereco_loja',
            5 => 'bairro_loja',
            6 => 'cidade_loja',
            7 => 'uf_loja',
            8 => 'telefone',
            9 => 'status',
        ];

        $ordem = " " . $colunas[$datatable['order'][0]['column']] . " ";
        $ordem .= " " . $datatable['order'][0]['dir'] . " ";

        $pdvs = new PdvModelo();

        if (empty($busca)) {
            $pdvs->busca()->ordem($ordem)->limite($limite)->offset($offset);
            $total = (new PdvModelo())->busca(null, 'COUNT(id)', 'id')->total();
        } else {
            $pdvs->busca("id LIKE '%{$busca}%' OR nome_loja LIKE '%{$busca}%' ")->limite($limite)->offset($offset);
            $total = $pdvs->total();
        }

        $dados = [];

        if ($pdvs->resultado(true)) {
            foreach ($pdvs->resultado(true) as $pdv) {
                $dados[] = [
                    $pdv->id,
                    $pdv->nome_loja,
                    $pdv->cliente()->nome_cliente ?? '-----',
                    $pdv->responsavel_loja,
                    $pdv->endereco_loja,
                    $pdv->bairro_loja,
                    $pdv->cidade_loja,
                    $pdv->uf_loja,
                    $pdv->telefone,
                    $pdv->status,
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
     * Lista PDVs
     * @return void
     */
    public function listar(): void
    {
        $pdvs = new PdvModelo();

        echo $this->template->renderizar('pdvs/listar.html', [
            'total' => [
                'pdvs' => $pdvs->busca(null, 'COUNT(id)', 'id')->total(),
                'pdvsAtivo' => $pdvs->busca('status = :s', 's=1 COUNT(status))', 'status')->total(),
                'pdvsInativo' => $pdvs->busca('status = :s', 's=0 COUNT(status)', 'status')->total(),
            ]
        ]);
    }

    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            if ($this->validarDados($dados)) {
                $pdvs = new PdvModelo();

                $pdvs->usuario_id = $this->usuario->id;
                $pdvs->slug = Helpers::slug($dados['nome_loja']);
                $pdvs->cod_pdv = $dados['cod_pdv'];
                $pdvs->id_cliente_fabrica = $dados['id_cliente_fabrica'];
                $pdvs->cnpj_loja = $dados['cnpj_loja'];
                $pdvs->nome_loja = $dados['nome_loja'];
                $pdvs->responsavel_loja = $dados['responsavel_loja'];
                $pdvs->endereco_loja = $dados['endereco_loja'];
                $pdvs->bairro_loja = $dados['bairro_loja'];
                $pdvs->cidade_loja = $dados['cidade_loja'];
                $pdvs->uf_loja = $dados['uf_loja'];
                $pdvs->telefone = $dados['telefone'];
                $pdvs->status = $dados['status'];

                if ($pdvs->salvar()) {
                    $this->mensagem->sucesso('PDV cadastrado com sucesso')->flash();
                    Helpers::redirecionar('admin/pdvs/listar');
                } else {
                    $this->mensagem->erro($pdvs->erro())->flash();
                    Helpers::redirecionar('admin/pdvs/listar');
                }
            }
        }
        echo $this->template->renderizar('pdvs/formulario.html', [
            ///***ver qual classe cliente????  
            'pdv' => $dados,
            'clientes' => (new ClienteModelo())->busca('status = 1')->resultado(true)
        ]);
    }

    public function validarDados(array $dados): bool
    {

        if (empty($dados['nome_loja'])) {
            $this->mensagem->alerta('Escreva um nome para o PDV!')->flash();
            return false;
        }
        if (empty($dados['endereco_loja'])) {
            $this->mensagem->alerta('Escreva um endereço para o PDV!')->flash();
            return false;
        }
        if (empty($dados['bairro_loja'])) {
            $this->mensagem->alerta('Escreva um bairro para o PDV!')->flash();
            return false;
        }
        return true;
    }

    public function editar(int $id): void
    {
        $pdvs = (new PdvModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            if ($this->validarDados($dados)) {
                $pdvs = (new PdvModelo())->buscaPorId($id);

                $pdvs->usuario_id = $this->usuario->id;
                $pdvs->slug = Helpers::slug($dados['nome_loja']);
                $pdvs->cod_pdv = $dados['cod_pdv'];
                $pdvs->id_cliente_fabrica = $dados['id_cliente_fabrica'];
                $pdvs->cnpj_loja = $dados['cnpj_loja'];
                $pdvs->nome_loja = $dados['nome_loja'];
                $pdvs->responsavel_loja = $dados['responsavel_loja'];
                $pdvs->endereco_loja = $dados['endereco_loja'];
                $pdvs->bairro_loja = $dados['bairro_loja'];
                $pdvs->cidade_loja = $dados['cidade_loja'];
                $pdvs->uf_loja = $dados['uf_loja'];
                $pdvs->telefone = $dados['telefone'];
                $pdvs->status = $dados['status'];

                if ($pdvs->salvar()) {
                    $this->mensagem->sucesso('PDV atualizado com sucesso')->flash();
                    Helpers::redirecionar('admin/pdvs/listar');
                } else {
                    $this->mensagem->erro($pdvs->erro())->flash();
                    Helpers::redirecionar('admin/pdvs/listar');
                }
            }
        }

        echo $this->template->renderizar('pdvs/formulario.html', [
            ////**VER AQUI TAMBEM           
            'pdv' => $pdvs,
            'clientes' => (new ClienteModelo())->busca('status = 1')->resultado(true)
        ]);
    }

    public function deletar(int $id): void
    {
//        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (is_int($id)) {
            $pdvs = (new PdvModelo())->buscaPorId($id);
            if (!$pdvs) {
                $this->mensagem->alerta('O PDV que você está tentando deletar não existe!')->flash();
                Helpers::redirecionar('admin/pdvs/listar');
            } else {
                if ($pdvs->deletar()) {
                    $this->mensagem->sucesso('PDV deletado com sucesso!')->flash();
                    Helpers::redirecionar('admin/pdvs/listar');
                } else {
                    $this->mensagem->erro($pdvs->erro())->flash();
                    Helpers::redirecionar('admin/pdvs/listar');
                }
            }
        }
    }

}
