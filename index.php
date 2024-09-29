<?php
session_start(); // Запускаем сессию

// Проверяем, авторизован ли пользователь
$userNick = isset($_SESSION['user_nick']) ? $_SESSION['user_nick'] : null;

// Подключаем файл с функцией для работы с базой данных
include 'php/databaseconnect.php';

// Получение данных из таблицы dish
$dishes = sqlrequest("SELECT * FROM dish");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Стартовая страница</title>
    <link rel="stylesheet" href="style.css"> <!-- Подключение стилей -->
</head>
<body>

    <div class="container">

        <!-- Контейнер 1 : Балкон страницы с меню -->
        <div class="navbar">
            <a href="#about">О нас</a>
            <a href="#menu">Меню</a>
            <a onclick="openCartPopup('cartPopup')">Корзина</a>
            <p id="statusMessage">Вы: <?= $userNick ? htmlspecialchars($userNick) : 'не авторизовались' ?></p> <!-- Сообщение о статусе -->
            <button id="authButton" onclick="openPopup('authPopup')"><?= $userNick ? 'Выйти' : 'Авторизация' ?></button>
        </div>

        <!-- Попап для авторизации -->
        <div id="authPopup" class="popup" style="display:none;">
            <div class="popup-content auth-popup-content">
                <span class="close" onclick="closePopup('authPopup')">&times;</span>
                <h2>Авторизация</h2>
                <form id="authForm">
                    <div class="form-group">
                        <label for="Nick">Ник:</label>
                        <input type="text" name="Nick" id="Nick" required>
                    </div>
                    <div class="form-group">
                        <label for="Password">Пароль:</label>
                        <input type="password" name="Password" id="Password" required>
                    </div>
                    <button type="submit" class="auth-submit-button">Войти</button>
                </form>
                <div id="responseMessage"></div> <!-- Для отображения сообщений -->
            </div>
        </div>

       <!-- Попап для корзины -->
<div id="cartPopup" class="popup cart-popup" style="display:none;">
    <div class="popup-content auth-popup-content">
        <span class="close" onclick="closeCartPopup('cartPopup')">&times;</span>
        <h2>Корзина</h2>
        <div id="cartItems">
            <!-- Здесь будут отображаться товары в корзине -->
            <p>Ваша корзина пуста.</p> <!-- Сообщение по умолчанию -->
        </div>
        <button id="checkoutButton" class="auth-submit-button">Оформить заказ</button>
    </div>
</div>

        <!-- Контейнер 2 : Секция "О нас" -->
        <div class="about-section" id="about">
            <h1>Привет, мы кладём в пиццу ананасы!</h1>
            <p>Ахаха</p>
        </div>

<!-- Контейнер 3 : Меню с блоками -->
<div class="menu-block" id="menu">
    <?php if ($dishes): ?>
        <?php foreach ($dishes as $dish): ?>
            <!-- Блок меню для каждого блюда -->
            <div class="block">
                <img src="./img/img1.png" alt="<?= htmlspecialchars($dish['name']) ?>">
                <h3><?= htmlspecialchars($dish['name']) ?></h3> <!-- Добавлено название блюда -->
                <p><?= htmlspecialchars($dish['Description_sh']) ?></p>
		<p><?= htmlspecialchars($dish['Cost']) ?></p>
                <button onclick="openPopup('popup<?= $dish['id'] ?>')">Подробнее</button>
            </div>

            <!-- Попапы для подробного описания -->
            <div id="popup<?= $dish['id'] ?>" class="popup">
                <div class="popup-content">
                    <span class="close" onclick="closePopup('popup<?= $dish['id'] ?>')">&times;</span>
                    <table class="popup-table">
                        <tr>
                            <td class="popup-image-container">
                                <img src="./img/img1.png" alt="<?= htmlspecialchars($dish['name']) ?>" class="popup-image"> <!-- Картинка пиццы -->
                            </td>
                            <td class="popup-text-container">
                                <h2><?= htmlspecialchars($dish['name']) ?></h2>
                                <p><?= htmlspecialchars($dish['Description_fu']) ?></p>
                                <div class="button-container">
                                    <button class="add-to-cart" id="<?= htmlspecialchars($dish['id']) ?>" data-price="<?= htmlspecialchars($dish['Cost']) ?>">Добавить в корзину</button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        <?php endforeach; ?>
    <?php else: ?>
        <p>Нет доступных блюд.</p>
    <?php endif; ?>
</div>

    <!-- Контейнер 4 : Подвал -->
    <div class="container">
        <!-- Здесь подразумевается место для содержимого -->
        <footer class="footer"></footer>
    </div>

    <!-- Подключение скрипта -->
    <script src="script.js"></script>

</body>
</html>