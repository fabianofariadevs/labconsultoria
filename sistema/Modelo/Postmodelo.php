<?php

namespace sistema\Modelo;

use sistema\Nucleo\Conexao;
/**
 * Classe PostModelo
 *
 * @author Fabiano Faria
 */
class Postmodelo 
{
    public function busca(): array
    {
        //aqui escolhemos quais as colunas ou id selecionar
        //ex: SELECT * FROM table WHERE id = 1 AND id = 2;
        //COM LIMIT, OFFSET, OU OPERADORES
        $query = "SELECT * FROM posts ";
        $stmt = Conexao::getInstancia()->query($query);        
        $resultado = $stmt->fetchAll();
        //var_dump($resultado);
        return $resultado;

    }
    
    public function buscaporId(int$id): bool | object
    {
        //aqui buscar por ID
        $query = "SELECT * FROM 'posts' WHERE status - 1 ORDER BY id DESC";
        $stmt = Conexao::getInstancia()->query($query);        
        $resultado = $stmt->fetch();
        return $resultado;
    }
/*    public function buscaPorId(int $id): bool | object
    {
        $query = "SELECT * FROM posts WHERE id - {$id}";
        $stmt = Conexao::getInstancia()->query($query);        
        $resultado = $stmt->fetch();
        return $resultado;
    }
 */
    public function pesquisa(string $busca): array
    {
        $query = "SELECT * FROM 'tbl_receita' WHERE status = 1 AND titulo LIKE '%{$busca}%' ";
        $stmt = Conexao::getInstancia()->query($query);        
        $resultado = $stmt->fetchAll();
        return $resultado;
    }
}