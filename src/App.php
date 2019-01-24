<?php
namespace AdminTwig;

use AdminTwig\Router\Router;


class App
{

    public $viewpath;
    public $rootpath;
    private $twig = null;
    private $router = null;
    private static $instance;


    /**
     * get the instance of the application
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self(VIEWPATH, ROOT);
        }
        return self::$instance;
    }


    /**
     * set up view path
     *
     * @param string $viewpath
     * @param string $rootpath
     */
    public function __construct(string $viewpath = VIEWPATH, string $rootpath = ROOT)
    {
        $this->viewpath = $viewpath;
        $this->rootpath = $rootpath;
    }


    /**
     * get the router
     *
     * @return Router
     */
    public function getRouter(): Router
    {
        if (is_null($this->router)) {
            $this->router = new Router();
            (require  ROOT . "/src/routes.php")($this->router, $this->getRender());
            return $this->router;
        }
        return $this->router;
    }


    /**
     * get the renderer
     *
     * @return \Twig_Environment
     */
    public function getRender(): \Twig_Environment
    {
        if (is_null($this->twig)) {
            $extensions = require 'extensions.php';
            $loader = new \Twig_Loader_Filesystem($this->viewpath, $this->rootpath);
            $twig = new \Twig_Environment($loader, [
                'debug' => true
            ]);

            $twig->addExtension(new \Twig_Extension_Debug());
            if (!empty($extensions)) {
                foreach($extensions as $extension) {
                    $twig->addExtension(new $extension());
                }
            }

            $this->twig = $twig;
            return $this->twig;
        }
        return $this->twig;
    }
}
