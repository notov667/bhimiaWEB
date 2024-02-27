<?php
    include('database.php');

    function ClearData($val) {
        $val = trim($val);
        $val = stripcslashes($val);
        $val = strip_tags($val);
        $val = htmlspecialchars($val);
        return $val;
    }

    $old_pass = ClearData($_POST['oldpass']);
    $new_pass = ClearData($_POST['newpass']);

    $old_pass = md5($old_pass."bhimiaPass");

    $user = $_COOKIE['user'];
    $request = "SELECT * FROM `user` WHERE `login` = '$user' AND `pass` = '$old_pass'";
    $result = mysqli_query($conn, $request);

    if (mysqli_num_rows($result) == 1) {  
        $new_pass = md5($new_pass."bhimiaPass");
        
        $request = "UPDATE `user` SET `pass` = '$new_pass' WHERE `user`.`login` = '$user'";
        mysqli_query($conn, $request);

        $response = array('success' => true);
        echo json_encode($response);

        mysqli_close($conn);
        exit();
    }  
    mysqli_close($conn);
    $response = array('error' => "Incorrect data");
    echo json_encode($response);
    exit();
?>