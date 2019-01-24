<?php
namespace AdminTwig\Router;


class Router
{
    /**
     * l'url entre par le user
     * @var string
     */
    private $url;

    /**
     * les routes enregister
     * @var Route[]
     */
    private $routes = [];

    /**
     * les routes nommee enregister
     * @var array
     */
    private $namedRoute = [];


    /**
     * Router constructor
     */
    public function __construct()
    {
        $this->url = $_GET['url'] ?? $_SERVER['REQUEST_URI'] ?? '/';
    }


    /**
     * permet d'ajouter une url, registrer une route
     * @param string $path
     * @param mixed $controller
     * @param string $name
     * @param string $method
     * @return Route
     */
    private function add(string $path, $controller, string $name = null, string $method): Route
    {
        $route = new Route($path, $controller);
        $this->routes[$method][] = $route;

        if ($name) {
            $this->namedRoute[$name] = $route;
        }
        return $route;
    }


    /**
     * registration de route en GET et POST
     * @param string $path
     * @param callable|string $controller
     * @param string $name
     * @return Route
     */
    public function any(string $path, $controller, string $name = null): Route
    {
        $route = new Route($path, $controller);
        $this->routes['GET'][] = $route;
        $this->routes['POST'][] = $route;
        $this->routes['PUT'][] = $route;
        $this->routes['PATCH'][] = $route;
        $this->routes['DELETE'][] = $route;

        if ($name) {
            $this->namedRoute[$name] = $route;
        }
        return $route;
    }


    /**
     * registration url en GET
     * @param string $path
     * @param callable|string $controller
     * @param string $name
     * @return Route
     */
    public function get(string $path, $controller, string $name = null): Route
    {
        return $this->add($path, $controller, $name, "GET");
    }


    /**
     * registration url en PUT
     * ajout aussi en post pour pouvoir switcher, vu que le navigateur
     * n'envoie pas de request en PUT, PATCH, DELETE, etc...
     * @param string $path
     * @param callable|string $controller
     * @param string $name
     * @return Route
     */
    public function put(string $path, $controller, string $name = null): Route
    {
        $this->add($path, $controller, $name, 'POST');
        return $this->add($path, $controller, $name, "PUT");
    }


    /**
     * registration url en PATCH
     * ajout aussi en post pour pouvoir switcher, vu que le navigateur
     * n'envoie pas de request en PUT, PATCH, DELETE, etc...
     * @param string $path
     * @param callable|string $controller
     * @param string $name
     * @return Route
     */
    public function patch(string $path, $controller, string $name = null): Route
    {
        $this->add($path, $controller, $name, 'POST');
        return $this->add($path, $controller, $name, "PATCH");
    }



    /**
     * registration url en DELETE
     * ajout aussi en post pour pouvoir switcher, vu que le navigateur
     * n'envoie pas de request en PUT, PATCH, DELETE, etc...
     * @param string $path
     * @param callable|string $controller
     * @param string $name
     * @return Route
     */
    public function delete(string $path, $controller, string $name = null): Route
    {
        $this->add($path, $controller, $name, 'POST');
        return $this->add($path, $controller, $name, "DELETE");
    }


    /**
     * registration en POST
     * @param string $path
     * @param callable|string $controller
     * @param string $name
     * @return Route
     */
    public function post(string $path, $controller, string $name = null): Route
    {
        return $this->add($path, $controller, $name, "POST");
    }


    /**
     * lance le router apartir du nom d'une route
     * @param string $name
     * @param array $params
     * @return mixed
     * @throws RouterException
     */
    public function url(string $name, array $params = [])
    {
        if (!isset($this->namedRoute[$name])) {
            throw new RouterException(sprintf("No matched routes for %s", $name), 404);
        }
        return $this->namedRoute[$name]->getUrl($params);
    }


    /**
     * lancement du routing
     * @return bool
     * @throws RouterException
     */
    public function run()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            if (isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
                foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
                    if ($route->match($this->url)) {
                        return $route;
                    }
                }
            } else {
                throw new RouterException("undefined request method", 500);
            }

            return null;
        }

        throw new RouterException("undefined request method", 500);
    }
}
