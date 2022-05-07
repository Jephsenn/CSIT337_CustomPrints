<?php
    //gets session info
    session_start();
    $notice = '';

    //informs user if input was not put in correctly
    if (isset($_SESSION['login_failed']) && $_SESSION['login_failed'] == "bad_input") {
        $notice = 'ERROR: Log in info was not properly input. Please try again.';
        $_SESSION['login_failed'] = '';
    }
    
    //informs user if username does not exist
    else if (isset($_SESSION['login_failed']) && $_SESSION['login_failed'] == 'user_DNE') {
        $notice = 'ERROR: Username does not exist. Please try again.';
        $_SESSION['login_failed'] = '';
    }
    //informs user if password is incorrect
    else if (isset($_SESSION['login_failed']) && $_SESSION['login_failed'] == 'wrong_password') {
        $notice = 'ERROR: Incorrect password. Please try again.';
        $_SESSION['login_failed'] = '';
    }
    
    //informs user if they tried to add items to cart prior to logging in
    else if (isset($_SESSION['needlog']) && $_SESSION['needlog'] == true ) {
        $notice = 'ERROR: You are not logged in. Please log in and try again.';
        $_SESSION['needlog'] = false;
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
                  <a class="nav-link" href="./shop.php">Shop</a>
                </li>
                <li class="nav-item">
                  <?php
                    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
                      echo "<a class='nav-link active' href='./scripts/logout_confirm.php'>Logout</a>";
                    } else {
                      echo "<a class='nav-link active' href='./login.php'>Login</a>";
                    }
                  ?>
                </li>
              </ul>
              <?php
                if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
                  echo "<a class='userIcon fa-solid fa-cart-shopping me-1 ms-1' href='./account.php'></a>";
                  echo "<a class='userIcon fa-solid fa-user ms-3 me-3' href='./cart.php'></a>";
                }
              ?>
              <form class="d-flex">
                <input class="form-control me-2" type="text" placeholder="Search">
                <button class="btn btn-primary" type="button">Search</button>
              </form>
            </div>
          </div>
        </nav>
        <section>
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6 text-black">

                <div class="d-flex align-items-center h-custom-1 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

                  <form style="width: 23rem;" action="./scripts/login_confirm.php" method="post">

                    <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Log in</h3>
                    <div style='color: red; margin-bottom:1.5rem'><?php echo $notice; ?></div>

                    <div class="form-outline mb-4">
                      <input autofocus type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Email"/>
                    </div>

                    <div class="form-outline mb-4">
                      <input type="password" id="password" name="pass" class="form-control form-control-lg" placeholder="Password"/>
                    </div>

                    <div class="pt-1 mb-4">
                      <button class="btn btn-info btn-lg btn-block" type="submit">Login</button>
                    </div>

                    <p>Don't have an account? <a href="./register.php" class="link-info">Register here</a></p>

                  </form>

                </div>

              </div>
              <div class="col-sm-6 px-0 d-none d-sm-block">
                  <img src="./images/img3.webp"
                    alt="Login image" class="w-100" style="object-fit: cover; object-position: left; max-height:93.2vh;">
              </div>
            </div>
          </div>
        </section>
    </body>
</html>