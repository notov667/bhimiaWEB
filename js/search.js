'use strict';

const search_form = document.getElementById('search_form');
const search_form_mobile = document.getElementById('search_form_mobile');

search_form.addEventListener('submit', (e)=>{
    e.preventDefault();
    let input = search_form.querySelector('input');
    searchProduct(input);
});
search_form_mobile.addEventListener('submit', (e)=>{
    e.preventDefault();
    let input = search_form_mobile.querySelector('input');
    searchProduct(input);
});

function searchProduct(input) {
    let link = 'catalog.php?id='+input.value;
	window.open(link, "_self");
}