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

    // Проверяем, является ли запрос многоразовым
    if (stripos($query, ';') !== false) {
        // Выполняем многоразовый запрос
        if (mysqli_multi_query($conn, $query)) {
            $results = [];
            do {
                // Проверяем на наличие ошибок выполнения запроса
                if (mysqli_errno($conn)) {
                    die("Query failed: " . mysqli_error($conn));
                }

                // Обрабатываем результаты текущего запроса
                if ($result = mysqli_store_result($conn)) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $results[] = $row;
                    }
                    mysqli_free_result($result); // Освобождаем память
                }
            } while (mysqli_more_results($conn) && mysqli_next_result($conn));

            mysqli_close($conn); // Закрываем соединение
            return $results; // Возвращаем все результаты
        } else {
            die("Query failed: " . mysqli_error($conn));
        }
    } else {
        // Выполняем одиночный запрос
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
                mysqli_close($conn); // Закрываем соединение
                return true; // Запрос выполнен успешно и затронул строки
            } else {
                mysqli_close($conn); // Закрываем соединение
                return false; // Никакие строки не были затронуты
            }
        }

        mysqli_close($conn); // Закрываем соединение

        return $data; // Возвращаем данные из SELECT запроса или пустой массив по умолчанию
    }
}
?>