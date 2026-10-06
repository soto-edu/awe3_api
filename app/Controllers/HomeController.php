<?php

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

class HomeController {

    public function displayHome(Request $request, Response $response, $args) {
        $view = new PhpRenderer(__DIR__ . '/../View');
        $data = [
            'title' => 'Version 3 API',
            'description' => 'API avec Swagger',
        ];
        return $view->render($response, 'home.php', $data);
    }

    public function displayPage1(Request $request, Response $response, $args) {
        $view = new PhpRenderer(__DIR__ . '/../View');
        $data = [
            'title' => 'Page 1',
            'description' => 'Page 1',
        ];
        return $view->render($response, 'page1.php', $data);
    }
}