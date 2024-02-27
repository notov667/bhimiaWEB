'use strict';

if (!getCookie('user')) {
    window.open("authorization.html", "_self");
}

function orderSubmit() {
    let success = document.querySelector('.success-popup');
    let formReq = document.querySelectorAll('._req');
    let errmessage = document.querySelector('.error-message');
    let err = 0;
    errmessage.innerHTML = "";
    for (let index = 0; index < formReq.length; index++) {
        const input = formReq[index];
        const message = document.createElement('a');
        message.textContent = "";
        input.classList.remove('_error');
        if (input.value == '') {
            input.classList.add('_error');
            errmessage.innerHTML = "Поле пустое";
            err++;
        }
        else {
            if (input.classList.contains('_tel')) {
                if (!TelTest(input)) {
                    input.classList.add('_error');
                    message.textContent = "Телефон введен не коректно";
                    errmessage.appendChild(message);
                    err++;
                }
            }
            else if (input.classList.contains('_email')) {
                if (!EmailTest(input)) {
                    input.classList.add('_error');
                    message.textContent = "email введен не коректно";
                    errmessage.appendChild(message);
                    err++;
                }
            }
        }
    }
    if(err === 0) {
        removeClassForSeconds(success, '_hidden', 2);
        fetch('php/clearcart.php', {
        method: 'GET' // Метод запроса (например, GET, POST, PUT, DELETE)
        });
    }
}


//tel validation
function TelTest(input) {
    return /^[\d\+][\d\(\)\ -]{9,10}\d$/.test(input.value);
}
//email validation
function EmailTest(input) {
    return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/.test(input.value);
}

function closePopup() {
    let popup = document.querySelector('.success-popup');
    popup.classList.add('_hidden');
}

function addClassForSeconds(element, className, seconds) {
    element.classList.add(className);
  
    setTimeout(function() {
      element.classList.remove(className);
    }, seconds * 1000);
}
function removeClassForSeconds(element, className, seconds) {
    element.classList.remove(className);
  
    setTimeout(function() {
      element.classList.add(className);
    }, seconds * 1000);
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