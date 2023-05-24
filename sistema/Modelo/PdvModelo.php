<?php

namespace sistema\Modelo;

use sistema\Nucleo\Modelo;

/**
 * Classe PdvModelo
 *
 * @author Fabiano Faria
 */
class PdvModelo extends Modelo
{

    public function __construct()
    {
        parent::__construct('tbl_loja_pdv');
    }

    /**
     * Busca MixProduto pelo ID
     * @return MixProdutosModelo|null
     */
    public function pdv(): ?PdvModelo
    {
        if ($this->id) {
            return (new PdvModelo())->buscaPorId($this->id);
        }
        return null;
    }

    /**
     * Busca o CLIENTE/FABRICA pelo ID
     * @return ClienteModelo|null
     */
    public function cliente(): ?ClienteModelo
    {
        if ($this->id_cliente_fabrica) {
            return (new ClienteModelo())->buscaPorId($this->id_cliente_fabrica);
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
