<?php
    //includes file with db connection
    require_once '../db_connect.php';

    date_default_timezone_set('America/New_York');

    //gets session info
    session_start();

    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];

    $query = "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email', address='$address', city='$city', state='$state', zip='$zip' WHERE id='$user_id'";
    $result = $db->query($query);

    //checks if insert was successful
    if ($result) {
        $_SESSION['updated'] = true;
        header('Location: ../../admin/manage_users.php');
        exit();
    }
?>