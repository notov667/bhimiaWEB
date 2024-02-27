<?php
    include('php/database.php');
    $total_cost = $_COOKIE['total_cost']; 
    if ($total_cost == '') {
        $total_cost = 0;
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
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/catalog.css">
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

        <div class="products-container container">
            <h2><span>Каталог</span> товаров</h2>
            <div class="products-wrapper">
                <?php 
                    if($product = mysqli_query($conn, "SELECT * FROM `product` ORDER BY `product`.`name` ASC;")){
                        $search_query = isset($_GET['id']) ? $_GET['id'] : '';
                        foreach($product as $row){
                            if (empty($search_query) || stripos($row['name'], $search_query) !== false || stripos($row['category'], $search_query) !== false) {
                            
                                echo '<div class="products-content" onclick="productBtn(this)" data-href="product.php?id='.$row['id'].'">';
                                if ($row['reduction'] != 0) {
                                    echo '<span>'.$row['reduction'].'%</span>';
                                    $price = $row['price'] * (1-$row['reduction']/100);
                                }
                                else {
                                    $price = $row['price'];
                                }
                                echo '<div class="products-image _square"><img src="'.$row['path'].'" alt=""></div>';
                                echo '<div class="products-text">';
                                echo '<div class="title">'.$row['name'].'</div>';
                                echo '<div class="info">';
                                echo '<p>Производитель: '.$row['maker'].'</p>';
                                echo '<p>Категория: '.$row['category'].'</p>';
                                echo '<p>Штрихкод: '.$row['barcode'].'</p></div>';
                                echo '<div class="price"><b>'.$price.' ₸</b>';
                                echo '<button data-count="1" data-id="'.$row['id'].'">В корзину<i class="bx bx-cart"></i></button>';
                                echo '</div></div></div>';
                            }
                        }
                    }
                ?>
            </div>
            <h2><span>Категории</span> товаров</h2>
            <p>10 000+ ходовых позиций по спецмальным ценам</p>
            <div class="products-categories">
                <div class="products-categories-content" onclick="categoryBtn(this)">
                    <div class="products-categories-image _square"><img src="assets/categories/image.png" alt=""></div>
                    <div class="products-categories-text">Бытовая химия</div>
                </div>
                <div class="products-categories-content" onclick="categoryBtn(this)">
                    <div class="products-categories-image _square"><img src="assets/categories/image-1.png" alt=""></div>
                    <div class="products-categories-text">Косметика и гигиена</div>
                </div>
                <div class="products-categories-content" onclick="categoryBtn(this)">
                    <div class="products-categories-image _square"><img src="assets/categories/image-2.png" alt=""></div>
                    <div class="products-categories-text">Товары для дома</div>
                </div>
                <div class="products-categories-content" onclick="categoryBtn(this)">
                    <div class="products-categories-image _square"><img src="assets/categories/image-3.png" alt=""></div>
                    <div class="products-categories-text">Товары для детей и мам</div>
                </div>
                <div class="products-categories-content" onclick="categoryBtn(this)">
                    <div class="products-categories-image _square"><img src="assets/categories/image-4.png" alt=""></div>
                    <div class="products-categories-text">Посуда</div>
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
</body>
</html>