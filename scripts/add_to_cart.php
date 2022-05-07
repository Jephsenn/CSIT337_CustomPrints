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

    $p_id = $_POST['p_id'];
    $p_quantity = $_POST['p_quantity'];
    $p_price = $_POST['p_price'];
    $user_id = $_SESSION['user_id'];
    $cart_id = mt_rand(100000, 999999);
	$date_added = date('Y-m-d H:i:s');
    $date_updated = date('Y-m-d H:i:s');

    $query1 = 'SELECT cart_id FROM cart';
	$results1 = $db->query($query1);
	
	//gets the number of results
	$num_results1 = $results1->num_rows;

    for ($i = 0; $i < $num_results1; $i++) {
        $row = $results1->fetch_assoc();

        //compares current cartids with new cartids
        if ($cart_id == $row['cart_id']){
            //creates a new random id if there is a match
            $cart_id = mt_rand(100000, 999999);
            $i = 0;
        }
    }

    $cart_id = strval($cart_id);

    //queries db for username entered
    $query = "INSERT INTO cart VALUES
    	('".$cart_id."', '".$user_id."', '".$p_id."', '".$p_quantity."', '".$p_price."', '".$date_added."', '".$date_updated."')";
    $result = $db->query($query);

    //checks if insert was successful
    if ($result) {
        $_SESSION['addedToCart'] = true;
        header('Location: ../cart.php');
        exit();
    }
?>