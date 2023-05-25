<?php

namespace sistema\Modelo;

use sistema\Nucleo\Modelo;
use sistema\Modelo\ClienteModelo;
use sistema\Modelo\PdvModelo;

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
     * Busca o CLIENTE/FABRICA pelo ID
     * @return UsuarioModelo|null
     */
    public function cliente(): ?ClienteModelo
    {
        if ($this->id_cliente_fabrica) {
            return (new ClienteModelo())->buscaPorId($this->id_cliente_fabrica);
        }
        return null;
    }
    
    /**
     * Busca o LOJA PDV pelo ID
     * @return pdvModelo|null
     */
    public function pdv(): ?PdvModelo
    {
        if ($this->id_loja_pdv ) {
            return (new PdvModelo())->buscaPorId($this->id_loja_pdv );
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
