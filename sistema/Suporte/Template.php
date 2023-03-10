<?php

namespace sistema\Suporte;

use sistema\Nucleo\helpers;
use Twig\Lexer;

class Template
//atributo twig
{ 
    private \Twig\Environment $twig;
//vai receber um diretorio
    public function __construct(string $diretorio)
    {
        $loader = new \Twig\Loader\FilesystemLoader($diretorio);
        $this->twig = new \Twig\Environment($loader);

       $lexer = new Lexer($this->twig, array($this->helpers()));
       $this->twig->setLexer($lexer);
    }
     /* Metodo responsavel por realizar a renderização das views
     * @param string $view
     * @param array $dados
     * @return string
     */
    public function renderizar(string $view, array $dados)
    {
        try {
            return $this->twig->render($view, $dados);
        } catch (\twig\Error\LoaderError | \Twig\Error\SyntaxError $ex) {
            echo 'Erro:: ' . $ex->getMessage();
        }
    }
     /* Metodo responsavel por chamar funções da classe Helpers
     * @return void
    // aula 56 metodo helpers
     */
    private function helpers(): void
    {
        array(
            $this->twig->addFunction(
                    new \Twig\TwigFunction('url', function (string $url = null) {
                                return Helpers::url($url);
                            })
            ),
            $this->twig->addFunction(
                    new \Twig\TwigFunction('saudacao', function () {
                                return Helpers::saudacao();
                            })
            ),
            $this->twig->addFunction(
                    new \Twig\TwigFunction('resumirTexto', function (string $texto, int $limite) {
                                return Helpers::resumirTexto($texto, $limite);
                            })
            ),
        );
    }
}

