  <?php

require_once 'config.php';
class Login {
    private $pdo;

    public function __construct() {
       try {
            $db = new Database();
            $this->pdo = $db->getPDO();
              } catch (PDOException $e) {
            die("Erreur de base de données : " . $e->getMessage());
        }
             }
    function getUser(){

        $sql = "SELECT * FROM etudiants WHERE email_etu = :v1 AND password_etu = :v2";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':v1', $_POST['email']);
        $stmt->bindParam(':v2', $_POST['password']);
        $stmt->execute();
        return $stmt->fetch();
    }
    function getAdmin(){

        $sql2 = "SELECT * FROM admins WHERE email_admin = :v1 AND password_admin = :v2";
        $stmt2 = $this->pdo->prepare($sql2);
        $stmt2->bindParam(':v1', $_POST['email']);
        $stmt2->bindParam(':v2', $_POST['password']);
        $stmt2->execute();
        return $stmt2->fetch();
    }        

    
    
    
    
    
}

$etu = new Login();
$user = $etu->getUser();
$admin = $etu->getAdmin(); 
session_start();
if($user){
    $_SESSION['user'] = $user;
    header("Location: ../afichages/etudiant/offres.php");
    
    exit();
}
else if($admin){
    $_SESSION['admin'] = $admin;
     header("Location: ../afichages/admin/admin.php");
}
else{
   header("Location: ../index/incorrect.html");
}
?>



