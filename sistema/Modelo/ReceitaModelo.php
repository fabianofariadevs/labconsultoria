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
        $query = "SELECT * FROM tbl_receita "; 
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();
        return $resultado;        
    }
    //var_dump($resultado);
    
    public function buscaPorId(int $id): bool|object
    {
        $query = "SELECT * FROM 'tbl_receita' WHERE 'id_tbl_Receita' = {$id} "; 
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetch();

        return $resultado; 
    }
    
    public function armazenar(array $dados):void 
    {
        $query = "INSERT INTO `tbl_receita` ('id_tbl_Receita' ,`nome_receita`, `descricao_receita`, `modo_preparo`, `qtde_prevista_receita`, `validade_receita`, `observacao_receita`) VALUES (:id_tbl_Receita, :nome_receita, :descricao_receita, :modo_preparo, :qtde_prevista_receita, :validade_receita, :observacao_receita);";
         $stmt = Conexao::getInstancia()->prepare($query);
         $stmt->execute($dados);
    }

    
       
}


       // $query = "INSERT INTO `tbl_receita` (`nome_receita`, `descricao_receita`, `modo_preparo`, `qtde_prevista_receita`, `validade_receita`, `observacao_receita`) VALUES (?, ?, ?, ?, ?, ?);";
      //   $stmt = Conexao::getInstancia()->prepare($query);
        // $stmt->execute([$dados[`nome_receita`],$dados[`descricao_receita`],$dados[`modo_preparo`],$dados[`qtde_prevista_receita`],$dados[`validade_receita`],$dados[`observacao_receita`]]);
    