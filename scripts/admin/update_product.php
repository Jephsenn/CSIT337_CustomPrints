<?php
    //includes file with db connection
    require_once '../db_connect.php';

    date_default_timezone_set('America/New_York');

    //gets session info
    session_start();

    $p_id = $_POST['product_id'];
    $p_name = $_POST['product_name'];
    $p_price = $_POST['product_price'];
    $p_desc = $_POST['product_desc'];
    $p_amt_available = $_POST['product_amt_available'];
    $p_type = $_POST['product_type'];
    $date_added = date('Y-m-d H:i:s');
    $p_image_url = $_FILES['formFile']['name'];

    $query = "SELECT p_image_url FROM products WHERE p_id='$p_id'";
    $result = $db->query($query);
    $row = $result->fetch();

    if(isset($_FILES['formFile']['name']) && $_FILES['formFile']['name'] != null){
        move_uploaded_file($_FILES['formFile']['tmp_name'], "../../product_images/".$_FILES['formFile']['name']);
    } else {
        $p_image_url = $row['p_image_url'];
    } 

    $_SESSION['upload'] = $p_image_url;

    $product_query = "UPDATE products SET p_name='$p_name', p_price=$p_price, p_desc='$p_desc', p_amt_available=$p_amt_available, p_category='$p_category', p_type='$p_type', p_image_url='$p_image_url' WHERE p_id=$p_id";
    $product_results = $db->query($product_query);

    //checks if insert was successful
    if ($product_results) {
        $_SESSION['updated'] = true;
        header('Location: ../../admin/shop_admin.php');
        exit();
    }
?>