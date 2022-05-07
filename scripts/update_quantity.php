<?php
    //includes file with db connection
    require_once './db_connect.php';

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

    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    $cart_id = strval($cart_id);
    $quantity = strval($quantity);

    //queries db for username entered
    $query = "UPDATE cart SET product_quantity=$quantity WHERE cart_id=$cart_id";
    $result = $db->query($query);

    //checks if insert was successful
    if ($result) {
        $_SESSION['increaseQuantity'] = true;
        exit();
    } else {
        
        exit();
    }

?>