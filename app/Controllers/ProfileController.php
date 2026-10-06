<?php

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response; 

require_once __DIR__ . '/../Model/profile.php';

class ProfileController {
    public function getAllProfiles(Request $request, Response $response, $args) {
        $profileModel = new ProfileModel();
        $profiles = $profileModel->getAllProfiles();
        $payload = json_encode($profiles);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

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

    public function updateProfile(Request $request, Response $response, $args) {
        $id = $args['id'];
        $profileModel = new ProfileModel();
        $profile = $profileModel->getProfileById($id);
        if (!$profile) {
            $payload = json_encode(['error' => 'Profile not found']);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }else{
            $input = $request->getParsedBody();
            $profile = $profileModel->updateProfile($id, $input);            
            $payload = json_encode($profile);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            
        }
    }
}