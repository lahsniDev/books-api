<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/index' => [[['_route' => 'index', '_controller' => 'App\\Controller\\HomeController::index'], null, null, null, false, false, null]],
        '/api/books' => [
            [['_route' => 'books_index', '_controller' => 'App\\Controller\\api\\BookController::list'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'books_create', '_controller' => 'App\\Controller\\api\\BookController::create'], null, ['POST' => 0], null, true, false, null],
        ],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/api/books/([^/]++)(?'
                    .'|(*:64)'
                .')'
            .')/?$}sD',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        64 => [
            [['_route' => 'books_show', '_controller' => 'App\\Controller\\api\\BookController::show'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'books_delete', '_controller' => 'App\\Controller\\api\\BookController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
            [['_route' => 'books_update', '_controller' => 'App\\Controller\\api\\BookController::update'], ['id'], ['PUT' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];