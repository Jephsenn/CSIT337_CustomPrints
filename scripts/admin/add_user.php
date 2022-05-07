<?php
    //includes file with db connection
    require_once '../db_connect.php';

	date_default_timezone_set('America/New_York');
    
    //gets session info
    session_start();

    //takes input passed from form and assigns to variables
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$email = trim($_POST['email']);
    $pass = trim($_POST['pass']);
    $confPass = trim($_POST['confPass']);
    $phone = trim($_POST['phone']);
	$address = trim($_POST['address']);
	$city = trim($_POST['city']);
	$state = trim($_POST['state']);
	$zip = trim($_POST['zip']);
	
	//checks if all inputs have been passed
	if (!$first_name || !$last_name || !$email || !$pass || !$confPass || !$phone || !$address || !$city || !$state || !$zip) {
	    $_SESSION['registration_failed'] = 'invalid_input';
	    header('Location: ../../admin/add_user.php');
	    
	    //closes db conection
	    $db->close();
	    exit();
	}
	
	//checks if password is at least 6 characters
	else if (strlen($pass) < 6) {
	    $_SESSION['registration_failed'] = 'invalid_password';
	    header('Location: ../../admin/add_user.php');
	    
	    //closes db conection
	    $db->close();
	    exit();
	}
	
	//checks if password and confirm password inputs match
	else if ($pass != $confPass) {
	    $_SESSION['registration_failed'] = 'pwdnotmatch';
	    header('Location: ../../admin/add_user.php');
	    
	    //closes db conection
	    $db->close();
	    exit();
	}
	
    //gets id and username from current customers
    $query = 'SELECT id, email, password, cartID, phone FROM users';
	$results = $db->query($query);
	
	//gets the number of results
	$num_results = $results->num_rows;
    
    //generates a 6 digit random number for customer id
    $id = mt_rand(100000, 999999);
	$cartID = mt_rand(100000, 999999);
	
	//adds slashes for any quotes in inputs
	if(function_exists("get_magic_quotes_gpc")) {
		if (!get_magic_quotes_gpc()) {
			$first_name = addslashes($first_name);
			$last_name = addslashes($last_name);
			$email = addslashes($email);
			$pass = addslashes($pass);
			$confPass = addslashes($confPass);
			$phone = addslashes($phone);
			$address = addslashes($address);
			$zip = addslashes($zip);
		}
	}
	
	//hashes password
	$pass = password_hash($pass, PASSWORD_DEFAULT);
  
    //loops through all current users
    for ($i = 0; $i < $num_results; $i++) {
        $row = $results->fetch_assoc();
        
        //compares current ids with new ids
        if ($id == $row['id']){
            //creates a new random id if there is a match
            $id = mt_rand(100000, 999999);
            $i = 0;
        }

		//compares current cartids with new cartids
        if ($cartID == $row['cartID']){
            //creates a new random id if there is a match
            $cartID = mt_rand(100000, 999999);
            $i = 0;
        }
        
        if ($email == $row['email']) {
            //exits program is there is a match
            $_SESSION['registration_failed'] = 'emailtaken';
            header('Location: ../../admin/add_user.php');
            
            //closes db conection
            $results->free();
	        $db->close();
            exit();
        }

		if ($phone == $row['phone']) {
            //exits program is there is a match
            $_SESSION['registration_failed'] = 'phonenumbertaken';
            header('Location: ../../admin/add_user.php');
            
            //closes db conection
            $results->free();
	        $db->close();
            exit();
        }
    }
    
    //converts customer id into string
    $id = strval($id);
	$cartID = strval($cartID);

	$date_created = date('Y-m-d H:i:s');
	$date_updated = date('Y-m-d H:i:s');
	
	//creates insert query for db with user info
	$query = "INSERT INTO users VALUES
	('".$id."', '".$first_name."', '".$last_name."', '".$email."', '".$pass."', '".$date_created."', '".$date_updated."', '".$phone."', '".$address."', '".$city."', '".$state."', '".$zip."', '".$cartID."', 0)";
	
	//tries to insert user info into db
	$results = $db->query($query);
	
	//checks if insert was successful
	if ($results) {
	    $_SESSION['regdone'] = true;
	    header('Location: ../../admin/add_user.php');
	    exit();
	}
	
	//checks if some other error has occurred
	else {
	    $_SESSION['registration_failed'] = 'randerr';
	    header('Location: ../../admin/add_user.php');
	    exit();
	}
	
	//closes db connection
    $db->close();
?>