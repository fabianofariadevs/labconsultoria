<?php

namespace sistema\Modelo;

use sistema\Nucleo\Modelo;
use sistema\Nucleo\Sessao;
/**
 * Classe UsuárioModelo
 *
 * @author Fabiano Faria
 */
class UsuarioModelo extends Modelo
{
    public function __construct()
    {
        parent::__construct('tbl_usuario');
    }
    
    public function buscaPorEmail(string $email): ?UsuarioModelo
    {
        $busca = $this->busca("email = :e","e={$email}");
        return $busca->resultado();
    }
    
    public function login(array $dados, int $level = 1)
    {
        $tbl_usuario = (new UsuarioModelo())->buscaPorEmail($dados['email']);
        
        if(!$tbl_usuario){
            $this->mensagem->erro("Os dados informados para o login estão incorretos!")->flash();
            return false;
        }
        
        if($dados['senha'] != $tbl_usuario->senha){
            $this->mensagem->alerta("Os dados informados para o login estão incorretos!")->flash();
            return false;
        }
        
        if($tbl_usuario->status != 1){
            $this->mensagem->alerta("Para fazer login, primeiro ative sua conta!")->flash();
            return false;
        }
        
        if($tbl_usuario->level < $level){
            $this->mensagem->erro("Você não tem permissão para acessar essa área!")->flash();
            return false;
        }
        
        $tbl_usuario->ultimo_login = date('Y-m-d H:i:s');
        $tbl_usuario->salvar();
        
        (new Sessao())->criar('usuarioId', $tbl_usuario->id);
        
        $this->mensagem->sucesso("{$tbl_usuario->nome}, seja bem vindo ao painel de controle")->flash();
        return true;
    }
}



//class UsuarioModelo ###### mudei na aula 107
//{
//    public function busca(): array
//  {
//        $query = "SELECT * FROM tbl_usuario "; 
//        $stmt = Conexao::getInstancia()->query($query);
//        $resultado = $stmt->fetchAll();
//        return $resultado;        
//    }
//    //var_dump($resultado);
//    
//    public function buscaPorId(int $id): bool|object
//    {
//        $query = "SELECT * FROM 'tbl_usuario' WHERE 'id_tbl_usuario' - 1 //ORDER BY id DESC"; 
//        $stmt = Conexao::getInstancia()->query($query);
//        $resultado = $stmt->fetch();
//
//        return $resultado; 
//    }
//      /
//}
