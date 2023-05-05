<?php

namespace sistema\Modelo;

use sistema\Nucleo\Modelo;

/**
 * Classe FornecedorModelo
 *
 * @author Fabiano Faria
 */
class FornecedorModelo extends Modelo
{

    public function __construct()
    {
        parent::__construct('tbl_fornecedor');
    }

    /**
     * Busca a fornecedor pelo ID
     * @return FornecedorModelo|null
     */
    public function fornecedor(): ?FornecedorModelo
    {
        if ($this->id_fornecedor) {
            return (new FornecedorModelo())->buscaPorId($this->id_fornecedor);
        }
        return null;
    }

    /**
     * Busca o usuário pelo ID
     * @return UsuarioModelo|null
     */
    public function usuario(): ?UsuarioModelo
    {
        if ($this->usuario_id) {
            return (new UsuarioModelo())->buscaPorId($this->usuario_id);
        }
        return null;
    }

    /**
     * Salva o fornecedor com slug
     * @return bool
     */
    public function salvar(): bool
    {
        $this->slug();
        return parent::salvar();
    }

}
