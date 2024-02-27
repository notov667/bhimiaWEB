'use strict';

if (!getCookie('user')) {
    window.open("authorization.html", "_self");
}

let user_img = document.querySelector('.user-img');
user_img.style = 'font-size: ' + (user_img.offsetWidth-1) + 'px';
user_img.style.height = user_img.offsetWidth + 'px';

let updatepass = document.getElementById('updatepass');
	
updatepass.addEventListener('submit', function(e) {
    e.preventDefault();
    formVal(updatepass);
});

function formVal(form) {
    let formReq = form.querySelectorAll('._req');
    let errmessage = form.querySelector('#error-message');
    errmessage.style.opacity = '0';
    let err = 0;
    errmessage.innerHTML = "";
    for (let index = 0; index < formReq.length; index++) {
        const input = formReq[index];
        const message = document.createElement('a');
        message.textContent = "";
        input.classList.remove('_error');
        if (input.value == '') {
            input.classList.add('_error');
            errmessage.innerHTML = "The field is empty";
            errmessage.style.opacity = '1';
            err++;
        }
        else {
            if (input.classList.contains('_pass')) {
                if (!PassTest(input)) {
                    input.classList.add('_error');
                    message.textContent = "password entered incorrectly";
                    errmessage.appendChild(message);
                    errmessage.style.opacity = '1';
                    err++;
                }
            }
        }
    }
    if(err === 0) {
        submitForm(form, form.action, errmessage);
    }
}

function submitForm(formId, url, errmessage) {
    const formData = new FormData(formId);
    errmessage.style.opacity = '0';
    fetch(url, {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '../cart.php'; 
        } 
        else {
            errmessage.innerHTML = data.error;
            errmessage.style.opacity = '1';
        }
    });
}
//password validation
function PassTest(input) {
  return /(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,16}/.test(input.value);
}

function imageInput(event) {
    UploadFile(event, event.files[0]);
}

function UploadFile(input, file) {
    if(!['image/jpeg', 'image/jpg', 'image/png'].includes(file.type)) {
        alert('Only images are allowed.');
        input.value = '';
        return;
    }
    else if(file.size > 2 * 1024 * 1024) {
        alert('The file must be less than 2 MB.');
        input.value = '';
        return;
    }
    else {
    	let imagePreview = document.querySelector('.user-img img');
	    var reader = new FileReader();
	    reader.onload = function (e) {
	        imagePreview.style.display = 'block';
	        imagePreview.src = e.target.result;
            const inputForm = input.closest('form');
            updatePhoto(inputForm);
	    }
	    reader.onerror = function () {
	        alert('Ошибка загрузки.');
	    }
	    reader.readAsDataURL(file);
    }
}


function updatePhoto(formId) {
    const formData = new FormData(formId);
    console.log(formData);
    fetch('../php/updatephoto.php', {
        method: "POST",
        body: formData
    });
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


const product_count = document.getElementById('product_count');

function minusBtn(event) {
    let id = event.dataset.id;
    var num = strToInt(product_count.textContent);
    if (num > 1) {
        num--;
        product_count.textContent = num;
        addToCart(id, -1);
    }
    else {
        removeFromCart(id);
    }
    location.reload();

}
function plusBtn(event) {
    let id = event.dataset.id;
    var num = strToInt(product_count.textContent);
    num++;

    product_count.textContent = num;

    addToCart(id, 1);
    location.reload();
}

function strToInt(str) {
    var num = parseInt(str);
    return num;
}