<?php
/**
 * Exemple API RESTful.
 *
 * Pour tester rapidement :
 *   php -S localhost:8000
 * Puis appeler :
 *   http://localhost:8000/api/api.php/profiles
 */
require_once '../controlleur/ProfileController.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// Type de requête GET, POST, PUT, DELETE
$method = $_SERVER['REQUEST_METHOD']; 

// Extrait uniquement le chemin de l'URL
$fullPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Extrait uniquement ce qui se trouve après api.php/

if (preg_match('#/api\.php/(.+)$#', $fullPath, $matches)) {
    $path = $matches[1];  // Retourne "profiles" ou "profiles/123"
} 


// echo "Full Path: ".$fullPath;
// echo "<br>";
// echo "Method: ".$method;
// echo "<br>";
// echo "Path: ".$path;
// echo "<br><br>";

switch($method) {
    case 'GET':
        handleGet($path); 
        break;
    case 'POST':
        handlePost($path); 
        break;
    case 'PUT':
        handlePut($path); 
        break;
    case 'DELETE':
        handleDelete($path); 
        break;
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Méthode non autorisée']);
        break;
}

function handleGet($path) {
    // Divise le path en segments
    $segments = explode('/', trim($path, '/'));
    
    if (empty($segments[0]) || empty($path)) {
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found', 'status' => '404', 'path' => $path]);
        return;
    }
    
    $resource = $segments[0]; // "profiles"
    $id = $segments[1] ?? null; // "123" ou null
    
    switch ($resource) {
        case 'profiles':
            $profileController = new ProfileController();
            if ($id !== null) {
                // GET /api/api.php/profiles/123
                $profileController->getProfileById($id);
            } else {
                // GET /api/api.php/profiles
                $profileController->getAllProfiles();
            }
            break;
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint not found', 'status' => '404', 'path' => $path]);
            break;
    }
}

function handlePost($path) {
    $segments = explode('/', trim($path, '/'));
    $resource = $segments[0]; 
    $input = json_decode(file_get_contents('php://input'), true);


    switch ($resource) {
        case 'profiles':
            echo json_encode($input);
            $profileController = new ProfileController();
            $profileController->createProfile($input);
            break;
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint not found', 'status' => '404', 'path' => $path]);
            break;
    }
}

function handlePut($path) {
    $segments = explode('/', trim($path, '/'));
    $resource = $segments[0]; 
    $id = $segments[1];
    $input = json_decode(file_get_contents('php://input'), true);

    switch ($resource) {
        case 'profiles':
            $profileController = new ProfileController();
            $profileController->updateProfile($id, $input);
            break;
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint not found', 'status' => '404', 'path' => $path]);
            break;
    }
}

function handleDelete($path) {
}