<?php
session_start(); // Запускаем сессию

require 'databaseconnect.php'; // Подключение к базе данных

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['logout'])) {
        // Выход из системы
        session_destroy();
        echo json_encode(["status" => "success", "message" => "Вы вышли из системы."]);
        exit;
    }

    $nick = $_POST['Nick'] ?? '';
    $password = $_POST['Password'] ?? '';

    // Экранируем входные данные для безопасности
    $nick = htmlspecialchars($nick);
    $password = htmlspecialchars($password);

    // Запрос для проверки наличия пользователя
    $sqlSelectUser = "SELECT * FROM user WHERE Nick = '$nick' AND Password = '$password'";
    $resultsUser = sqlrequest($sqlSelectUser); // Выполнение запроса

    if (!empty($resultsUser)) {
        $_SESSION['user_nick'] = $nick; // Сохраняем ник в сессии
        $_SESSION['user_id'] = $resultsUser[0]['id'];
        echo json_encode(["status" => "success", "message" => "Успешная авторизация!", "nick" => $nick]);
    } else {
        echo json_encode(["status" => "error", "message" => "Неправильный ник или пароль."]);
    }
}
?>