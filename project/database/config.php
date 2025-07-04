<?php
class Database {
    private $host = '127.0.0.1';
    private $dbname = 'gestion_stages';
    private $username = 'root';
    private $password = 'hhh999farsale';
    public $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4",
                                 $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

  
    public function getPDO() {
        return $this->pdo;
    }
}
?>
