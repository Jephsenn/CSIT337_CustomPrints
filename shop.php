<?php
    require_once './scripts/db_connect.php';
    session_start();

    if(isset($_POST['type'])){
      $types = $_POST['type'];
      $foundTypes = array();
      $total_products = 0;
      foreach($types as $type){
          $query = "SELECT p_id, p_name, p_price, p_type, p_image_url FROM products WHERE p_type='".$type."'";
          $results = $db->query($query);

          $prod = $results->fetchAll();
          $total_products += count($prod);

          foreach($prod as $row){
              array_push($foundTypes, $row);
          }
      }        
  } else {
      $query = "SELECT p_id, p_name, p_price, p_type, p_image_url FROM products ORDER BY date_added DESC LIMIT 6";
      $results = $db->query($query);

      $prod2 = $results->fetchAll();

      $query2 = "SELECT p_id, p_name, p_price, p_type, p_image_url FROM products ORDER BY p_amt_sold DESC LIMIT 6";
      $results2 = $db->query($query2);

      $prod3 = $results2->fetchAll();
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
    <body>
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
              <form class="d-flex" action="./search.php" method="post">
                <input name="search" id="search" class="form-control me-2" type="text" placeholder="Search">
                <button class="btn btn-primary" type="submit">Search</button>
              </form>
            </div>
          </div>
        </nav>
        <div class="shopContent">
            <nav class="shopSidebar">
                <ul class="sidebarOptions">
                    <li class="sidebarHeader"><a>Main Page</a></li>
                    <hr/>
                    <form class="sidebarOptionSet" method="post">
                        <li class="sidebarOption"><input type="checkbox" name="type[]" class="type" value="shirts">Shirts</input></li>
                        <li class="sidebarOption"><input type="checkbox" name="type[]" class="type" value="sweaters">Sweaters</input></li>
                        <li class="sidebarOption"><input type="checkbox" name="type[]" class="type" value="jackets">Jackets</input></li>
                        <li class="sidebarOption"><input type="checkbox" name="type[]" class="type" value="hats">Hats</input></li>
                        <li class="sidebarOption"><input type="submit" class="btn-success mt-1 mb-1"></input></li>
                    </form>
                </ul>
            </nav>
            <div class="shopProducts container-fluid pe-5 pb-3">
                <?php
                if(isset($_POST['type'])){
                  if(count($prod) == 0){
                    echo '<h2 class="shop_content_header">Products:</h2>';
                    echo "<p style='margin:2rem'>No products available</p>";
                  } else {
                    echo '<h2 class="shop_content_header">Products:</h2>';
                    foreach($prod as $row){
                      $p_id = $row['p_id'];
                      $p_name = $row['p_name'];
                      $p_price = $row['p_price'];
                      $p_image_url = $row['p_image_url'];
                      echo '<a class="item_product" href="./shop/product.php?id='.$p_id.'")>';
                      echo '<div class="product_img">';
                      echo '<img class="product_picture" alt="oops" src="./product_images/'.$p_image_url.'">';
                      echo '</div>';                                
                      echo '<div class="product_description">';
                      echo '<p class="product_name">'.$p_name.'</p>';
                      echo '<p class="product_price">$'.$p_price.'</p>';
                      echo '</div>';
                      echo '</a>';
                    }
                  }
                } else {
                    if(count($prod2) == 0){
                      echo "No products available";
                    } else {
                      echo '<h2 class="shop_content_header">Recently Added:</h2>';
                      foreach($prod2 as $row2){
                        $p_id = $row2['p_id'];
                        $p_name = $row2['p_name'];
                        $p_price = $row2['p_price'];
                        $p_image_url = $row2['p_image_url'];
                        echo '<a class="item_product" href="./shop/product.php?id='.$p_id.'")>';
                        echo '<div class="product_img">';
                        echo '<img class="product_picture" alt="oops" src="./product_images/'.$p_image_url.'">';
                        echo '</div>';
                        echo '<div class="product_description">';
                        echo '<p class="product_name">'.$p_name.'</p>';
                        echo '<p class="product_price">$'.$p_price.'</p>';
                        echo '</div>';
                        echo '</a>'; 
                      }
                      echo '<hr/>';           
                    }
                    if(count($prod3) == 0){
                      echo "No products available";
                    } else {
                      echo '<h2 class="shop_content_header">Trending Products:</h2>';
                      foreach($prod3 as $row3){
                        $p_id = $row3['p_id'];
                        $p_name = $row3['p_name'];
                        $p_price = $row3['p_price'];
                        $p_image_url = $row3['p_image_url'];
                        echo '<a class="item_product" href="./shop/product.php?id='.$p_id.'")>';
                        echo '<div class="product_img">';
                        echo '<img class="product_picture" alt="oops" src="./product_images/'.$p_image_url.'">';
                        echo '</div>';
                        echo '<div class="product_description">';
                        echo '<p class="product_name">'.$p_name.'</p>';
                        echo '<p class="product_price">$'.$p_price.'</p>';
                        echo '</div>';
                        echo '</a>';
                      }           
                    }
                  }
                ?>
            </div>
        </div>  

        <script>
            // var coll = document.getElementsByClassName("sidebarHeader");
            // var i;

            // for (i = 0; i < coll.length; i++) {
            // coll[i].addEventListener("click", function() {
            //     this.classList.toggle("active");
            //     var sidebarOptionSet = this.nextElementSibling;
            //     if (sidebarOptionSet.style.display === "block") {
            //         sidebarOptionSet.style.display = "none";
            //     } else {
            //         sidebarOptionSet.style.display = "block";
            //     }
            // });
            // }
        </script>
    </body>
</html>