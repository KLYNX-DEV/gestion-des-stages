<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: ../../index/index.html');
    exit();
}
require_once "../../database/config.php";
$db = new Database();
$pdo = $db->getPDO();
$id = $_GET['id_cand'];
$stmt = $pdo->prepare("SELECT e.cv 
        FROM candidatures c
        JOIN etudiants e ON c.id_etu = e.id_etu
        WHERE c.id_cand = :id_cand ");
$stmt->bindParam(":id_cand",$id);
$stmt->execute();
$etu = $stmt->fetch();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>voir cv</title>
    <style>
        iframe{
            width: 100%;
            height: 100vh;
        }
    </style>
</head>
<body>
    <iframe src="<?=$etu['cv']?>" frameborder="1"></iframe>
</body>
</html>