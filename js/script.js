'use strict';


const top_bar = document.querySelector('.header-container');
const content = document.querySelector('.content');
content.style.margin = top_bar.offsetHeight + 'px 0 0';


let square = document.querySelectorAll('._square');
square.forEach((element) => {
    element.style.height = element.offsetWidth + 'px';
});

function menuBtn(element) {
	element.parentElement.classList.toggle('_active');
	if (element.parentElement.classList.contains('_active')) {
		element.closest('body').classList.add('_locked');
	}
	else {
		element.closest('body').classList.remove('_locked');
	}
}
function homeBtn() {
    window.open("index.php", "_self");
}
function catalogBtn() {
    window.open("catalog.php", "_self");
}
function cartBtn() {
    if (!getCookie('user')) {
        window.open("authorization.html", "_self");
    }
    else {
		window.open("cart.php", "_self");
    }
}
function orderBtn() {
    if (!getCookie('user')) {
        window.open("authorization.html", "_self");
    }
    else {
		window.open("order.php", "_self");
    }
}
function productBtn(event) {
	let linkto = event.dataset.href;
	window.open(linkto, "_self");
}
function categoryBtn(event) {
	let category = event.textContent.trim();
    let link = 'catalog.php?id='+category;
	window.open(link, "_self");
}
function addCart(event) {
    if (!getCookie('user')) {
        window.open("authorization.html", "_self");
    }
    else {
        let count = parseInt(event.dataset.count);
        let id = event.dataset.id;
        addToCart(id, count);
        window.open("cart.php", "_self");
    }
}
function delCart(event) {
    let id_peoduct = event.dataset.id;
    removeFromCart(id_peoduct);
    location.reload();
}


function logoutBtn() {
    window.open("php/logout.php", "_self");
}


function autoResize(textarea) {
	textarea.style.height = 'auto'; // Сбросить высоту на автоматическую
	textarea.style.height = textarea.scrollHeight + 'px'; // Установить высоту равной высоте содержимого
}

// Получение текущей корзины из кук
var cart = getCartFromCookies();

// Функция для получения текущей корзины из кук
function getCartFromCookies() {
  var cartCookie = getCookie('cart');
  if (cartCookie) {
    return JSON.parse(cartCookie);
  } else {
    return {};
  }
}
// Функция для получения значения куки по имени  
function getCookie(name) {
    const cookies = document.cookie.split("; ");
    for (let i = 0; i < cookies.length; i++) {
      const cookie = cookies[i].split("=");
      if (cookie[0] === name) {
        return cookie[1];
      }
    }
    return false;
}

// Функция для установки корзины в куки
function setCartToCookies(cart) {
  var cartCookie = JSON.stringify(cart);
  setCookie('cart', cartCookie, 7); // 7 - срок хранения куки в днях
}

// Функция для установки значения куки
function setCookie(name, value, days) {
  var expires = '';
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    expires = '; expires=' + date.toUTCString();
  }
  document.cookie = name + '=' + value + expires + '; path=/';
}

// Добавление продукта в корзину
function addToCart(productId, quantity) {
  if (cart[productId]) {
    cart[productId] += quantity;
  } else {
    cart[productId] = quantity;
  }
  setCartToCookies(cart);
}
// Удаление продукта в корзину
function removeFromCart(productId) {
  // Удаление продукта из корзины 
  delete cart[productId];

  // Обновление куки 'cart' с обновленной корзиной
  setCookie('cart', JSON.stringify(cart), 1);
  setCookie('total_cost', 0, 0);
}

