'use strict';


function imageInput(event) {
	const form = event.closest('form');
    const imagePreview = form.querySelector('.img_preview');
    UploadFile(event, event.files[0], imagePreview);
}

function UploadFile(input, file, imagePreview) {
    if(!['image/jpeg', 'image/jpg', 'image/png'].includes(file.type)) {
        alert('Разрешены только изображения.');
        input.value = '';
        return;
    }
    if(file.size > 2 * 1024 * 1024) {
        alert('Файл должен быть менее 2 Мб.');
        input.value = '';
        return;
    }

    var reader = new FileReader();
    reader.onload = function (e) {
        imagePreview.src = e.target.result;
    }
    reader.onerror = function () {
        alert('Ошибка загрузки.');
    }
    reader.readAsDataURL(file);
}

