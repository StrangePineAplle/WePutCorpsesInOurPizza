<?php

function sqlrequest($query) {
    $servername = "localhost";
    $username = "root";
    $password = "0000";
    $database = "pizza";

    // Создаем соединение
    $conn = mysqli_connect($servername, $username, $password, $database);

    // Проверяем соединение
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Выполняем запрос
    $result = mysqli_query($conn, $query);

    // Проверяем на ошибки выполнения запроса
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Обработка результатов
    $data = [];
    
    // Проверяем тип запроса
    if (stripos($query, 'SELECT') === 0) {
        // Если это SELECT запрос
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            mysqli_free_result($result); // Освобождаем память
        }
    } else {
        // Для других типов запросов (INSERT, UPDATE, DELETE)
        if (mysqli_affected_rows($conn) > 0) {
            // Запрос выполнен успешно и затронул строки
            return true;
        } else {
            return false; // Никакие строки не были затронуты
        }
    }

    mysqli_close($conn); // Закрываем соединение

    return $data;
}

?>