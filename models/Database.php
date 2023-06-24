<?php
class Database {
    private static $instance = NULL;
    private function __construct() {}
    private function __clone() {}

    public static function getInstance() {
        if (!isset(self::$instance)) {
            try {
                // Informations de connexion à la base de données
                $host = "localhost";
                $dbname = "smartphone_store";
                $username = "root";
                $password = "";

                // Options de connexion
                $options = array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"
                );

                // Connexion à la base de données avec PDO
                $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
                self::$instance = new PDO($dsn, $username, $password, $options);
            } catch (PDOException $e) {
                // Gérer l'exception
                throw new Exception("Database connection error : " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}

