<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="theme-color" content="#000000" />
        <meta
            name="Custom Prints"
            content="Website to sell customly printed apparel"
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
                  <a class="nav-link active" href="./index.php">Home</a>
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
        <div style="overflow:auto; height:93.3vh">
          <img style="width:80%; display:block; margin:auto" src="./images/collage-1.png" alt="oops">
          <hr class="homepage_separator"/>
          <div class="homepage_blurb">
            <h2>Welcome to Custom Prints</h2>
            <p>We take requests for custom clothing with your logo printed on it!</p>
          </div>
          <hr class="homepage_separator"/>
          <img style="width:80%; display:block; margin:auto" src="./images/collage-2.png" alt="oops">
          <hr class="homepage_separator"/>
          <div class="homepage_blurb">
            <h2>Many differnent base items</h2>
            <p>Check out our wide variety of different items to print your logo on!</p>
          </div>
          <hr class="homepage_separator"/>
          <img style="width:80%; display:block; margin:auto" src="./images/collage-3.png" alt="oops">
          <hr class="homepage_separator"/>
          <div class="homepage_blurb">
            <h2>Fair pricing for all!</h2>
            <p>Each of our items are fairly priced based on our competetors for your satisfaction!</p>
          </div>
          <hr class="homepage_separator"/>
        </div>
    </body>
</html>