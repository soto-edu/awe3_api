<?php

require_once '../model/profile.php';

class ProfileController {
    
    public function getAllProfiles() {
        $profiles = getAllProfiles();
        http_response_code(200);
        echo json_encode($profiles);
    }

    public function getProfileById($id) {
        $profile = getProfileById($id);
        if ($profile) {
            http_response_code(200);
            echo json_encode($profile);
        } else {
                http_response_code(404);
                echo json_encode(['error' => 'Profile not found', 'status' => '404', 'path' => $id]);
        }
    }

    public function createProfile($input) {
        if (empty($input['first_name']) || empty($input['last_name']) || empty($input['email']) || empty($input['bio'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields', 'status' => '400', 'path' => $input]);
            return;
        }else if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid email format', 'status' => '400', 'path' => $input]);
            return;
        }else if (getProfileByEmail($input['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Email already exists', 'status' => '400', 'path' => $input]);
            return;
        }
        else {
            $profile = createProfile($input);
            if ($profile) {
                http_response_code(201);
                echo json_encode($profile);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to create profile', 'status' => '500', 'path' => $input]);
            }
        }
    }

    public function updateProfile($id, $input) {
        $profile = getProfileById($id);
        if ($profile) {
            $profile = updateProfile($id, $input);
            http_response_code(200);
            echo json_encode($profile);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Profile not found', 'status' => '404', 'path' => $id]);
        }
    }
}