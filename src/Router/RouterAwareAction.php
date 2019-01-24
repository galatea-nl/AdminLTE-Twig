<?php
namespace AdminTwig\Router;

use AdminTwig\App;



/**
 * les actions liee aux routing
 * Trait RouterAwareAction
 * @package NgFrame\Framework\Router
 */
trait RouterAwareAction
{

    /**
     * recupere une instance du router et on definit les routes.
     * @return Router
     */
    private function getRouter()
    {
        return App::getInstance()->getRouter();
    }


    /**
     * genere une erreur 404
     */
    public function redirect404()
    {
        http_response_code(404);
        echo "<h1>Not Found with redirect 404</h1>";
        exit();
    }


    /**
     * redirige vers une url, si l'url est vide on redirige vers la page precedente
     * @param string $url
     * @param int|string $status
     */
    public function redirect(string $url = '', int $status = 200)
    {
        if (empty($url)) {
            if (isset($_SERVER['HTTP_REFERER'])) {
                http_response_code($status);
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit();
            } else {
                http_response_code(301);
                header("Location: /");
                exit();
            }
        } else {
            $url = "/{$url}";
            http_response_code($status);
            header("Location: {$url}");
            exit();
        }
    }


    /**
     * genere une route pour une route donnee et redirige vers celle-ci
     * @param string $route
     * @param array $param
     * @param int $status
     * @return mixed
     */
    public function route(string $route, array $param = [], int $status = 200)
    {
        $url = $this->getRouter()->url($route, $param);
        $this->redirect($url, $status);
    }
}
