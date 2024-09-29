let cartIDs = [];

// Функция для добавления ID товара в корзину
function addToCart(button) 
{
    const itemId = button.id;
    cartIDs.push(itemId);
    console.log(`Товары  : ${cartIDs}`);
}


document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        addToCart(this);
    });
});



function openPopup(popupId) {
    document.getElementById(popupId).style.display = 'block';
}

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
            closePopup('authPopup'); // Закрываем попап при успешной авторизации
            document.getElementById('authButton').innerText = 'Выйти'; // Меняем текст кнопки на "Выйти"
            document.getElementById('statusMessage').innerText = 'Вы: ' + data.nick + ' (авторизованы)'; 
        }
    })
    .catch(error => console.error('Ошибка:', error));
};

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
        })
        .catch(error => console.error('Ошибка:', error));
    } else {
        openPopup('authPopup');
    }
};