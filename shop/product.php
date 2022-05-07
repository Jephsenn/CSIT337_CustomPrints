<?php
    require_once '../scripts/db_connect.php';
    session_start();

    $product_id = $_GET['id'];

    $query = "SELECT * FROM products WHERE p_id='".$product_id."'";
    $results = $db->query($query);

    $row = $results->fetch();
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
                    echo "<a class='userIcon fa-solid fa-cart-shopping me-1 ms-1' href='../account.php'></a>";
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
            <div class="container-fluid pe-5 pb-3">
                <div class="individual_product">
                    <div class="individual_img" id="individual_img">
                      <canvas style="display:none; width:100%; height:450px" class="result"></canvas>
                      <img class="product_picture" alt="oops" src=<?php echo "../product_images/".$row['p_image_url']?>>
                      <img style="display:none" class="product_picture" alt="oops" src="./">
                    </div>
                    <div class="individual_product_description_container">
                        <p class="individual_name"><?php echo ucfirst($row['p_name'])?></p>
                        <p class="individual_description"><?php echo $row['p_desc']?></p>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Upload Image:</label>
                            <input required onChange="image_upload()" class="form-control" type="file" id="formFile" name="formFile"/>
                        </div>
                    </div>
                </div>
                <div class="item_info_container">
                    <p class="item_info_category">Name:</p>
                    <p class="item_info"><?php echo ucfirst($row['p_name'])?></p>
                    <p class="item_info_category">Price:</p>
                    <p class="item_info">$<?php echo $row['p_price']?></p>
                    <p class="item_info_category">Type:</p>
                    <p class="item_info"><?php echo ucfirst($row['p_type'])?></p>
                    <?php 
                      if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
                        echo '<form action="../scripts/add_to_cart.php" method="post">';
                        echo '<input type="hidden" name="p_id" value='.$row['p_id'].'/>';
                        echo '<input type="hidden" name="p_price" value='.$row['p_price'].'/>';
                        echo '<p class="item_info_category">Quantity:</p>';
                        echo '<input class="item_info_quantity" name="p_quantity" type="number" placeholder="1" value="1"/>';
                        echo '<div class="atc-container">';
                        echo '<button class="btn-primary btn-lg" type="submit">Add to Cart</button>';
                        echo '</div>';
                        echo '</form>';
                      } else {
                        echo '<div class="atc-container">';
                        echo '<p class="need-log" style="text-align:center; padding-top:15%">Please log in to add to cart</p>';
                        echo '</div>';
                      }
                    ?>  
                </div>
            </div>
        </div>  
        <script src='../scripts/upload_image.js'></script>
    </body>
</html>