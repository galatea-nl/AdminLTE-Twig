<?php

/**
 * routing and rendering
 */
return function ($router, $twig) {

    dashboard_routes : {
        $router->get('/', function () use ($twig) {
            echo $twig->render('index.html.twig');
            exit();
        });

        $router->get('index', function () use ($twig) {
            echo $twig->render('index.html.twig');
            exit();
        }, 'index');
    
        $router->get('index2', function () use ($twig) {
            echo $twig->render('index2.html.twig');
            exit();
        }, 'index');
    
        $router->get('index3', function () use ($twig) {
            echo $twig->render('index3.html.twig');
            exit();
        }, 'index');
    }


    widgets_routes : {

    }


    charts_routes : {

    }


    ui_elements_routes : {

    }


    forms_routes : {

    }


    tables_routes : {

    }


    mailbox_routes : {

    }


    pages_routes : {

    }

    
    extras_routes : {

    }
};
