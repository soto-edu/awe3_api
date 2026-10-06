<?php

require_once 'config.php';

class Database {
    private $db;

    public function __construct() {

        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $this->db = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'Erreur' => true,
                'message' => 'Erreur de connexion à la base de données',
                'error_code' => 'DB_CONNECTION_ERROR'
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    public function getDb() {
        return $this->db;
    }
}