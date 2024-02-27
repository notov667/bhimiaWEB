'use strict';

const product_cost = document.getElementById('product_cost');
const product_count = document.getElementById('product_count');
const product_btn = document.getElementById('product_btn');

function minusBtn() {
    var num = strToInt(product_count.textContent);
    var cost = strToInt(product_cost.textContent);
    if (num > 1) {
        cost = cost - (cost / num);
        num--;
    }

    product_btn.dataset.count = num;
    product_count.textContent = num;
    product_cost.textContent = cost;
}
function plusBtn() {
    var num = strToInt(product_count.textContent);
    var cost = strToInt(product_cost.textContent);
    if (num > 0) {
        cost = cost + (cost / num);
    }
    num++;

    product_btn.dataset.count = num;
    product_count.textContent = num;
    product_cost.textContent = cost;
}

function strToInt(str) {
    var num = parseInt(str);
    return num;
}