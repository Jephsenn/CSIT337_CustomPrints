<?php
    //includes file with db connection
    require_once './db_connect.php';
    
    //gets session info
    session_start();
    
    //checks if user is already logged in
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        header('Location: ../index.php');
        $_SESSION['relog'] = true;
        
        //closes db conection
	    $db->close();
        exit();
    }
    
    //takes input passed from form and assigns to variables
    $email = strtolower(trim($_POST['email']));
    $pass = trim($_POST['pass']);
    
    //informs user if not all inputs are entered and exits
    if (!$email || !$pass) {
        $_SESSION['login_failed'] = 'bad_input';
        header('Location: ../login.php');
        
        //closes db conection
	    $db->close();
        exit();
    }
    
    //queries db for username entered
    $query = "SELECT password, email, id, admin FROM users WHERE email = '".$email."'";
    $result = $db->query($query);
    $row = $result->fetch();
    
    //checks if results were returned
    if ($row['email'] == "") {
        $_SESSION['login_failed'] = 'user_DNE';
        header('Location: ../login.php');    
        //closes db conection
	    $db->close();
	    $result->free();
        exit();
    }    
    
    //compares password hashed saved with password entered; logs in and redirects to homepage if passwords match
    if (password_verify($pass, $row['password'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['cart_id'] = $row['cartId'];
        if($row['admin'] == 0){
            $_SESSION['admin'] = false;
        } else if($row['admin'] == 1){
            $_SESSION['admin'] = true;
        }
        
        $_SESSION['newlog'] = true;
        $_SESSION["login_time_stamp"] = time();
        header('Location: ../index.php');
        
        //closes db connection
        $result->free();
        $db->close();
        exit();
    }
    
    //if password is wrong, returns to login page
    else {
        $_SESSION['login_failed'] = 'wrong_password';
        header('Location: ../login.php');
        
        //closes db connection
        $result->free();
        $db->close();
        exit();
    }
?>