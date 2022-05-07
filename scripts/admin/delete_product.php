<?php
    //includes file with db connection
    require_once '../db_connect.php';

    date_default_timezone_set('America/New_York');

    //gets session info
    session_start();

    $p_id = $_POST['p_id'];

    $query = "DELETE FROM products WHERE p_id='$p_id'";
    $result = $db->query($query);
    
    header('Location: ../../admin/shop_admin.php');
    
    //checks if insert was successful
    if ($result) {
        $_SESSION['deleted'] = "Working";
        exit();
    }
?>