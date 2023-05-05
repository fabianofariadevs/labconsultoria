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
        if ($this->id_tbl_produto_mix) {
            return (new MixProdutosModelo())->buscaPorId($this->id_tbl_produto_mix);
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

      public function salvar(): bool
      {
      $this->slug();
      return parent::salvar();
      }
     */
}
