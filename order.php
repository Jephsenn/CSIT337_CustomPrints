<?php
    require_once './scripts/db_connect.php';
    session_start();

    $order_id = $_GET['id'];

    $query = "SELECT * FROM orders WHERE order_id=$order_id";
    $results = $db->query($query);

    $row = $results->fetch();

    $cart_ids = $row['cart_ids'];
    if(str_contains($cart_ids, ", ")){
        $cart_ids_array = explode(', ', $cart_ids);
    } else {
        $cart_ids_array = explode(' ', $cart_ids);
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
                  <a class="nav-link active" href="./shop.php">Shop</a>
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
                    echo "<a class='userIcon fa-solid fa-user ms-3 me-3' href='./account.php'></a>";
                }
              ?>
              <form class="d-flex">
                <input class="form-control me-2" type="text" placeholder="Search">
                <button class="btn btn-primary" type="button">Search</button>
              </form>
            </div>
          </div>
        </nav>
        <div class="order_content">
            <p class="order_header">Order ID: </p>
            <p class="order_info"><?php echo $row['order_id']?></p>
            <p class="order_header">Date: </p>
            <p class="order_info"><?php echo $row['order_date']?></p>
            <hr style="width:95%; margin: 2rem auto"/>
            <div class="order_content_container">
                <div class="order_container_item">
                    <p class="order_container_header">First Name: </p>
                    <p class="order_container_info"><?php echo $row['order_f_name']?></p>
                </div>
                <div class="order_container_item">
                    <p class="order_container_header">Last Name: </p>
                    <p class="order_container_info"><?php echo $row['order_l_name']?></p>
                </div>
                <div class="order_container_item">
                    <p class="order_container_header">Email: </p>
                    <p class="order_container_info"><?php echo $row['order_email']?></p>
                </div>
            </div>
            <hr style="width:95%; margin: 2rem auto"/>
            <div class="order_content_container">
                <div class="order_container_item2">
                    <p class="order_container_header">Address: </p>
                    <p class="order_container_info"><?php echo $row['order_addr']?></p>
                </div>
                <div class="order_container_item2">
                    <p class="order_container_header">City: </p>
                    <p class="order_container_info"><?php echo $row['order_city']?></p>
                </div>
                <div class="order_container_item2">
                    <p class="order_container_header">State: </p>
                    <p class="order_container_info"><?php echo $row['order_state']?></p>
                </div>
                <div class="order_container_item2">
                    <p class="order_container_header">Zip: </p>
                    <p class="order_container_info"><?php echo $row['order_zip']?></p>
                </div>
            </div>
            <hr style="width:95%; margin: 2rem auto 1rem"/>
            <p class="order_header">Items: </p>
            <?php
                for($i=0; $i<count($cart_ids_array); $i++){
                    $cart_complete_query = "SELECT * FROM cart_complete WHERE cart_id=$cart_ids_array[$i]";
                    $cart_complete_results = $db->query($cart_complete_query);
                    $cart_complete_row = $cart_complete_results->fetch();


                    $product_query = "SELECT * FROM products WHERE p_id=".$cart_complete_row['product_id']."";
                    $product_results = $db->query($product_query);

                    $product_row = $product_results->fetch();
                    echo '<div class="cart_item" id="'.$cart_complete_row['cart_id'].'" name="cart_item">';
                    echo '<div class="cart_item_img" style="width:100px; height:100px; background-color:black">';
                    echo '<img class="product_picture" alt="oops" src="./product_images/'.$product_row['p_image_url'].'">';
                    echo '</div>';
                    echo '<div class="cart_item_info_container">';
                    echo '<p class="cart_item_info_header">Name:</p>';
                    echo '<p class="cart_item_info">'.$product_row['p_name'].'</p>';
                    echo '</div>';
                    echo '<div class="cart_item_info_container">';
                    echo '<p class="cart_item_info_header">Price:</p>';
                    echo '<p id="'.$cart_complete_row['cart_id'].' price" class="cart_item_info">$'.$cart_complete_row['product_price'].'</p>';
                    echo '</div>';
                    echo '<div id="quantityContainer" class="cart_item_info_container">';
                    echo '<p class="cart_item_info_header">Quantity:</p>';
                    echo '<div class="cart_item_quantity_container">';
                    echo '<p class="cart_item_info" id="'.$cart_complete_row['cart_id'].' quantity" style="width:30%">'.$cart_complete_row['product_quantity'].'</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="cart_item_info_container">';
                    echo '<p class="cart_item_info_header">Subtotal:</p>';
                    $subtotal = ($cart_complete_row['product_quantity']*$cart_complete_row['product_price']);
                    echo '<p id="'.$cart_complete_row['cart_id'].' subtotal"class="cart_item_info">$'.number_format($subtotal, 2).'</p>';
                    echo '</div>';
                    echo '</div>';
                }

                echo '<p class="order_header">Cart Total:</p>';
                echo '<p class="order_info">$'.$row['total'].'</p>';
            ?>
        </div>  
    </body>
</html>