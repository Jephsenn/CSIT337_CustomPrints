<?php
    //includes file with db connection
    require_once './scripts/db_connect.php';
   
    session_start();

    $notice='';
    $notice2='';

    if (isset($_SESSION['passwordChange_failed']) && $_SESSION['passwordChange_failed'] == 'pwdnotmatch') {
      $notice = 'Old Password is incorrect.';
      
      $_SESSION['passwordChange_failed'] = '';
    }
    
    else if (isset($_SESSION['passwordChange_failed']) && $_SESSION['passwordChange_failed'] == 'updateERR') {
        $notice = 'There was an error please try again.';
        
        $_SESSION['passwordChange_failed'] = '';
    }
    
    else if (isset($_SESSION['passwordChange_failed']) && $_SESSION['passwordChange_failed'] == 'pass_short') {
        $notice = 'The new password needs to be at least 6 characters.';
        
        $_SESSION['passwordChange_failed'] = '';
    }
    
    else if (isset($_SESSION['passwordChange_failed']) && $_SESSION['passwordChange_failed'] == 'newpwdnotmatch') {
        $notice = 'The new passwords did not match.';
        
        $_SESSION['passwordChange_failed'] = '';
    }
    
    else if (isset($_SESSION['passwordChange_failed']) && $_SESSION['passwordChange_failed'] == 'invalid_input') {
        $notice = 'Invalid input.';
        
        $_SESSION['passwordChange_failed'] = '';
    }
    
    else if (isset($_SESSION['passwordChange_success']) && $_SESSION['passwordChange_success'] == 'pass_changed') {
        $notice2 = 'SUCCESS!';
        
        $_SESSION['passwordChange_success'] = '';
    }

    //checks if user is not logged in
    if (!isset($_SESSION['loggedin'])) {
      header('Location: ./index.php');
      $_SESSION['relog'] = true;
      
      //closes db conection
      $db->close();
      exit();
    }

    $query = "SELECT * FROM USERS WHERE id = ".$_SESSION['user_id']."";
    $result = $db->query($query);
        
    //gets associative array from result
    $row = $result->fetch();

    $order_query = "SELECT * FROM orders WHERE user_id='".$_SESSION['user_id']."' ORDER BY order_date DESC";
    $order_result = $db->query($order_query);
    $order = $order_result->fetchAll();
    
    //checks if results were returned
    if (count($row) == 0) {
        $_SESSION['login_failed'] = 'user_DNE';
        header('Location: ../login.php');
        
        //closes db conection
	    $db->close();
	    $result->free();
        exit();
    }

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
        <link rel="stylesheet" href="./css/styles.css">
        <link rel="stylesheet" href="./css/styles.scss">
        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/d52da0a142.js" crossorigin="anonymous"></script>
        <title>Custom Prints</title>
    </head>
    <body style="overflow:auto">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
          <div class="container-fluid ms-5 me-5">
            <a class="navbar-brand" href="./index.php">Custom Prints</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
              <ul class="navbar-nav me-auto">
                <li class="nav-item">
                  <a class="nav-link" href="./index.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./shop.php">Shop</a>
                </li>
                <li class="nav-item">
                  <?php
                    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
                      echo "<a class='nav-link' href='./scripts/logout_confirm.php'>Logout</a>";
                    } else {
                      echo "<a class='nav-link' href='./login.php'>Login</a>";
                    }
                  ?>
                </li>
              </ul>
              <?php
                if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
                  echo "<a class='userIcon fa-solid fa-cart-shopping me-1 ms-1' href='./cart.php'></a>";
                  echo "<a class='userIcon active fa-solid fa-user ms-3 me-3' href='./account.php'></a>";
              }
              ?>
              <form class="d-flex" action="./search.php" method="post">
                <input name="search" id="search" class="form-control me-2" type="text" placeholder="Search">
                <button class="btn btn-primary" type="submit">Search</button>
              </form>
            </div>
          </div>
        </nav>
        <?php
          if(isset($_SESSION['admin']) && $_SESSION['admin'] == true){
            echo '<div class="account_content">';
            echo '<div class="account_header_container">';
            echo '<p class="account_content_header">Admin Dashboard:</p>';
            echo '</div>';
            echo '<div class="admin_content_container">';
            echo '<a href="./admin/shop_admin.php" class="admin_button btn-lg btn-primary">Manage products</a>';
            echo '<a href="./admin/manage_users.php" class="admin_button btn-lg btn-primary">Manage accounts</a>';
            echo '</div>';
            echo '</div>';
          }
        ?>
        <div class="account_content">
          <div class="account_header_container">
            <p class="account_content_header">Basic Info:</p>
          </div>
          <div class="account_content_container">
            <div class="account_content_item">
              <div class="account_content_item_header">
                <p class="account_content_info_header">First name:</p>
              </div>
              <p class="account_content_info"><?php echo $row['first_name'] ?></p>
            </div>
            <div class="account_content_item">
              <div class="account_content_item_header">
                <p class="account_content_info_header">Last name:</p>
              </div>
              <p class="account_content_info"><?php echo $row['last_name'] ?></p>
            </div>
            <div class="account_content_item">
              <div class="account_content_item_header">
                <p class="account_content_info_header">Email:</p>
              </div>
              <p class="account_content_info"><?php echo $row['email'] ?></p>
            </div>
          </div>
          <hr/>
          <div class="account_header_container">
            <p class="account_content_header">Secure Info: </p>
            <p class="account_content_header" style='color: red; margin-left:1rem'><?php echo $notice; ?></p>
            <p class="account_content_header" style='color: green; margin-left:1rem'><?php echo $notice2; ?></p>
          </div>
          <div class="account_content_container">
            <div class="account_content_item">
              <div class="account_content_item_header">
                <p class="account_content_info_header">Password:</p>
                <i onClick="edit_password()" class="edit_icon fa-solid fa-pen-to-square"></i>
                <i style="display:none" onClick="cancel_edit()" class="cancel_icon fa-solid fa-square-xmark"></i>
              </div>
              <p class="account_content_info">**************</p>
              <form class="change_password" id="change_password" style="display:none" action='./scripts/change_password.php' method='post'>
                <div class="form-outline mb-2">
                  <input type="password" id="currPassword" name="currPassword" class="form-control" onChange="onChange()" placeholder="Current Password"/>
                </div>
                <div class="form-outline mb-2">
                  <input type="password" id="newPassword" name="newPassword" class="form-control" onChange="onChange()" placeholder="New Password"/>
                </div> 
                <div class="form-outline mb-2">
                  <input type="password" id="confPassword" name="confPassword" class="form-control" onChange="onChange()" placeholder="Confirm Password"/>
                </div>     
                <button type="submit" style="display:none" class="confirm_button btn-primary">Confirm</button>             
              </form>
            </div>
          </div>
          <hr/>
          <div class="account_header_container">
            <p class="account_content_header">Personal Info:</p>
          </div>
          <div class="account_content_container">
            <div class="account_content_item">
              <p class="account_content_info_header">Address:</p>
              <p class="account_content_info"><?php echo $row['address'] ?></p>
            </div>
            <div class="account_content_item">
              <p class="account_content_info_header">City:</p>
              <p class="account_content_info"><?php echo $row['city'] ?></p>
            </div>
            <div class="account_content_item">
              <p class="account_content_info_header">State:</p>
              <p class="account_content_info"><?php echo $row['state'] ?></p>
            </div>
            <div class="account_content_item">
              <p class="account_content_info_header">Zip:</p>
              <p class="account_content_info"><?php echo $row['zip'] ?></p>
            </div>   
          </div>
        </div>
        <div class="account_content">
          <div class="account_header_container">
            <p class="account_content_header">Order History:</p>
          </div>
          <div style="flex-wrap:wrap" class="order_content_container_main">
          <?php
            if(count($order) == 0){
              echo '<div style="width: 100%" class="order_item">';
              echo '<div class="account_content_item_header">';
              echo '<p class="account_content_info_header">No orders placed yet</p>';
              echo '</div>';
              echo '</div>';
            } else {         
                foreach($order as $order_row){              
                  echo '<a style="width:30%"class="order_item" href="./order.php?id='.$order_row['order_id'].'">';
                  echo '<div class="account_content_item_header">';
                  echo '<p class="account_content_info_header">Order ID: </p>';
                  echo '<p class="account_content_info">'.$order_row['order_id'].'</p>';
                  echo '</div>';
                  echo '<div class="account_content_item_header">';
                  echo '<p class="account_content_info_header">Order Total: </p>';
                  echo '<p class="account_content_info">$'.$order_row['total'].'</p>';
                  echo '</div>';
                  echo '<div class="account_content_item_header">';
                  echo '<p class="account_content_info_header">Order Date: </p>';
                  echo '<p class="account_content_info">'.$order_row['order_date'].'</p>';
                  echo '</div>';
                  echo '</a>';
                }
            }

          ?>
          </div>
        </div>



        <script>
          function onChange() {
            const password = document.querySelector('input[name=newpass]');
            const confirm = document.querySelector('input[name=connewpass]');
            if (confirm.value === password.value) {
                confirm.setCustomValidity('');
            } else {
                confirm.setCustomValidity('Passwords do not match');
            }
          }

          function edit_password(){
            let fields = document.getElementsByClassName('account_content_info');
            let form = document.getElementById('change_password');
            let edit_icon = document.getElementsByClassName('edit_icon');
            let confirm_button = document.getElementsByClassName('confirm_button');
            let cancel_icon = document.getElementsByClassName('cancel_icon');
            cancel_icon[0].style.display="block";
            confirm_button[0].style.display="block";
            edit_icon[0].style.display="none";
            fields[3].style.display="none";
            form.style.display="flex";
          }

          function cancel_edit(){
            let fields = document.getElementsByClassName('account_content_info');
            let form = document.getElementById('change_password');
            let edit_icon = document.getElementsByClassName('edit_icon');
            let confirm_button = document.getElementsByClassName('confirm_button');
            let cancel_icon = document.getElementsByClassName('cancel_icon');
            cancel_icon[0].style.display="none";
            confirm_button[0].style.display="none";
            edit_icon[0].style.display="block";
            fields[3].style.display="block";
            form.style.display="none";
            form.reset();
          }
        </script>
        </body>
</html>