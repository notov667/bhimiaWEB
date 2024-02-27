<?php
    include('database.php');

    function ClearData($val) {
        $val = trim($val);
        $val = stripcslashes($val);
        $val = strip_tags($val);
        $val = htmlspecialchars($val);
        return $val;
    }

    $user_login = ClearData($_POST['login']);
    $user_pass = ClearData($_POST['pass']);

    $user_pass = md5($user_pass."bhimiaPass");

    $request = "SELECT * FROM `user` WHERE `login` = '$user_login' AND `pass` = '$user_pass'";

    $result = mysqli_query($conn, $request);

    if (mysqli_num_rows($result) == 1) {  
        
        setcookie('user', $user_login, 0, "/");

        $row = $result->fetch_assoc();
        $cart_list = $row['cart'];
        $fa_list = $row['favourites'];
        setcookie('cart_list', $cart_list, 0, "/");
        setcookie('fa_list', $fa_list, 0, "/");
        
        $response = array('success' => true);
        echo json_encode($response);

        mysqli_close($conn);
        exit();
    }  
    mysqli_close($conn);
    $response = array('error' => "Не правельные данные");
    echo json_encode($response);
    exit();
?>