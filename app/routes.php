<?php
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

require_once __DIR__ . '/Controllers/HomeController.php';
require_once __DIR__ . '/Controllers/ProfileController.php';


return function (App $app) {
    $app->get('/', [HomeController::class, 'displayHome']);
    $app->get('/page1', [HomeController::class, 'displayPage1']);
    $app->group('/api', function (Group $group) {
        $group->get('/profiles', [ProfileController::class, 'getAllProfiles']);
        $group->get('/profiles/{id}', [ProfileController::class, 'getProfileById']);
        $group->post('/profiles', [ProfileController::class, 'createProfile']);
        $group->put('/profiles/{id}', [ProfileController::class, 'updateProfile']);
    });
};