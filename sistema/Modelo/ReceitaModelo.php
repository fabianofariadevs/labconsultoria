<?php

namespace sistema\Modelo;

use sistema\Nucleo\Modelo;

/**
 * Classe ReceitaModelo
 *
 * @author Fabiano Faria
 */
class ReceitaModelo extends Modelo
{

    public function __construct()
    {
        parent::__construct('tbl_receita');
    }

    /**
     * Busca a Receita pelo ID
     * @return ReceitaModelo|null
     */
    public function receita(): ?ReceitaModelo
    {
        if ($this->id) {
            return (new ReceitaModelo())->buscaPorId($this->id);
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
     * Busca o CLIENTE/FABRICA pelo ID
     * @return ClienteModelo|null
     */
    public function cliente(): ?ClienteModelo
    {
        if ($this->id_tbl_cliente_fabrica) {
            return (new ClienteModelo())->buscaPorId($this->id_tbl_cliente_fabrica);
        }
        return null;
    }

    /**
     * Salva o Receita com slug
     * @return bool
     */
    public function salvar(): bool
    {
        $this->slug();
        return parent::salvar();
    }

}
