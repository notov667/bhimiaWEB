<?php
    include('php/database.php');

    $user = $_COOKIE['user'];
    $request = "SELECT * FROM `user` WHERE `login` = '$user'";
    $result = mysqli_query($conn, $request);
    foreach ($result as $row) {
        $user_name = $row['name'];
        $user_email = $row['email'];
        $user_img = $row['path'];
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
    
    // Получение количества определенного продукта в корзине
    function getProductQuantityFromCart($productName) {
        if (isset($_COOKIE['cart'])) {
            $cart = json_decode($_COOKIE['cart'], true);
            foreach ($cart as $productId => $quantity) {
                if ($productId == $productName) {
                    return $quantity;
                }
            }
        }
        return 0;
    }
    $total_cost = 0; 
    if ($product = mysqli_query($conn, "SELECT * FROM `product` ORDER BY `product`.`name` ASC;")) {
        $cart = getCartFromCookies(); // Получаем информацию о корзине из кукисов
        foreach ($product as $row) {
            if (in_array($row['id'], $cart)) {

                if ($row['reduction'] != 0) {
                    $price = $row['price'] * (1 - $row['reduction'] / 100);
                } else {
                    $price = $row['price'];
                }
                $count = getProductQuantityFromCart($row['id']);
                $total_cost = $total_cost + $price * $count;
                setcookie('total_cost', $total_cost, 0, "/");
            
            }
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
    <link rel="stylesheet" href="css/cart.css">
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
            <div class="user-wrapper">
            	<div class="user-backbtn bx bx-arrow-back" onclick="homeBtn()"></div>
                <div class="user-data">
                    <div class="user-img bx bx-user">
                        <?php if($user_img != ''): ?>
                        <img src="<?= $user_img ?>" alt="">
                        <?php else: ?>
                        <img style="display: none;" src="" alt="">
                        <?php endif; ?>
                        <form method="post"><label><input type="file" name="image" onchange="imageInput(this)"></label></form>
                    </div>
                    <h2><?=$user_name?></h2>
                    <text><p><a>Login:</a><a><b><?=$user?></b></a></p>
                    <p><a>email:</a><a><b><?=$user_email?></b></a></p></text>
                    <button onclick="logoutBtn()">Выйти</button>
                </div>
                <div class="user-pass">
                    <h3>Update password</h3>
                    <form id="updatepass" action="php/updatepass.php" method="post">
                        <div class="input-field">
                            <input type="password" class="_pass _req" name="oldpass" placeholder="Old password">
                            <i class='bx bx-lock-alt'></i>
                        </div>
            
                        <div class="input-field">
                            <input type="password" class="_pass _req" name="newpass" placeholder="New password">
                            <i class='bx bx-lock-alt'></i>
                        </div>
            
                        <div id="error-message" style="opacity: 0;">error</div>
            
                        <div class="input-field">
                            <input type="submit" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="cart-wrapper">
                <h2>Корзина</h2>
                <div class="products-wrapper">
                    <?php 
                    
                        if ($product = mysqli_query($conn, "SELECT * FROM `product` ORDER BY `product`.`name` ASC;")) {
                            $cart = getCartFromCookies(); // Получаем информацию о корзине из кукисов
                            foreach ($product as $row) {
                                if (in_array($row['id'], $cart)) {

                                    echo '<div class="products-content _cart" data-href="product.php?id=' . $row['id'] . '">';
                                    echo '<div class="products-image _square"><img src="' . $row['path'] . '" alt="">';
                                    if ($row['reduction'] != 0) {
                                        echo '<span>' . $row['reduction'] . '%</span>';
                                        $price = $row['price'] * (1 - $row['reduction'] / 100);
                                    } else {
                                        $price = $row['price'];
                                    }

                                    $count = getProductQuantityFromCart($row['id']);

                                    echo '</div><div class="products-text">';
                                    echo '<div class="title">' . $row['name'].'</div>';
                                    echo '<p>' . $row['info'] . '</p></div>';
                                    echo '<div class="price"><b>' . $price . ' ₸</b>';
                                    echo '<div class="product-count"><span onclick="minusBtn(this)" data-id="' . $row['id'] . '"></span><a ';
                                    echo 'id="product_count">'.$count.'</a><span onclick="plusBtn(this)" data-id="' . $row['id'] . '"></span></div>';
                                    echo '<button onclick="delCart(this)" data-id="' . $row['id'] . '"><i class="bx bxs-trash"></i></button>';
                                    echo '</div></div>';
                                }
                            }
                        }
                    ?>
                </div>
                <div class="cart-price">
                    <button onclick="orderBtn()">Оформить заказ</button>
                    <b><?=$total_cost?> ₸</b>
                </div>
            </div>
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
    <script src="js/cart.js"></script>
</body>
</html>