<?php
    //includes file with db connection
    require_once './db_connect.php';
    
    //gets session info
    session_start();
    $user_id = $_SESSION['user_id'];
    //takes input passed from form and assigns to variables
    $currPassword= trim($_POST['currPassword']);
    $newPassword = trim($_POST['newPassword']);
    $confPassword = trim($_POST['confPassword']);

    $query = "SELECT * FROM users WHERE id = '$user_id'";
    //gets info from db
    $results = $db->query($query);
    $row = $results->fetch();
	$cpass = $row['password'];
	
    if (!$currPassword || !$newPassword || !$confPassword) {
	    $_SESSION['passwordChange_failed'] = 'invalid_input';
	    header('Location: ../account.php');
	    
	    //closes db conection
	    $db->close();
	    exit();
	}
	//checks if password is at least 6 characters
	else if (strlen($newPassword) < 6) {
	    $_SESSION['passwordChange_failed'] = 'pass_short';
	    header('Location: ../account.php');
	    
	    //closes db conection
	    $db->close();
	    exit();
	}
	else if (!password_verify($currPassword, $cpass)) {
	    $_SESSION['passwordChange_failed'] = 'pwdnotmatch';
	    header('Location: ../account.php');
	    
	    //closes db conection
	    $db->close();
	    exit();
	}
	else if ($newPassword != $confPassword) {
	    $_SESSION['passwordChange_failed'] = 'newpwdnotmatch';
	    header('Location: ../account.php');
	    
	    //closes db conection
	    $db->close();
	    exit();
	}
	
	//adds slashes for any quotes in inputs
    if(function_exists("get_magic_quotes_gpc")) {
        if (!get_magic_quotes_gpc()) {
            $newPassword = addslashes($newPassword);
        }
    }
	
	//hashes password
	$newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
	
	$sql = "UPDATE users SET password='$newPassword' WHERE id='$user_id'";
	if ($db->query($sql) == TRUE) {
	    $_SESSION['passwordChange_success'] = 'pass_changed';
	    header('Location: ../account.php');
	}
	else{
      $_SESSION['passwordChange_failed'] = 'updateERR';
	    header('Location: ../account.php');
	    //closes db conection
	    $db->close();
	    exit();
    }
    header('Location: ../account.php');
	//closes db connection
    $db->close();
    exit();
?>