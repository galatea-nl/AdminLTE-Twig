<?php

/**
 * routing and rendering
 */
return function ($router, $twig) {
    $render = function($view) {
        global $twig;
        echo $twig->render($view);
        exit();
    };


    $router->get('index', $render('index.html.twig'), 'index');
    $router->get('index2', $render('index2.html.twig'), 'index2');
    $router->get('index3', $render('index3.html.twig'), 'index3');
};
