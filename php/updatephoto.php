<?php
    include('database.php');

    $user = $_COOKIE['user'];
    $request = "SELECT * FROM `user` WHERE `login` = '$user'";
    $result = mysqli_query($conn, $request);
    $row = mysqli_fetch_assoc($result);
    if ($row['path'] != '') {
        $old_path = '../'.$row['path'];
        unlink($old_path);
    }
    

    $path = 'assets/users';
    $ext = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));

    $img_name = md5($_FILES["image"]["name"] . microtime()) . '.' . $ext;
    $file = '../'.$path.'/'.$img_name;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $file)) {
        $destination = $path . '/' . $img_name;
        $request = "UPDATE `user` SET `path` = '$destination' WHERE `user`.`login` = '$user'";
        mysqli_query($conn, $request);
        mysqli_close($conn);   
    } 
	exit();   

?>