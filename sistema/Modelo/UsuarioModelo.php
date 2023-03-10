<?php

namespace sistema\Modelo;

use sistema\Nucleo\Conexao;
/**
 * Classe UsuárioModelo
 *
 * @author Fabiano Faria
 */
class UsuarioModelo
{
    public function busca(): array
    {
        $query = "SELECT * FROM tbl_usuario "; 
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();
        return $resultado;        
    }
    //var_dump($resultado);
    
    public function buscaPorId(int $id): bool|object
    {
        $query = "SELECT * FROM 'tbl_usuario' WHERE 'id_tbl_usuario' - 1 ORDER BY id DESC"; 
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetch();

        return $resultado; 
    }
      
}
