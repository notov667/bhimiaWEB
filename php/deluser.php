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

    mysqli_query($conn, "DELETE FROM `user` WHERE `user`.`login` = '$login';");
    mysqli_close($conn);    
    header('Location: ../admin.php');
    exit();
    
?>