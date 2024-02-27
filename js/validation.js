'use strict';

if (getCookie('user')) {
    window.open("index.php", "_self");
}

const loginForm = document.querySelector('._login');
const regForm = document.querySelector('._reg');

loginForm.addEventListener('submit', function(e) {
    e.preventDefault();
    formVal(loginForm);
});
regForm.addEventListener('submit', function(e) {
    e.preventDefault();
    formVal(regForm);
});

function formVal(form) {
    let formReq = form.querySelectorAll('._req');
    let errmessage = form.querySelector('#error-message');
    let err = 0;
    errmessage.innerHTML = "";
    for (let index = 0; index < formReq.length; index++) {
        const input = formReq[index];
        const message = document.createElement('a');
        message.textContent = "";
        input.classList.remove('_error');
        if (input.classList.contains('_login')) {
            if (!LoginTest(input)) {
                input.classList.add('_error');
                message.textContent = "Логин введен не коректно";
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
        else if (input.classList.contains('_pass')) {
            if (!PassTest(input)) {
                input.classList.add('_error');
                message.textContent = "Пароль введен не коректно";
                errmessage.appendChild(message);
                err++;
            }
        }
        else {
            if (input.value == '') {
                input.classList.add('_error');
                message.textContent = "Поле пустое";
                errmessage.appendChild(message);
                err++;
            }
        }
    }
    if(err === 0) {
        submitForm(form, form.action, errmessage);

    }
}

function submitForm(formId, url, errmessage) {
    const formData = new FormData(formId);
    fetch(url, {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // если авторизация прошла успешно, перенаправляем пользователя на другую страницу
            window.location.href = '../index.php'; 
        } 
        else {
            // если авторизация не удалась, выводим сообщение об ошибке на странице
            errmessage.innerHTML = data.error;
        }
    });
}



//login validation
function LoginTest(input) {
  return /^[0-9a-zA-Z_-]{3,16}$/.test(input.value);
}
//email validation
function EmailTest(input) {
  return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/.test(input.value);
}
//password validation
function PassTest(input) {
  return /(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,16}/.test(input.value);
}

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