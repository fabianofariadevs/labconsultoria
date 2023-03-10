<?php

namespace sistema\Modelo;

use sistema\Nucleo\Conexao;

/**
 * Classe ReceitaModelo
 *
 * @author Fabiano Faria
 */
class ReceitaModelo
{
    public function busca(): array
    {
        $query = "SELECT * FROM posts "; 
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();
        return $resultado;        
    }
    //var_dump($resultado);
    
    public function buscaPorId(int $id): bool|object
    {
        $query = "SELECT * FROM 'posts' WHERE 'id_tbl_Receita' = {$id} "; 
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetch();

        return $resultado; 
    }
    
    public function posts(int $id): array
    {
        $query = "SELECT * FROM 'posts' WHERE 'id_tbl_Receita' = {$id} AND status = 1 ORDER BY id DESC "; 
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();

        return $resultado;        
    }
    
   
}
