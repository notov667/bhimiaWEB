<?php
    include('database.php');

    function ClearData($val) {
        $val = trim($val);
        $val = stripcslashes($val);
        $val = strip_tags($val);
        $val = htmlspecialchars($val);
        return $val;
    }
    $name = ClearData($_POST['name']);

    $product = mysqli_query($conn, "SELECT `path` FROM `category` WHERE `name` = '$name'");
    $row = $product->fetch_assoc();
    $product_path = '../'.$row['path'];
    unlink($product_path);


    mysqli_query($conn, "DELETE FROM `menu` WHERE `category`.`name` = '$name';");
    mysqli_close($conn);    
    header('Location: ../admin.php');
    exit();
    
?>