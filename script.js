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