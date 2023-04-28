<?php

namespace sistema\Modelo;

use sistema\Nucleo\Modelo;

/**
 * Classe CompraModelo
 *
 * @author Fabiano Faria
 */
class CompraModelo extends Modelo
{

    public function __construct()
    {
        parent::__construct('tbl_materia_prima');
    }

    /**
     * Busca o FORNECEDOR pelo ID
     * @return FornecedorModelo|null
     */
    public function fornecedor(): ?FornecedorModelo
    {
        if ($this->fornecedor_id) {
            return (new FornecedorModelo())->buscaPorId($this->fornecedor_id);
        }
        return null;
    }

    /**
     * Busca COMPRAS pelo ID
     * @return CompraModelo|null
     */
    public function consultar(): ?CompraModelo
    {
        if ($this->id_mp) {
            return (new CompraModelo())->buscaPorId($this->id_mp);
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
     * Salva o post com slug
     * @return bool
     */
    public function salvar(): bool
    {
        $this->slug();
        return parent::salvar();
    }

}
