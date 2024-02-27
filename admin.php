<?php
    include('php/database.php');
    $user = $_COOKIE['user'];

    $admin = mysqli_query($conn, "SELECT * FROM `user` WHERE `login` = '$user';");
    $is_admin = $admin->fetch_assoc();

    if ($is_admin['admin'] != '1') {
        header('Location: /');
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/product.css">
</head>
<body>
    <div class="form-container">
    	<div class="form-wrapper">
	        <form action="php/addadmin.php" method="post">
                <h2>Дать/убрать админку</h2>
                <label>Логин пользователя
                    <select name="login">
                        <?php 
                            if ($user = mysqli_query($conn, "SELECT * FROM `user` ORDER BY `user`.`login` ASC;")) {
                                foreach($user as $row) {
                                    echo '<option value="' . $row['login'] . '">' . $row['login'] . '</option>';
                                }
                            }
                        ?>
                    </select>
                </label>
                <label class="radio_label"><input type="radio" name="admin" value="0" checked>Убрать</label>
                <label class="radio_label"><input type="radio" name="admin" value="1">Дать</label>
                <button type="submit">Сохранить</button>
	        </form>
	        <form action="php/deluser.php" method="post">
                <h2>Удалить пользователя</h2>
                <label>Логин
                    <select name="login">
                        <?php 
                            if ($user = mysqli_query($conn, "SELECT * FROM `user` ORDER BY `user`.`login` ASC;")) {
                                foreach($user as $row) {
                                    echo '<option value="' . $row['login'] . '">' . $row['login'] . '</option>';
                                }
                            }
                        ?>
                    </select>
                </label>
                <button type="submit">Удалить</button>
	        </form>
        </div>
    	<form action="php/addproduct.php" method="post" enctype="multipart/form-data">
            <h2>Добавить товар</h2>
            <div class="product-wrapper">
                <div class="product-img"><img class="img_preview" src="assets/test.png" alt=""><span><input type="number" name="reduction" placeholder="скидка..." value="0"></span></div>
                <div class="product-content">
                    <div class="product-available _green">В наличии</div>
                    <input type="file" name="img" onchange="imageInput(this)" value="1" required>
                    <div class="product-title"><input type="text" name="title" placeholder="название..." required></div>
                    <div class="product-price">
                        <b><span id="product_cost"><input type="number" name="price" min="0" placeholder="цена..." required></span> ₸</b>
                    </div>
                    <div class="product-cards">
                        <a><i class='bx bxs-share-alt'></i></a>
                        <a><p>При покупке от 10 000 ₸ бесплатная доставка по Алмате и области</p></a>
                    </div>
                    <p><span>Производитель:</span><b><input type="text" name="maker" placeholder="BioMio..." required></b></p>
                    <p><span>Категория:</span><b>
                        <select name="category">
                            <!-- <option id="oldtype" selected></option> -->
                            <option selected>Бытовая химия</option>
                            <option>Косметика и гигиена</option>
                            <option>Товары для дома</option>
                            <option>Товары для детей и мам</option>
                            <option>Посуда</option>
                        </select></b></p>
                    <p><span>Штрихкод:</span><b><input type="number" name="barcode" placeholder="4604049097548..." required></b></p>
                    <span>Описание</span>
                    <p><span><textarea type="text" name="info" placeholder="описание..." required></textarea></span></p>
                    <button type="submit">Создать</button>
                </div>
            </div>
        </form>
    	<div class="form-wrapper">
	        <form action="php/delproduct.php" method="post">
                <h2>Удалить товар</h2>
                <label>товар
                    <select name="name">
                        <?php 
                            if ($products = mysqli_query($conn, "SELECT * FROM `product` ORDER BY `product`.`name` ASC;")) {
                                foreach($products as $row) {
                                    echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                                }
                            }
                        ?>
                    </select>
                </label>
                <button type="submit">Удалить</button>
	        </form>
        </div>
    </div>
    <script src="js/admin.js"></script>
</body>
</html>