'use strict';

const overlay = document.querySelector('.form-container');

function regSwitch() {
    overlay.classList.add('_switched');
}
function loginSwitch() {
    overlay.classList.remove('_switched');
}