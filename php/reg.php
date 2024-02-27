<?php 
    include('database.php');

    function ClearData($val) {
        $val = trim($val);
        $val = stripcslashes($val);
        $val = strip_tags($val);
        $val = htmlspecialchars($val);
        return $val;
    }

    $login = ClearData($_POST['login']);
    $name = ClearData($_POST['name']);
    $email = ClearData($_POST['email']);
    $pass = ClearData($_POST['pass']);

    $pass = md5($pass."bhimiaPass");

    $check = "SELECT * FROM `user` WHERE `login` = '$login' OR `email` = '$email';";
    $request = "INSERT INTO `user` (`login`, `name`, `email`, `pass`) VALUES ('$login', '$name', '$email', '$pass');";

    $result = mysqli_query($conn, $check);
    if (mysqli_num_rows($result) == 0) {  
        mysqli_query($conn, $request);
        setcookie('user', $login, 0, "/");
        $response = array('success' => true);
        echo json_encode($response);
        
        mysqli_close($conn);
        exit();
    }  
    mysqli_close($conn);   
    $response = array('error' => "Такой пользователь уже зарегестрирован");
    echo json_encode($response);
    exit();
?>