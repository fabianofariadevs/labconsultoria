<?php

namespace sistema\Modelo;

use sistema\Nucleo\Modelo;
 /**
 * Classe clienteModelo
 *
 * @author Fabiano Faria
 */
class ClienteModelo extends Modelo
{
 public function __construct()
    {
        parent::__construct('tbl_cliente_fabrica');
    }

    /**
     * Busca a CLIENTE/FABRICA pelo ID
     * @return CategoriaModelo|null
     */
    public function cliente(): ?ClienteModelo
    {
        if ($this->id) {
            return (new ClienteModelo())->buscaPorId($this->id);
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


