<?php

require_once 'database.php';

class ProfileModel extends Database {

    public function getAllProfiles() {
        $stmt = $this->getDb();
        $stmt = $stmt->prepare('SELECT * FROM profiles');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProfileById($id) {
        $stmt = $this->getDb();
        $stmt = $stmt->prepare('SELECT * FROM profiles WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createProfile($input) {
        $db = $this->getDb();
        $stmt = $db->prepare('INSERT INTO profiles (first_name, last_name, email, bio) VALUES (:first_name, :last_name, :email, :bio)');
        $stmt->execute([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'bio' => $input['bio']
        ]);
        $lastId = $db->lastInsertId();
        return $this->getProfileById($lastId);
    }

    function getProfileByEmail($email) {
        $stmt = $this->getDb()->prepare('SELECT * FROM profiles WHERE email = :email');
        $stmt->execute(['email' => $email]); 
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $input) {
        $stmt = $this->getDb();
        $stmt = $stmt->prepare('UPDATE profiles SET first_name = :first_name, last_name = :last_name, email = :email, bio = :bio WHERE id = :id');
        $stmt->execute([
            'id' => $id,
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'bio' => $input['bio']
        ]);
        return $this->getProfileById($id);
    }
}