<?php

namespace sistema\Modelo;

use sistema\Nucleo\Conexao;
 /**
 * Classe clienteModelo
 *
 * @author Fabiano Faria
 */
class ClienteModelo
{
    public function busca(): array
    {
        //aqui escolhemos quais as colunas ou id selecionar
        //ex: SELECT * FROM table WHERE id = 1 AND id = 2;
        //COM LIMIT, OFFSET, OU OPERADORES
        $query = "SELECT * FROM tbl_cliente_fabrica ";
        $stmt = Conexao::getInstancia()->query($query);        
        $resultado = $stmt->fetchAll();
        //var_dump($resultado);
        return $resultado;

    }
    
    public function buscaporId(int$id): bool | object
    {
        //aqui buscar por ID
        $query = "SELECT * FROM 'tbl_cliente_fabrica' WHERE id_tbl_cliente_fabrica - 1 ORDER BY id DESC";
        $stmt = Conexao::getInstancia()->query($query);        
        $resultado = $stmt->fetch();
        return $resultado;
    }
    
    public function armazenar(array $dados):void 
    {
        $query = "INSERT INTO `tbl_cliente_fabrica` (`nome_cliente`, `endereco_cliente`, `bairro_cli`, `cidade_cli`, `estado_cli`, `telefone_cli`, `email_cli`, `responsavel_empresa`, `whatsapp`, `cnpj_fabrica`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
         $stmt = Conexao::getInstancia()->query($query);
         $stmt->execute([$dados[`nome_cliente`],$dados[`endereco_cliente`],$dados[`bairro_cli`],$dados[`cidade_cli`],$dados[`estado_cli`],$dados[`telefone_cli`],$dados[`email_cli`],$dados[`responsavel_empresa`],$dados[`whatsapp`],$dados[`cnpj_fabrica`]]);
    }


}

