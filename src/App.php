<?php
namespace AdminTwig;


class Application
{

    public $viewpath = "../../pages";
    public $rootpath = "../../";


    public function getRender(): \Twig_Environment
    {
        $extensions = require 'extensions.php';
        $loader = new \Twig_Loader_Filesystem($this->viewpath, $this->rootpath);
        $twig = new \Twig_Environment($loader, [
            'debug' => true
        ]);

        $twig->addExtension(new \Twig_Extension_Debug());

        // loads all twig extensions
        if (!empty($extensions)) {
            foreach($extensions as $extension) {
                $twig->addExtension(new $extension());
            }
        }
    }


    /**
     * run the app
     *
     * @return void
     */
    public function run()
    {

    }
}
