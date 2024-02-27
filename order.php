<?php
    include('php/database.php');
    $total_cost = $_COOKIE['total_cost']; 
    if ($total_cost == '') {
        $total_cost = 0;
    }

    $user = $_COOKIE['user'];
    $request = "SELECT * FROM `user` WHERE `login` = '$user'";
    $result = mysqli_query($conn, $request);
    foreach ($result as $row) {
        $user_name = $row['name'];
        $user_email = $row['email'];
    } 
    // Получение корзины из кукисов (включая только названия продуктов)
    function getCartFromCookies() {
        if (isset($_COOKIE['cart'])) {
            $cart = json_decode($_COOKIE['cart'], true);
            $productNames = array_keys($cart);
            return $productNames;
        } else {
            return [];
        }
    }
    
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бытовая химия - магазин</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/catalog.css">
    <link rel="stylesheet" href="css/order.css">
</head>
<body>
    <div class="header-container _fixed">
        <div class="header-wrapper container">
            <div class="header-info">
                <div class="header-info_text"><i class='bx bx-map'></i><a>г.Алматы, ул. Тимирязева 17</a></div>
                <div class="header-info_text"><i class='bx bx-envelope'></i><a><b>tiemirlan2004@mail.ru</b><br>На связи в любое время</a></div>
            </div>
            <div class="header-nav">
                <a href="index.php#aboutus">О компании</a>
                <a href="index.php#aboutus">Контакты</a>
                <a href="cart.php#">Личный кабинет</a>
            </div>
        </div>
        <div class="header-mobile container">
            <div class="header-mobile-menu">
                <div class="header-logo" onclick="homeBtn()"><img src="assets/logos/logo_light.svg" alt=""></div>
                <form id="search_form_mobile"><label><input type="text" placeholder="Поиск..."><button type="submit" class='bx bx-search'></button></label></form>
                <a onclick="catalogBtn()">Каталог</a>
                <a onclick="cartBtn()">Корзина</a>
                <a href="index.php#aboutus">О компании</a>
                <a href="index.php#aboutus">Контакты</a>
                <a href="cart.php#">Личный кабинет</a>
            </div>
            <div class="header-logo _absolute" onclick="homeBtn()"><img src="assets/logos/logo_dark.svg" alt=""></div>
            <i class='bx bx-user' onclick="cartBtn()"></i>
            <i class='bx bx-menu' onclick="menuBtn(this)"></i>
            <i class='bx bx-x' onclick="menuBtn(this)"></i>
        </div>
    </div>

    <div class="content">
        <div class="header-container">
            <div class="header-wrapper container">
                <div class="header-logo" onclick="homeBtn()"><img src="assets/logos/logo_dark.svg" alt=""></div>
                <div class="header-catalog">
                    <button onclick="catalogBtn()">Каталог<i class='bx bx-grid-alt'></i></button>
                    <form id="search_form" ><label class="header-search"><input type="text" placeholder="Поиск..."><button type="submit" class='bx bx-search'></button></label></form>
                </div>
                <div class="header-contact">
                    <div class="header-contact_text">
                        <a href="tel:+77779315849" target="_blank"><b>+7 (777) 931-58-49</b></a>
                        <a>время работы: 9:00-20:00</a>
                        <a href="tel:+77779315849" target="_blank"><u>Заказать звонок</u></a>
                    </div>
                    <a href="tel:+77779315849" class="header-contact_img"><img src="assets/contact_img.png" alt=""></a>
                </div>
                <div class="header-cart">
                    <i class='bx bx-cart' onclick="cartBtn()"></i>
                    <div class="header-cart_text" onclick="cartBtn()">
                        <a>Корзина</a>
                        <a><b><?=$total_cost?> ₸</b></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="order-wrapper">
                <div class="order-column">
                    <h2>Оформление заказа</h2>
                    <h4><span>1</span>Контактные данные</h4>
                    <label>Имя*<input class="_name _req" type="text" placeholder="Введите ваше имя" value="<?=$user_name?>"></label>
                    <label>Телефон*<input class="_tel _req" type="tel" placeholder="Введите ваш телефон"></label>
                    <label>E-mail*<input class="_email _req" type="email" placeholder="Введите ваше E-mail" value="<?=$user_email?>"></label>
                    <h4><span>2</span>Контактные данные</h4>
                    <label>Город*<input class="_city _req" type="text" placeholder="Введите ваш город"></label>
                    <label>Адрес*<input class="_address _req" type="text" placeholder="Введите ваш адрес"></label>
                </div>
                <div class="order-column">
                    <div class="order-card">
                        <h4><span class='bx bxs-wallet'></span>Оплата</h4>
                        <p>Принимаем оплату наличными, по карте и через расчетный счет.</p>
                    </div>
                    <div class="order-card">
                        <h4><span class='bx bxs-truck'></span>Доставка</h4>
                        <p>Бесплатная доставка от 10 000 ₸ по области. Наша доставка работает ежедневно.</p>
                    </div>
                    <div class="order-card">
                        <h4><span class='bx bx-question-mark'></span>Возникли вопросы?</h4>
                        <p>Звоните: +7 777 490 00 91 Менеджер Вам ответит на все вопросы.</p>
                    </div>
                    <h4><span>3</span>Контактные данные</h4>
                    <label>Комментарий*<textarea class="_comment" type="text" oninput="autoResize(this)" placeholder="Ваши пожелания..."></textarea></label>
                </div>
                <div class="order-column _products">
                    <h4>Ваш заказ <b><?=$total_cost?> ₸</b></h4>
                    <?php 
                        if ($product = mysqli_query($conn, "SELECT * FROM `product` ORDER BY `product`.`name` ASC;")) {
                            $cart = getCartFromCookies(); // Получаем информацию о корзине из кукисов
                            foreach ($product as $row) {
                                if (in_array($row['id'], $cart)) {

                                    echo '<div class="products-content _order" onclick="productBtn(this)" data-href="product.php?id=' . $row['id'] . '">';
                                    echo '<div class="products-image _square"><img src="' . $row['path'] . '" alt="">';
                                    echo '</div><div class="products-text">';
                                    echo '<div class="title">' . $row['name'].'</div>';
                                    echo '<p>' . $row['info'] . '</p></div></div>';
                                }
                            }
                        }     
                    ?>
                </div>

                <div class="order-button"><div class="error-message"></div><button onclick="orderSubmit()">Подтверждение заказа</button></div>

            </div>
        </div>
        
        <div class="success-popup _hidden">
            <div class="success-card">
                <i class='bx bx-check-double'></i>
                <h2>Спасибо за заказ</h2>
                <p>Наш менеджер свяжется с вами в ближайшее время</p>
            </div>
            <div class="success-bg" onclick="closePopup()"></div>
        </div>
    </div>

    
    <div class="footer-container" id="aboutus">
        <div class="footer-wrapper container">
            <div class="footer-info">
                <div class="footer-logo" onclick="homeBtn()"><img src="assets/logos/logo_light.svg" alt=""></div>
                <div class="footer-info_text">Компания «tmrln» — снабжаем розничные магазины товарами "под ключ" в Алмате и Алматинской области</div>
            </div>
            <div class="footer-links">
                <a><b>Меню сайта:</b></a>
                <a>О компании</a>
                <a>Возврат</a>
                <a>Контакты</a>
            </div>
            <div class="footer-links">
                <a><b>Категории:</b></a>
                <a onclick="categoryBtn(this)" class="_btn">Бытовая химия</a>
                <a onclick="categoryBtn(this)" class="_btn">Косметика и гигиена</a>
                <a onclick="categoryBtn(this)" class="_btn">Товары для дома</a>
                <a onclick="categoryBtn(this)" class="_btn">Товары для детей и мам</a>
                <a onclick="categoryBtn(this)" class="_btn">Посуда</a>
            </div>
            <div class="footer-links">
                <a><b>Связь в мессенджерах:</b></a>
                <span><a href="https://wa.me/+77779315849" target="_blank"><img src="assets/whatsapp.svg" alt=""></a>
                <a href="https://t.me/+77779315849" target="_blank"><img src="assets/telegram.svg" alt=""></a></span>
            </div>
            <div class="footer-links">
                <a><b>Контакты:</b></a>
                <a href="tel:+77779315849" target="_blank">+7 (777) 931-58-49</a>
                <a>время работы: 9:00-20:00</a>
                <a href="tel:+77779315849" target="_blank">Заказать звонок</a>
                <a>tiemirlan2004@mail.ru<br>На связи в любое время</a>
            </div>
        </div>
    </div>

    <a href="#" class="scroll-top"><i class='bx bx-chevrons-up' ></i></a>

    <script src="js/script.js"></script>
    <script src="js/search.js"></script>
    <script src="js/order.js"></script>
</body>
</html>