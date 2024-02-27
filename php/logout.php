<?php 
    setcookie('user', '', 0, "/");
    setcookie('cart', '', 0, "/");
    setcookie('total_cost', '', 0, "/");

    header('Location: /');
?>