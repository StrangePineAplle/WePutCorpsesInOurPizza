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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">

        <!-- Контейнер 1 : Балкон страницы с меню -->
        <div class="navbar">
            <a href="#about">О нас</a>
            <a href="#menu">Меню</a>
            <a href="#zakaz">Мои заказы</a>
            <a onclick="openCartPopup('cartPopup')">Корзина</a>
            <p id="statusMessage" >Вы: <?= $userNick ? htmlspecialchars($userNick) : 'не авторизовались' ?></p> <!-- Сообщение о статусе -->
            <button id="authButton" class="auth-button" onclick="openPopup('authPopup')"><?= $userNick ? 'Выйти' : 'Авторизация' ?></button>
            <button id="regButton" class="auth-button" onclick="openPopup('regPopup')">Регистрация</button>
        </div>

        <!-- Попап для авторизации -->
        <div id="authPopup" class="popup-auth popup" style="display:none;">
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

        <!-- Попап для регистрации -->
        <div id="regPopup" class="popup-auth popup" style="display:none;">
            <div class="popup-content auth-popup-content">
                <span class="close" onclick="closePopup('regPopup')">&times;</span>
                <h2>Регистрация</h2>
                <form id="regForm">
                    <div class="form-group">
                        <label for="username">Логин:</label>
                        <input type="text" name="username" id="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль:</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Номер телефона:</label>
                        <input type="tel" name="phone" id="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Адрес доставки:</label>
                        <input type="text" name="address" id="address" required>
                    </div>
                    <button type="submit" class="auth-submit-button" onclick="Register(event)">Зарегистрироваться</button>
                </form>
                <div id="responseMessage"></div> <!-- Для отображения сообщений -->
            </div>
        </div>

       <!-- Попап для корзины -->
        <div id="cartPopup" class="popup cart-popup" style="display:none;">
            <div class="popup-content auth-popup-content">
                <span class="close" onclick="closePopup('cartPopup')">&times;</span>
                <h2>Корзина</h2>
                <div id="cartItems">
                    <!-- Здесь будут отображаться товары в корзине -->
                    <p>Ваша корзина пуста.</p> <!-- Сообщение по умолчанию -->
                </div>
                <button id="checkoutButton" class="auth-submit-button" onclick="placinganorder()">Оформить заказ</button>
            </div>
        </div>


        <!-- Попап для авторизации -->



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
                        <img src="./img/pizzaImg/<?= htmlspecialchars($dish['Picture']) ?>.png" alt="<?= htmlspecialchars($dish['name']) ?>" onclick="openPopup('popup<?= $dish['id'] ?>')" style="cursor: pointer;">
                        <h3><?= htmlspecialchars($dish['name']) ?></h3> <!-- Добавлено название блюда -->
                        <p><?= htmlspecialchars($dish['Description_sh']) ?></p>
                        <p class="cost-text"><?= htmlspecialchars($dish['Cost']) ?></p>
                        <button class="menu-button" onclick="openPopup('popup<?= $dish['id'] ?>')">Подробнее</button>
                    </div>

                    <!-- Попапы для подробного описания -->
                    <div id="popup<?= $dish['id'] ?>" class="popup">
                        <div class="popup-content">
                            <span class="close" onclick="closePopup('popup<?= $dish['id'] ?>')">&times;</span>
                            <table class="popup-table">
                                <tr>
                                    <td class="popup-image-container">
                                        <img src="./img/pizzaImg/<?= htmlspecialchars($dish['Picture']) ?>.png" alt="<?= htmlspecialchars($dish['name']) ?>" class="popup-image"> <!-- Картинка пиццы -->
                                    </td>
                                    <td class="popup-text-container">
                                        <h3 style="display: inline;" class="selected-text">ВЫБРАНА:</h3>
                                        <h2 style="display: inline;"><?= htmlspecialchars($dish['name']) ?></h2>
                                        <p><?= htmlspecialchars($dish['Description_fu']) ?></p>
                                        <p class="cost-text" ><?= htmlspecialchars($dish['Cost'])?>  </p>
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
    <div class="container" id="zakaz">
        <div class="order-container">
            <button onclick="updateOrders()">Обновить</button>
            <div id="ord">

            </div>
        </div>
        <footer class="footer"></footer>
    </div>

    <!-- Подключение скрипта -->
    <script src="script.js"></script>


</body>
</html>