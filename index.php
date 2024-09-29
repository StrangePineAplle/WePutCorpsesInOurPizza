<?php
session_start(); // Запускаем сессию

// Проверяем, авторизован ли пользователь
if (isset($_SESSION['user_nick'])) {
    $userNick = $_SESSION['user_nick'];
} else {
    $userNick = null;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Стартовая страница</title>
</head>
<body>
    <h1>Добро пожаловать на стартовую страницу!</h1>
    
    <p id="statusMessage">Вы: <?= $userNick ? htmlspecialchars($userNick) : 'не авторизовались' ?></p> <!-- Сообщение о статусе -->

    <!-- Кнопка для открытия попапа или выхода -->
    <button id="authButton"><?= $userNick ? 'Выйти' : 'Авторизация' ?></button>

    <!-- Попап для авторизации -->
    <div id="authPopup" style="display:none;">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <form id="authForm">
                <label for="Nick">Ник:</label>
                <input type="text" name="Nick" id="Nick" required>
                <br>
                <label for="Password">Пароль:</label>
                <input type="password" name="Password" id="Password" required>
                <br>
                <input type="submit" value="Войти">
            </form>
            <div id="responseMessage"></div> <!-- Для отображения сообщений -->
        </div>
    </div>

    <style>
        /* Стили для попапа */
        #authPopup {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .popup-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 5px;
        }

        .close {
            cursor: pointer;
        }
    </style>

    <script>
        // Функция для открытия попапа
        document.getElementById('authButton').onclick = function() {
            if (document.getElementById('authButton').innerText === 'Выйти') {
                // Если пользователь нажал кнопку "Выйти"
                fetch('login.php', {
                    method: 'POST',
                    body: new URLSearchParams({ logout: true }) // Отправляем запрос на выход
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('responseMessage').innerText = data.message; // Отображаем сообщение
                    document.getElementById('statusMessage').innerText = 'Вы: не авторизовались'; // Обновляем статус
                    document.getElementById('authButton').innerText = 'Авторизация'; // Меняем текст кнопки
                })
                .catch(error => console.error('Ошибка:', error));
            } else {
                // Если пользователь нажал кнопку "Авторизация"
                document.getElementById('authPopup').style.display = 'block';
            }
        };

        // Функция для закрытия попапа
        function closePopup() {
            document.getElementById('authPopup').style.display = 'none';
        }

        // Закрытие попапа при клике вне его области
        window.onclick = function(event) {
            var popup = document.getElementById('authPopup');
            if (event.target === popup) {
                closePopup();
            }
        };

        // Обработка отправки формы через AJAX
        document.getElementById('authForm').onsubmit = function(event) {
            event.preventDefault(); // Отменяем стандартное поведение формы

            var formData = new FormData(this); // Собираем данные формы

            fetch('login.php', { // Отправляем AJAX-запрос
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('responseMessage').innerText = data.message; // Отображаем сообщение
                if (data.status === 'success') {
                    closePopup(); // Закрываем попап при успешной авторизации
                    
                    // Обновляем сообщение о статусе авторизации без перезагрузки страницы
                    document.getElementById('statusMessage').innerText = 'Вы: ' + data.nick + ' (авторизованы)'; 
                    document.getElementById('authButton').innerText = 'Выйти'; // Меняем текст кнопки на "Выйти"
                }
            })
            .catch(error => console.error('Ошибка:', error));
        };
    </script>

</body>
</html>