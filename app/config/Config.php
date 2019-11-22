<?php

namespace Config;

use Slim\Container;
use Slim\Views\PhpRenderer;

final class Config {

    /* 
    * Use essa função para configurar o comportamento do framework.
    * ex.: displayErrorDetails=>true indica ao framework que 
    * mostre os erros de execução. Em ambiente de produção defina 
    * a variável de ambiente DISPLAY_SLIM_ERRORS do arquivo env.php como 'false' para ocultar erros.
    */
    public static function getSlimConfig(): Container {
        $conf = [
            "settings" => [
                "displayErrorDetails" => getenv("DISPLAY_SLIM_ERRORS")
            ]
        ];
        $container = new Container($conf);

        Config::custom404($container);
        Config::setRenderer($container);

        return $container;
    }

    /**
     * Personaliza a página de erro 404.
     */
    private static function custom404(Container $container) {
        $container['notFoundHandler'] = function($container) {
            return function ($req, $res) use ($container) {
                return $res->withStatus(404)
                    ->withJson(["resposta"=>"recurso não encontrado"]);
            };
        };
    }

    /**
     * Adiciona um renderizador de páginas a partir de um diretório.
     * todo endereço iniciado por ponto-barra (./) indica que a navegação 
     * será a partir da raiz do sistema.
     */
    private static function setRenderer(Container $container) {
        $container['renderer'] = new PhpRenderer("./app/views");
    }
}