<?php

namespace sistema\Modelo;

use sistema\Nucleo\Modelo;

/**
 * Classe Mix_ProdutosModelo
 *
 * @author Fabiano Faria
 */
class MixProdutosModelo extends Modelo
{

    public function __construct()
    {
        parent::__construct('tbl_produto_mix');
    }

    /**
     * Busca MixProduto pelo ID
     * @return MixProdutosModelo|null
     */
    public function mixproduto(): ?MixProdutosModelo
    {
        if ($this->id) {
            return (new MixProdutosModelo())->buscaPorId($this->id);
        }
        return null;
    }
/**
     * Busca o CLIENTE/FABRICA pelo ID
     * @return ClienteModelo|null
     */
    public function cliente(): ?ClienteModelo
    {
        if ($this->id_cli_fabrica) {
            return (new ClienteModelo())->buscaPorId($this->id_cli_fabrica);
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
     * Salva com slug
     * @return bool
     */
    public function salvar(): bool
    {
        $this->slug();
        return parent::salvar();
    }

}
