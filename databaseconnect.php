<?php

function sqlrequest($query) {
    $servername = "localhost";
    $username = "root";
    $password = "0000";
    $database = "pizza";

    // Создаем соединение
    $conn = mysqli_connect($servername, $username, $password, $database);

    // Проверяем соединение
    if (!$conn)
        die("Connection failed: " . mysqli_connect_error());


    // Выполняем запрос
    $result = mysqli_query($conn, $query);

    // Проверяем на ошибки выполнения запроса
    if (!$result)
        die("Query failed: " . mysqli_error($conn));


    // Обработка результатов
    $data = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result))
            $data[] = $row;
        mysqli_free_result($result); // Освобождаем память
    }

    mysqli_close($conn); // Закрываем соединение

    return $data;
}

?>