<?php
session_start(); // Запускаем сессию

require 'databaseconnect.php'; // Подключение к базе данных

$id = $_SESSION['user_id'];
$sql = "SELECT idOrders, Readiness FROM pizza.orders WHERE idUsers = '$id';";

$res = sqlrequest($sql);


header('Content-Type: application/json');


echo json_encode($res);
?>