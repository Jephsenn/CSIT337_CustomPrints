<?php
    require_once '../scripts/db_connect.php';
    session_start();

    //checks if user is not logged in
    if (!isset($_SESSION['loggedin']) && !isset($_SESSION['admin'])) {
        header('Location: ./index.php');
        $_SESSION['relog'] = true;
        
        //closes db conection
	    $db->close();
        exit();
    }

    if($_SESSION['admin'] != 1) {
        header('Location: ./index.php');
        $_SESSION['relog'] = true;
        
        //closes db conection
	    $db->close();
        exit();
    }

    $query = "SELECT p_id, p_name, p_price, p_category, p_image_url FROM products ORDER BY date_added DESC";
    $results = $db->query($query);

    $prod = $results->fetchAll();

    // $notice='';
    // if(isset($_SESSION['deleted'])){
    //   $notice=$_SESSION['deleted'];
    //   $_SESSION['deleted']='';
    // }
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
                  <a class="nav-link active" href="../shop.php">Shop</a>
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
              <form class="d-flex" action="../search.php" method="post">
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
                <div style="width: 80%; margin-left: 1rem;">
                  <a href="./add_product.php" class="add_product btn btn-primary">Add product</a>
                </div>
            </nav>
            <div class="shopProducts container-fluid pe-5 pb-3">
                <?php
                //echo $notice;
                    if(count($prod) == 0){
                        echo "No products available";
                    } else {
                        foreach($prod as $row){
                            $p_id = $row['p_id'];
                            $p_name = $row['p_name'];
                            $p_price = $row['p_price'];
                            $p_category = $row['p_category'];
                            $p_image_url = $row['p_image_url'];
                            echo '<a class="item_product" href="./edit_product.php?id='.$p_id.'")>';
                            echo '<div class="product_img">';
                            echo '<img class="product_picture" alt="oops" src="../product_images/'.$p_image_url.'">';
                            echo '</div>';
                            echo '<div class="product_description">';
                            echo '<p class="product_name">'.$p_name.'</p>';
                            echo '<p class="product_price">$'.$p_price.'</p>';
                            echo '</div>';
                            echo '</a>';
                        }
                    }
                ?>
            </div>
        </div>  
    </body>
</html>