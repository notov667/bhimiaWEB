<?php
    include('database.php');

    function ClearData($val) {
        $val = trim($val); 
        $val = stripcslashes($val);
        $val = strip_tags($val);
        $val = htmlspecialchars($val);
        return $val;
    }

    $path = '../assets/products';
    $pathforsql = 'assets/products';
    $ext = strtolower(substr(strrchr($_FILES['img']['name'], '.'), 1));

    $img_name = md5($_FILES["img"]["name"] . microtime()) . '.' . $ext;
    $file = $path . '/' . $img_name;

    if (move_uploaded_file($_FILES['img']['tmp_name'], $file)) {
        $name = ClearData($_POST['title']);
        $price = ClearData($_POST['price']);
        $reduction = ClearData($_POST['reduction']);
        $category = ClearData($_POST['category']);
        $info = ClearData($_POST['info']);
        $maker = ClearData($_POST['maker']);
        $barcode = ClearData($_POST['barcode']);
        $destination = $pathforsql . '/' . $img_name;
        echo $name.'<br>';
        echo $price.'<br>';
        echo $reduction.'<br>';
        echo $category.'<br>';
        echo $info.'<br>';
        echo $maker.'<br>';
        echo $barcode.'<br>';
        echo $destination.'<br>';
    
        $request = "INSERT INTO `product` (`name`, `price`, `category`, `info`, `path`, `reduction`, `maker`, `barcode`) VALUES ('$name', '$price', '$category', '$info', '$destination', '$reduction', '$maker', '$barcode');";
        mysqli_query($conn, $request);   
        mysqli_close($conn); 
        // header('Location: ../admin.php');
        // exit();
    }
    else {
        echo "error";
    }
?>