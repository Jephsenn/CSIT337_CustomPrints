<?php
    //includes file with db connection
    require_once '../db_connect.php';

    date_default_timezone_set('America/New_York');

    //gets session info
    session_start();

    $user_id = $_POST['user_id'];

    $query = "DELETE FROM users WHERE id='$user_id'";
    $result = $db->query($query);
    
    header('Location: ../../admin/manage_users.php');
    
    //checks if insert was successful
    if ($result) {
        $_SESSION['deleted'] = "Working";
        exit();
    }
?>