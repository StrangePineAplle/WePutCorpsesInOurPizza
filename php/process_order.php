<?php
session_start();

require 'databaseconnect.php'; // Подключение к базе данных

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userNick = isset($_SESSION['user_nick']) ? $_SESSION['user_nick'] : null;

    if (!is_null($userNick) && isset($_POST['cart'])) {
        $cartData = json_decode($_POST['cart'], true);
        $id = $_SESSION['user_id'];


        $res = sqlrequest("INSERT INTO `pizza`.`orders` (`idUsers`, `Readiness`) VALUES ('$id', b'0'); SELECT LAST_INSERT_ID() AS idOrders;");
        

        $idD = $res[0]['idOrders'];
        

        $sqlValues = [];
        

        foreach ($cartData as $item) {
            $idO = $item['productId'];
            $Am = $item['quantity']['quantity'];
            // Prepare each value set for insertion
            $sqlValues[] = "($idD, $idO, b'0', $Am)";
        }


        if (!empty($sqlValues)) {
            $sql = "INSERT INTO pizza.kitchen (`id_dish`, `id_orders`, `Ready`, `amount`) VALUES " . implode(',', $sqlValues) . ";";

            sqlrequest($sql);
        }

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