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
    $admin = ClearData($_POST['admin']);

    mysqli_query($conn, "UPDATE `user` SET `admin` = '$admin' WHERE `user`.`login` = '$login';");
    mysqli_close($conn);    
    header('Location: ../admin.php');
    exit();
    
?>