<?php
    //includes file with db connection
    require_once '../db_connect.php';

    date_default_timezone_set('America/New_York');

    //gets session info
    session_start();

    $p_id = mt_rand(100000, 999999);
    $p_name = $_POST['product_name'];
    $p_price = $_POST['product_price'];
    $p_desc = $_POST['product_desc'];
    $p_amt_available = $_POST['product_amt_available'];
    $p_category = $_POST['product_category'];
    $p_type = $_POST['product_type'];
    $date_added = date('Y-m-d H:i:s');
    $p_image_url = $_FILES['formFile']['name'];

    move_uploaded_file($_FILES['formFile']['tmp_name'], "../../product_images/".$_FILES['formFile']['name']);
    
    $product_query = "SELECT p_id FROM products";
    $product_results = $db->query($product_query);
    $product_count = $product_results->num_rows;

    for ($i = 0; $i < $product_count; $i++) {
        $row = $product_results->fetch_assoc();

        //compares current ids with new ids
        if ($p_id == $row['p_id']){
            //creates a new random id if there is a match
            $p_id = mt_rand(100000, 999999);
            $i = 0;
        }
    }

    //queries db for username entered
    $query = "INSERT INTO products (p_id, p_name, p_price, p_desc, p_amt_available, p_category, p_type, date_added, p_image_url) VALUES
    	('".$p_id."', '".$p_name."', '".$p_price."', '".$p_desc."', '".$p_amt_available."', '".$p_category."', '".$p_type."', '".$date_added."', '".$p_image_url."')";
    $result = $db->query($query);

    //checks if insert was successful
    if ($result) {
        $_SESSION['addedToCart'] = true;
        header('Location: ../../admin/shop_admin.php');
        exit();
    }
?>