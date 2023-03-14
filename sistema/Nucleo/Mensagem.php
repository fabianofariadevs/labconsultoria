<?php

namespace sistema\Nucleo;

//classe mensagem, responsável por exibr as mensagens do sistema.
class Mensagem
{
    private $texto;
    public $css;
    public function __toString()
    {
        return $this->renderizar();
    }

    //método responsável pelas mensagens de sucesso
    //@param string $mensagem
    //@return Mensagem
    public function sucesso(string $mensagem): Mensagem
    {
        $this->css = 'alert alert-success';
        $this->texto = $this->filtrar($mensagem);
        return $this;
    }
    /* Método responsável pelas mensagens de erro
    * @param string $mensagem
    * @return Mensagem
    */
    public function erro(string $mensagem): Mensagem
    {
        $this->css = 'alert alert-danger';
        $this->texto = $this->filtrar($mensagem);
        return $this;
    }
     /* Método responsável pelas mensagens de alerta
     * @param string $mensagem
     * @return Mensagem
     */
    public function alerta(string $mensagem): Mensagem
    {
        $this->css = 'alert alert-warning';
        $this->texto = $this->filtrar($mensagem);
        return $this;
    }
     /* Método responsável pelas mensagens de informações
     * @param string $mensagem
     * @return Mensagem
     */
    public function informa(string $mensagem): Mensagem
    {
        $this->css = 'alert alert-primary';
        $this->texto = $this->filtrar($mensagem);
        return $this;
    }
    /*metodo responsável pela renderização das mensagens aula42
    *@return string */
    public function renderizar(): string
    {
        return "<div class='{$this->css}'>{$this->texto}</div>";
    }
   //metodo responsável por filtrar as mensagens 
   //@param string $mensagem
    //@return string
    public function filtrar(string $mensagem):string
    {
        return filter_var($mensagem, FILTER_SANITIZE_SPECIAL_CHARS);
    }
    /**
     * Cria a sessão das mensagens flash
     * @return void
     */
    //public function flash(): void
    //{
      //  (new Sessao())->criar('flash', $this);
    //}

    
}