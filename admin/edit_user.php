<?php
    //includes file with db connection
    require_once '../scripts/db_connect.php';
   
    session_start();

    //checks if user is not logged in
    if (!isset($_SESSION['loggedin'])) {
      header('Location: ./index.php');
      $_SESSION['relog'] = true;
      
      //closes db conection
      $db->close();
      exit();
    }

    $user_id = $_GET['id'];

    $query = "SELECT * FROM USERS WHERE id = ".$user_id."";
    $result = $db->query($query);
    $row = $result->fetch();

    $order_query = "SELECT * FROM orders WHERE user_id='".$user_id."' ORDER BY order_date DESC";
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
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/styles.scss">
        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/d52da0a142.js" crossorigin="anonymous"></script>
        <script   src="https://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>
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
                  echo "<a class='userIcon active fa-solid fa-user ms-3 me-3' href='../account.php'></a>";
              }
              ?>
              <form class="d-flex" action="../search.php" method="post">
                <input name="search" id="search" class="form-control me-2" type="text" placeholder="Search">
                <button class="btn btn-primary" type="submit">Search</button>
              </form>
            </div>
          </div>
        </nav>
        <div class="account_content">
          <form action="../scripts/admin/update_user.php" method="post">
          <div class="account_header_container">
            <p class="account_content_header">Basic Info:</p>
            <input type="hidden" value="<?php echo $row['id']?>" name="user_id" id="user_id">
          </div>
          <div class="account_content_container">
            <div class="account_content_item">
              <div class="account_content_item_header">
                <p class="account_content_info_header">First name:</p>
              </div>
              <input class="form-control" name="first_name" id="first_name" type="text" value="<?php echo $row['first_name']?>" placeholder="First Name"/>
            </div>
            <div class="account_content_item">
              <div class="account_content_item_header">
                <p class="account_content_info_header">Last name:</p>
              </div>
              <input class="form-control" name="last_name" id="last_name" type="text" value="<?php echo $row['last_name']?>" placeholder="Last Name"/>
            </div>
            <div class="account_content_item">
              <div class="account_content_item_header">
                <p class="account_content_info_header">Email:</p>
              </div>
              <input class="form-control" name="email" id="email" type="email" value="<?php echo $row['email']?>" placeholder="Email"/>
            </div>
          </div>
          <hr/>
          <div class="account_header_container">
            <p class="account_content_header">Secure Info: </p>
          </div>
          <div class="account_content_container">
            <div class="account_content_item">
              <div class="account_content_item_header">
                <p class="account_content_info_header">Password:</p>
              </div>
              <p class="account_content_info">**************</p>
            </div>
          </div>
          <hr/>
          <div class="account_header_container">
            <p class="account_content_header">Personal Info:</p>
          </div>
          <div class="account_content_container">
            <div class="account_content_item">
              <p class="account_content_info_header">Address:</p>
              <input class="form-control" name="address" id="address" type="text" value="<?php echo $row['address']?>" placeholder="Address"/>
            </div>
            <div class="account_content_item">
              <p class="account_content_info_header">City:</p>
              <input class="form-control" name="city" id="city" type="text" value="<?php echo $row['city']?>" placeholder="City"/>
            </div>
            <div class="account_content_item">
              <p class="account_content_info_header">State:</p>
              <select class="form-control form-select" name="state" id="state" placeholder="State">
                    <option value="<?php echo $row['state']?>" selected><?php echo $row['state']?></option>
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="DC">District Of Columbia</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>
                    </select>           
                </div>
            <div class="account_content_item">
              <p class="account_content_info_header">Zip:</p>
              <input class="form-control" name="zip" id="zip" type="text" value="<?php echo $row['zip']?>" placeholder="Zip code"/>
            </div>   
          </div>
          <button type="submit"class="btn-lg btn-primary" style="margin-top: 1rem">Update info</button>
          <button type="button" onClick="delete_user(<?php echo $row['id']?>)" class="btn-lg btn-danger" style="margin-top: 1rem">Delete user</button>
          </form>
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
                  echo '<a style="width:30%"class="order_item" href="../order.php?id='.$order_row['order_id'].'">';
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
          function delete_user(user_id){
                if (confirm("Are you sure you want to delete this user?")) {
                  $.ajax({
                  url: '../scripts/admin/delete_user.php',
                  type: 'POST',
                  dataType : 'json',
                  data: { user_id: user_id },
                  success: function() {
                    }
                  });
                  window.location.href = "./manage_users.php";
                } else {
                  event.preventDefault();
                }
              }
        </script>
        </body>
</html>