<?php	

require_once '../config/database.php';

function getAllProfiles() {
    $db = getDb();
    $stmt = $db->prepare('SELECT * FROM profiles');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProfileById($id) {
    $db = getDb();
    $stmt = $db->prepare('SELECT * FROM profiles WHERE id = :id');
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createProfile($input) {
    $db = getDb();
    $stmt = $db->prepare('INSERT INTO profiles (first_name, last_name, email, bio) VALUES (:first_name, :last_name, :email, :bio)');
    $stmt->execute([
        'first_name' => $input['first_name'],
        'last_name' => $input['last_name'],
        'email' => $input['email'],
        'bio' => $input['bio']
    ]);
    $lastId = $db->lastInsertId();
    return getProfileById($lastId);
}

function getProfileByEmail($email) {
    $db = getDb();
    $stmt = $db->prepare('SELECT * FROM profiles WHERE email = :email');
    $stmt->execute(['email' => $email]); 
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateProfile($id, $input) {
    $db = getDb();
    $stmt = $db->prepare('UPDATE profiles SET first_name = :first_name, last_name = :last_name, email = :email, bio = :bio WHERE id = :id');
    $stmt->execute([
        'id' => $id,
        'first_name' => $input['first_name'],
        'last_name' => $input['last_name'],
        'email' => $input['email'],
        'bio' => $input['bio']
    ]);
    return getProfileById($id);
}