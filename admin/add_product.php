<?php
    require_once '../scripts/db_connect.php';
    session_start();
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
                <form action="../scripts/admin/upload_product.php" enctype="multipart/form-data" method="post">
                <div class="individual_product">
                    <div class="individual_img">
                        <img class="product_image" id="product_image" alt="oops" src="./"/>
                    </div>
                    <div class="individual_product_description_container">
                        <div class="form-outline mb-3">
                            <input autofocus required type="text" id="product_name" name="product_name" class="form-control" placeholder="Product name"/>
                        </div>
                        <div class="form-outline mb-3">
                            <textarea required id="product_desc" name="product_desc" class="form-control" placeholder="Product Description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Upload Image:</label>
                            <input required onChange="image_upload()" class="form-control" type="file" id="formFile" name="formFile"/>
                        </div>
                    </div>
                </div>
                <div class="item_info_container">                
                    <p class="item_info_category">Price:</p>
                    <div class="form-outline mb-3">
                        <input required style="width:30%" class="form-control item_info_quantity" id="product_price" name="product_price" type="number" placeholder="Price" step="0.01"/>
                    </div>   
                    <p class="item_info_category">Type:</p>
                    <div class="form-outline mb-3">
                        <select required class="form-select" name="product_type" id="product_type" style="width:90%; margin:auto" placeholder="Type">
                            <option value="" disabled selected>Type</option>
                            <option value="hats">Shirts</option>
                            <option value="sweaters">Sweaters</option>
                            <option value="jackets">Jackets</option>
                            <option value="hats">Hats</option>
                        </select>
                    </div>
                    <p class="item_info_category">Amount Available:</p>
                    <div class="form-outline mb-3">
                        <input required class="form-control item_info_quantity" id="product_amt_available" name="product_amt_available" type="number" style="width:30%" placeholder="0"/>
                    </div>
                    <div class="upload-container">
                        <button class="btn-primary btn-lg" type="submit">Add product</button>
                    </div>
                    </form>
                </div>
            </div>
        </div> 
        <script>
            function image_upload(){
                imgInp = document.getElementById('formFile');
                img = document.getElementById('product_image');
                const [file] = imgInp.files
                    if (file) {
                        img.src = URL.createObjectURL(file)
                    }
                }
        </script> 
    </body>
</html>