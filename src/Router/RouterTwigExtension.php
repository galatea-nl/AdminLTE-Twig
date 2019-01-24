<?php
namespace AdminTwig\Router;


/**
 * les methodes du routing pour les vues.
 * Class RouterTwigExtension
 * @package AdminTwig\Router
 */
class RouterTwigExtension extends \Twig_Extension
{


    use RouterAwareAction;


    /**
     * @inheritdoc
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_Function('path', [$this, 'pathFor']),
            new \Twig_Function('asset', [$this, 'asset']),
        ];
    }


    /**
     * genere une url, pour le nom d'une route donnee.
     * @param string $path
     * @param array $param
     * @return mixed
     */
    public function pathFor(string $path, array $param = [])
    {
        $router = $this->getRouter();
        return "/{$router->url($path, $param)}";
    }


    /**
     * renvoi le fichier asset par rapport au nom du site
     * @param string $resource
     * @param string $cdn
     * @return string
     */
    public function asset(string $resource, string $cdn = '')
    {
        if (empty($cdn)) {
            $resource = "/dist/$resource";
        } elseif (!empty($cdn)) {
            $resource = $cdn;
        }

        return $resource;
    }
}
