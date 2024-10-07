<?php

require 'databaseconnect.php'; 


// Получаем данные из POST-запроса
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $username = $data['username'];
    $password = $data['password']; 
    $phone = $data['phone'];
    $address = $data['address'];

    $sql = "INSERT INTO `pizza`.`user` (`Nick`, `Password`, `Bonuses`, `Address`, `Telephone`) VALUES ('$username', '$password', '0', '$address', '$phone');";


    sqlrequest($sql);

    echo json_encode(['success' => true, 'message' => 'Регистрация успешна!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Ошибка в получении данных.']);
}
?>