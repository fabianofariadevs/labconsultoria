<?php

namespace sistema\Modelo;

use sistema\Nucleo\Conexao;

/**
 * Classe Usuários Modelo
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
        $query = "SELECT * FROM 'tbl_usuario' WHERE 'id_tbl_usuario' = {$id} "; 
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetch();

        return $resultado; 
    }
    
    public function posts(int $id): array
    {
        $query = "SELECT * FROM 'tbl_usuario' WHERE 'id_tbl_usuario' = {$id} AND status = 1 ORDER BY id DESC "; 
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();

        return $resultado;        
    }
    
   
}
