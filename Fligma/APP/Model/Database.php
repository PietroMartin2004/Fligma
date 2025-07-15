<?php
// FLIGMA/APP/Model/Database.php
namespace App\Model;

use PDO;
use PDOException;

class Database {
    private static $instance;

    public static function getInstance(): PDO {
        if (!self::$instance) {
            try {
                $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

                self::$instance = new PDO(
                    $dsn,
                    DB_USER,
                    DB_PASS,
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                    ]
                );
            } catch (PDOException $e) {
                die("Erro de conexão com o banco de dados: " . $e->getMessage() . "<br>Código do Erro: " . $e->getCode());
            }
        }
        return self::$instance;
    }

    private function __clone() {}
    public function __wakeup() {}
    private function __construct() {}
}