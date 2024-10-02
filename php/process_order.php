<?php
session_start();

require 'databaseconnect.php'; // Подключение к базе данных

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userNick = isset($_SESSION['user_nick']) ? $_SESSION['user_nick'] : null;

    if (!is_null($userNick) && isset($_POST['cart'])) {
        $cartData = json_decode($_POST['cart'], true);
        $id = $_SESSION['user_id'] ;
        

        sqlrequest("INSERT INTO `pizza`.`orders` (`idUsers`, `Readiness`) VALUES ('$id', b'0');");



        echo json_encode([
            'isAuthenticated' => true,
            'orderSuccess' => true 
        ]);
    } else {
        echo json_encode(['isAuthenticated' => false]);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
}
?>