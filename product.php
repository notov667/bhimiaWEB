<?php
	include('php/database.php');
    $total_cost = $_COOKIE['total_cost']; 
    if ($total_cost == '') {
        $total_cost = 0;
    }
    
	if(isset($_GET["id"])) {
		$product_id = mysqli_real_escape_string($conn, $_GET["id"]);
	    if($products = mysqli_query($conn, "SELECT * FROM `product` WHERE `id` = '$product_id';")){
	        foreach($products as $row){
				$product_name = $row['name'];
				$product_available = $row['available'];
				$product_img = $row['path'];
				$product_info = $row['info'];
				$product_category = $row['category'];
				$product_maker = $row['maker'];
				$product_barcode = $row['barcode'];
				$product_reduction = $row['reduction'];
				$product_price = $row['price'];

                if ($product_reduction != 0 || $product_reduction != NULL) {
                    $product_price = $product_price - ($product_price * $product_reduction / 100);
                }
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
    <link rel="stylesheet" href="css/product.css">
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
            <div class="product-wrapper">
                <div class="product-img"><img src="<?=$product_img?>" alt="">
                    <?php if($product_reduction != 0): ?>
                        <span><?=$product_reduction?>%</span>
                    <?php endif; ?></div>
                <div class="product-content">
                    <?php if($product_available == '0'): ?>
                        <div class="product-available _gray">Нет в наличии</div>
                    <?php else: ?>
                        <div class="product-available _green">В наличии</div>
                    <?php endif; ?>
                    <div class="product-title"><?=$product_name?></div>
                    <div class="product-price">
                        <b><span id="product_cost"><?=$product_price?></span> ₸</b>
                        <div class="product-count"><span onclick="minusBtn()"></span><a id="product_count">1</a><span onclick="plusBtn()"></span></div>
                        <button onclick="addCart(this)" id="product_btn" data-count="1" data-id="<?=$product_id?>">В корзину<i class='bx bx-cart'></i></button>
                    </div>
                    <div class="product-cards">
                        <a><i class='bx bxs-share-alt'></i></a>
                        <a><p>При покупке от 10 000 ₸ бесплатная доставка по Алмате и области</p></a>
                    </div>
                    <p><span>Производитель:</span><b><?=$product_maker?></b></p>
                    <p><span>Категория:</span><b><?=$product_category?></b></p>
                    <p><span>Штрихкод:</span><b><?=$product_barcode?></b></p>
                    <span>Описание</span>
                    <p><span><?=$product_info?></span></p>
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
    <script src="js/product.js"></script>
</body>
</html>