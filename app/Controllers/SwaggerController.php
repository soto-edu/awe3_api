<?php

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Attributes as OA;
use OpenApi\Generator;
use Slim\Views\PhpRenderer;

#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]

class SwaggerController {

    // #[OA\Get(path: "/swagger.json", tags: ["swagger"], summary: "Get Swagger documentation JSON")]
    public function displaySwaggerJson(Request $request, Response $response, $args) {
        // Créer une instance de Generator et scanner les fichiers pour générer la documentation OpenAPI
        $generator = new Generator();
        
        // Scanner le dossier app qui contient tous les contrôleurs
        $appDir = __DIR__ . '/../';
        $openapi = $generator->generate([$appDir], null, false); // Désactiver la validation pour éviter les erreurs
        
        if ($openapi === null) {
            $response->getBody()->write(json_encode([
                'error' => 'Failed to generate OpenAPI documentation',
                'message' => 'No OpenAPI specification was generated. Check that your controllers have proper OpenAPI attributes.'
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
        
        $response->getBody()->write($openapi->toJson());
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function displaySwaggerUI(Request $request, Response $response, $args) {
        $view = new PhpRenderer(__DIR__ . '/../View');
        return $view->render($response, 'swagger.php');
    }
}