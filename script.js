let cart = new Map();

// Функция для добавления товара в корзину
function addToCart(button) {
    const itemId = button.id;
    const itemName = button.closest('.popup-text-container').querySelector('h2').innerText;
    const itemPrice = parseFloat(button.getAttribute('data-price')); 

    // Проверяем, есть ли уже товар в корзине
    if (cart.has(itemId)) {
        cart.get(itemId).quantity += 1;
    } else {
        cart.set(itemId, {
            name: itemName,
            price: itemPrice,
            quantity: 1
        });
    }
}

// Обработчик событий для кнопок "Добавить в корзину"
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        addToCart(this);
    });
});

// Функция для отображения чека в корзине
function displayCartReceipt() {
    const cartItemsContainer = document.getElementById('cartItems');
    cartItemsContainer.innerHTML = ''; // Очищаем предыдущие элементы
    let totalAmount = 0;

    // Проверяем, есть ли товары в корзине
    if (cart.size === 0) {
        cartItemsContainer.innerHTML = '<p>Ваша корзина пуста.</p>';
        return;
    }

    // Перебираем каждый товар в корзине
    cart.forEach((item) => {
        const itemTotal = item.price * item.quantity;
        totalAmount += itemTotal;

        // Создаем новый элемент для каждого товара
        const itemElement = document.createElement('p');
        itemElement.textContent = `${item.name} x${item.quantity} (${itemTotal}₽)`; // Добавили ₽ для обозначения валюты
        cartItemsContainer.appendChild(itemElement);
    });

    // Добавляем итоговую сумму в корзину
    const separator = document.createElement('hr'); // Создаем разделительную линию
    const totalElement = document.createElement('p');
    totalElement.textContent = `Итог: ${totalAmount}₽`; // Добавили ₽ для обозначения валюты
    
    cartItemsContainer.appendChild(separator);
    cartItemsContainer.appendChild(totalElement);
}


function placinganorder() {
    // Проверка на наличие элементов в корзине
    if (cart.size === 0) {
        alert("Корзина пуста!");
        return;
    }

    // Преобразование содержимого корзины в массив
    let cartArray = Array.from(cart.entries()).map(([key, value]) => {
        return { productId: key, quantity: value };
    });


    // Создание AJAX-запроса
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "php/process_order.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Обработка ответа от сервера
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);

                if (response.isAuthenticated) {
                    if (response.orderSuccess) {
                        alert("Заказ успешно оформлен!");
                        updateOrders();
                        cart.clear();
                        const cartItemsContainer = document.getElementById('cartItems');
                        cartItemsContainer.innerHTML = 'Ваша корзина пуста.';
                    } else {
                        alert("Ошибка при оформлении заказа.");
                    }
                } else {
                    alert("Пожалуйста, авторизуйтесь, чтобы оформить заказ.");
                }
            } else {
                alert("Ошибка при обработке запроса.");
            }
        }
    };

    // Формирование данных для отправки
    const data = `cart=${encodeURIComponent(JSON.stringify(cartArray))}`;
    
    // Отправка запроса
    xhr.send(data);

}

// Функция для открытия попапа корзины и отображения чека
function openCartPopup() 
{
    openPopup('cartPopup'); // Открываем попап
    displayCartReceipt(); // Отображаем чек перед открытием попапа
    
}

// Функция для открытия попапа
function openPopup(popupId) {
    document.getElementById(popupId).style.display = 'block';
}

// Функция для закрытия попапа
function closePopup(popupId) {
    document.getElementById(popupId).style.display = 'none';
}


// Закрытие попапа при нажатии вне его содержимого
window.onclick = function(event) {
    const popups = document.querySelectorAll('.popup');
    popups.forEach(popup => {
        if (event.target === popup) {
            popup.style.display = 'none';
        }
    });
};

function updateOrders() {


    fetch('php/phpfetch_orders.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Сеть не отвечает');
            }
            return response.json();
        })
        .then(data => {

            const ordDiv = document.getElementById('ord');
            ordDiv.innerHTML = ''; // Очищаем содержимое div перед добавлением новых данных

            if (data.length > 0) {
                let ordersHtml = '<ul>'; // Начинаем список
                data.forEach(order => {
                    const status = order.Readiness == 0 ? 'Готовится' : 'В пути';
                    ordersHtml += `<li>Заказ ID: ${order.idOrders} - Статус: ${status}</li>`;
                });
                ordersHtml += '</ul>'; // Заканчиваем список
                ordDiv.innerHTML = ordersHtml; // Добавляем HTML в div
            } else {
                ordDiv.innerHTML = '<p>Нет заказов.</p>'; // Если заказов нет
            }
        })
        .catch(error => {
            const ordDiv = document.getElementById('ord');
            ordDiv.innerHTML = '<p>Вы не авторизовались</p>';
        });
}


// Обработка авторизации через AJAX
document.getElementById('authForm').onsubmit = function(event) {
    event.preventDefault(); // Отменяем стандартное поведение формы

    var formData = new FormData(this); // Собираем данные формы

    fetch('php/login.php', { // Отправляем AJAX-запрос
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('responseMessage').innerText = data.message; // Отображаем сообщение
        if (data.status === 'success') {
            closePopup('authPopup'); 
            document.getElementById('authButton').innerText = 'Выйти'; // Меняем текст кнопки на "Выйти"
            document.getElementById('statusMessage').innerText = 'Вы: ' + data.nick ; 
            document.getElementById('regButton').style.display = "none";
            updateOrders();
        }
    })
    .catch(error => console.error('Ошибка:', error));

    
};

// Обработка нажатия кнопки авторизации/выхода
document.getElementById('authButton').onclick = function() {
    if (this.innerText === 'Выйти') {
        fetch('php/login.php', {
            method: 'POST',
            body: new URLSearchParams({ logout: true }) // Отправляем запрос на выход
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('responseMessage').innerText = data.message; // Отображаем сообщение
            this.innerText = 'Авторизация'; // Меняем текст кнопки
            // Обновляем статус авторизации
            document.getElementById('statusMessage').innerText = 'Вы: не авторизовались'; // Обновляем статус

            updateOrders();
        })
        .catch(error => console.error('Ошибка:', error));
        document.getElementById('regButton').style.display = "block";
    } else {
        openPopup('authPopup');
    }
};


document.querySelector('.navbar a[onclick*="cartPopup"]').addEventListener('click', openCartPopup);





updateOrders();