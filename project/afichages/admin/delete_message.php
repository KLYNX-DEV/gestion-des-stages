<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: ../../index/index.html');
    exit();
}
require_once "../../database/config.php";
        $db = new Database();
        $pdo = $db->getPDO();

        $id = (int)$_POST['id'];


        $stmt = $pdo->prepare("DELETE FROM messages WHERE id = :id");
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            header('Location: reception.php');
            exit();
        } else {
            echo "Erreur lors de la suppression du message.";
        }

