<?php

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response; 

require_once __DIR__ . '/../Model/profile.php';
use OpenApi\Attributes as OA;

class ProfileController {
    #[OA\Get(
        path: "/api/profiles",
        tags: ["profiles"],
        summary: "Get all profiles",
        responses: [
            new OA\Response(response: 200, description: "List of profiles", content: new OA\JsonContent(
                type: 'array',
                items: new OA\Items(
                    type: 'object',
                    properties: [
                        'id' => new OA\Property(property: 'id', type: 'integer', example: 1),
                        'first_name' => new OA\Property(property: 'first_name', type: 'string', example: 'John'),
                        'last_name' => new OA\Property(property: 'last_name', type: 'string', example: 'Doe'),
                        'email' => new OA\Property(property: 'email', type: 'string', example: 'john.doe@example.com'),
                        'bio' => new OA\Property(property: 'bio', type: 'string', example: 'Software developer')
                    ]
                )
            ))
        ]
    )]
    public function getAllProfiles(Request $request, Response $response, $args) {
        $profileModel = new ProfileModel();
        $profiles = $profileModel->getAllProfiles();
        $payload = json_encode($profiles);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    #[OA\Get(
        path: "/api/profiles/{id}",
        tags: ["profiles"],
        summary: "Get a profile by ID",
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Profile ID',
                schema: new OA\Schema(type: 'integer', example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Profile found",
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        'id' => new OA\Property(property: 'id', type: 'integer', example: 1),
                        'first_name' => new OA\Property(property: 'first_name', type: 'string', example: 'John'),
                        'last_name' => new OA\Property(property: 'last_name', type: 'string', example: 'Doe'),
                        'email' => new OA\Property(property: 'email', type: 'string', example: 'john.doe@example.com'),
                        'bio' => new OA\Property(property: 'bio', type: 'string', example: 'Software developer')
                    ]
                )
            ),
            new OA\Response(response: 404, description: "Profile not found")
        ]
    )]
    public function getProfileById(Request $request, Response $response, $args) {
        $id = $args['id'];

        $profileModel = new ProfileModel();
        $profile = $profileModel->getProfileById($id);
        if (!$profile) {
            $payload = json_encode(['error' => 'Profile not found']);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }else{    
            $payload = json_encode($profile);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
    }

    #[OA\Post(
        path: "/api/profiles",
        tags: ["profiles"],
        summary: "Create a new profile",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                type: 'object',
                required: ['first_name', 'last_name', 'email', 'bio'],
                properties: [
                    'first_name' => new OA\Property(property: 'first_name', type: 'string', example: 'John'),
                    'last_name' => new OA\Property(property: 'last_name', type: 'string', example: 'Doe'),
                    'email' => new OA\Property(property: 'email', type: 'string', format: 'email', example: 'john.doe@example.com'),
                    'bio' => new OA\Property(property: 'bio', type: 'string', example: 'Software developer')
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Profile created successfully",
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        'id' => new OA\Property(property: 'id', type: 'integer', example: 1),
                        'first_name' => new OA\Property(property: 'first_name', type: 'string', example: 'John'),
                        'last_name' => new OA\Property(property: 'last_name', type: 'string', example: 'Doe'),
                        'email' => new OA\Property(property: 'email', type: 'string', example: 'john.doe@example.com'),
                        'bio' => new OA\Property(property: 'bio', type: 'string', example: 'Software developer')
                    ]
                )
            ),
            new OA\Response(response: 400, description: "Bad request - validation error"),
            new OA\Response(response: 500, description: "Internal server error")
        ]
    )]
    public function createProfile(Request $request, Response $response, $args) {
        
        $body = $request->getBody()->getContents();
        $input = json_decode($body, true);
        $profileModel = new ProfileModel();
        
        if ( empty($input['first_name']) || empty($input['last_name']) || empty($input['email']) || empty($input['bio'])) {
            $payload = json_encode([
                'error' => 'Missing required fields',
                'body' => $input
            ]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);

        }else if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            $payload = json_encode(['error' => 'Invalid email format']);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);

        }else if ($profileModel->getProfileByEmail($input['email'])) {
            $payload = json_encode(['error' => 'Email already exists']);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);

        }else {
            $profile = $profileModel->createProfile($input);
            if ($profile) {
                $payload = json_encode($profile);
                $response->getBody()->write($payload);
                return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
            }else{
                $payload = json_encode(['error' => 'Failed to create profile']);
                $response->getBody()->write($payload);
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
            }
        }
    }

    #[OA\Put(
        path: "/api/profiles/{id}",
        tags: ["profiles"],
        summary: "Update a profile",
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Profile ID',
                schema: new OA\Schema(type: 'integer', example: 1)
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                type: 'object',
                properties: [
                    'first_name' => new OA\Property(property: 'first_name', type: 'string', example: 'John'),
                    'last_name' => new OA\Property(property: 'last_name', type: 'string', example: 'Doe'),
                    'email' => new OA\Property(property: 'email', type: 'string', format: 'email', example: 'john.doe@example.com'),
                    'bio' => new OA\Property(property: 'bio', type: 'string', example: 'Software developer')
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Profile updated successfully",
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        'id' => new OA\Property(property: 'id', type: 'integer', example: 1),
                        'first_name' => new OA\Property(property: 'first_name', type: 'string', example: 'John'),
                        'last_name' => new OA\Property(property: 'last_name', type: 'string', example: 'Doe'),
                        'email' => new OA\Property(property: 'email', type: 'string', example: 'john.doe@example.com'),
                        'bio' => new OA\Property(property: 'bio', type: 'string', example: 'Software developer')
                    ]
                )
            ),
            new OA\Response(response: 404, description: "Profile not found")
        ]
    )]
    public function updateProfile(Request $request, Response $response, $args) {
        $id = $args['id'];
        $profileModel = new ProfileModel();
        $profile = $profileModel->getProfileById($id);
        if (!$profile) {
            $payload = json_encode(['error' => 'Profile not found']);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }else{
            $body = $request->getBody()->getContents();
            $input = json_decode($body, true);
            $profile = $profileModel->updateProfile($id, $input);            
            $payload = json_encode($profile);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            
        }
    }
}