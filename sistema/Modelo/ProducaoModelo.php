<?php

namespace sistema\Modelo;

use sistema\Nucleo\Modelo;

/**
 * Classe PLANEJ__Producao
 *
 * @author Fabiano Faria
 */
class ProducaoModelo extends Modelo
{

    public function __construct()
    {
        parent::__construct('tbl_pedido_producao');
    }

    /**
     * Busca PEDIDO PRODUÇÃO pelo ID
     * @return ProducaoModelo|null
     */
    public function producao(): ?ProducaoModelo
    {
        if ($this->id) {
            return (new ProducaoModelo())->buscaPorId($this->id);
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
     * @return UsuarioModelo|null
     */
    public function fabrica(): ?ClienteModelo
    {
        if ($this->id) {
            return (new ClienteModelo())->buscaPorId($this->id);
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
