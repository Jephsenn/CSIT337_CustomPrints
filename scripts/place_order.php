<?php
    //includes file with db connection
    require_once './db_connect.php';

    date_default_timezone_set('America/New_York');

    //gets session info
    session_start();

    //checks if user is not logged in
    if (!isset($_SESSION['loggedin'])) {
        header('Location: ./index.php');
        $_SESSION['relog'] = true;
        
        //closes db conection
	    $db->close();
        exit();
    }

    $order_id = mt_rand(100000, 999999);
    $user_id = $_SESSION['user_id'];
    $order_f_name = trim($_POST['first_name']);
    $order_l_name = trim($_POST['last_name']);
    $order_email = trim($_POST['email']);
    $order_addr = trim($_POST['address']);
    $order_city = trim($_POST['city']);
    $order_state = trim($_POST['state']);
    $order_zip = trim($_POST['zip']);
    $order_total = number_format(floatval(substr(trim($_POST['total']), 1)), 2);
    $cart_ids = trim($_POST['cart_ids']);
    $order_date = date('Y-m-d H:i:s');

    $cart_query = "SELECT * FROM cart WHERE user_id='".$user_id."'";
    $cart_results = $db->query($cart_query);
    $cart = $cart_results->fetchAll();

    foreach($cart as $row){
        $product_query = "SELECT * FROM products WHERE p_id=".$row['product_id']."";
        $product_results = $db->query($product_query);
        $product_row = $product_results->fetch();
        if($product_row['p_amt_available'] < $row['product_quantity']){
            $_SESSION['orderQuantity'] = $product_row['p_name']." count too high! Amount available: ".$product_row['p_amt_available'];
            header('Location: ../cart.php');
            $db->close();
            exit();
        }
        $totalSold = $product_row['p_amt_sold'] += $row['product_quantity'];
        $amt_available = $product_row['p_amt_available'] - $row['product_quantity'];
        $update_query = "UPDATE products SET p_amt_available=$amt_available, p_amt_sold=$totalSold WHERE p_id=".$row['product_id']."";
        $update_results = $db->query($update_query);
        $row = $cart_results->fetch();
    }

    $order_query = "INSERT INTO orders VALUES
            ('".$order_id."', '".$user_id."','".$order_f_name."','".$order_l_name."','".$order_email."','".$order_addr."','".$order_city."','".$order_state."','".$order_zip."','".$order_total."','".$cart_ids."', '".$order_date."')";
    $order_result = $db->query($order_query);

    $cart_query = "SELECT * FROM cart WHERE user_id='".$user_id."'";
    $cart_results = $db->query($cart_query);
    $row = $cart_results->fetchAll();
    
    foreach($cart as $row){
        $cart_complete_query = "INSERT INTO cart_complete VALUES
                        ('".$row['cart_id']."', '".$row['user_id']."','".$row['product_id']."','".$row['product_quantity']."','".$row['product_price']."','".$row['date_added']."','".$row['date_updated']."')";
        $cart_complete_results = $db->query($cart_complete_query);

        $cart_delete_query = "DELETE FROM cart WHERE cart_id='".$row['cart_id']."'";
        $cart_complete_delete = $db->query($cart_delete_query);
        $row = $cart_results->fetch();
    }

    //checks if insert was successful
    if ($order_result) {
        $_SESSION['orderPlaced'] = "Order placed successfully! Your order id is: ".$order_id;
        header('Location: ../cart.php');
        exit();
    }

?>