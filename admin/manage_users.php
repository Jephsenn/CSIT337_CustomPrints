<?php
    require_once '../scripts/db_connect.php';
    session_start();

    $query = "SELECT * FROM users WHERE admin=0";
    $results = $db->query($query);
    $users = $results->fetchAll();

    $admin_query = "SELECT * FROM users WHERE admin=1";
    $admin_results = $db->query($admin_query);
    $admins = $admin_results->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="theme-color" content="#000000" />
        <meta
            name="description"
            content="Website to sell apparel"
        />
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/styles.scss">
        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/d52da0a142.js" crossorigin="anonymous"></script>
        <script   src="https://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>
        <title>Custom Prints</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
          <div class="container-fluid ms-5 me-5">
            <a class="navbar-brand" href="../index.php">Custom Prints</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
              <ul class="navbar-nav me-auto">
                <li class="nav-item">
                  <a class="nav-link" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../shop.php">Shop</a>
                </li>
                <li class="nav-item">
                  <?php
                    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
                      echo "<a class='nav-link' href='../scripts/logout_confirm.php'>Logout</a>";
                    } else {
                      echo "<a class='nav-link' href='../login.php'>Login</a>";
                    }
                  ?>
                </li>
              </ul>
              <?php
                if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
                    echo "<a class='userIcon fa-solid fa-cart-shopping me-1 ms-1' href='../cart.php'></a>";
                    echo "<a class='userIcon fa-solid fa-user ms-3 me-3' href='../account.php'></a>";
                }
              ?>
              <form class="d-flex">
                <input class="form-control me-2" type="text" placeholder="Search">
                <button class="btn btn-primary" type="button">Search</button>
              </form>
            </div>
          </div>
        </nav>
        <div class="shopContent">
            <div style="overflow:auto; height:93.3vh; padding-bottom:2rem">
                <button onclick="window.location.href='./add_user.php'" type="button" class="add_user_button btn-primary btn-lg">+ Add user</button>
                <h1 style="margin: 1rem 5%">Normal users:</h1>
                <?php
                    foreach($users as $row){
                        echo '<a class="user_entry" href="./edit_user.php?id='.$row['id'].'">';
                        echo '<div class="user_entry_container">';
                        echo '<h1>User ID:</h1>';
                        echo '<p>'.$row['id'].'</p>';
                        echo '</div>';
                        echo '<div class="user_entry_container">';
                        echo '<h1>First Name:</h1>';
                        echo '<p>'.$row['first_name'].'</p>';
                        echo '</div>';
                        echo '<div class="user_entry_container">';
                        echo '<h1>Last Name:</h1>';
                        echo '<p>'.$row['last_name'].'</p>';
                        echo '</div>';
                        echo '<div class="user_entry_container">';
                        echo '<h1>Email:</h1>';
                        echo '<p>'.$row['email'].'</p>';
                        echo '</div>';
                        echo '</a>';
                    }
                ?>
                <hr style="width:95%; margin:1rem auto"/>
                <h1 style="margin: 1rem 5%">Admins:</h1>
                <?php
                    foreach($admins as $admin_row){
                        echo '<a class="user_entry" href="./edit_user.php?id='.$admin_row['id'].'">';
                        echo '<div class="user_entry_container">';
                        echo '<h1>User ID:</h1>';
                        echo '<p>'.$admin_row['id'].'</p>';
                        echo '</div>';
                        echo '<div class="user_entry_container">';
                        echo '<h1>First Name:</h1>';
                        echo '<p>'.$admin_row['first_name'].'</p>';
                        echo '</div>';
                        echo '<div class="user_entry_container">';
                        echo '<h1>Last Name:</h1>';
                        echo '<p>'.$admin_row['last_name'].'</p>';
                        echo '</div>';
                        echo '<div class="user_entry_container">';
                        echo '<h1>Email:</h1>';
                        echo '<p>'.$admin_row['email'].'</p>';
                        echo '</div>';
                        echo '</div>';
                        $row = $results->fetch_assoc();
                    }
                ?>
            </div>
        </div>
    </body>
</html>