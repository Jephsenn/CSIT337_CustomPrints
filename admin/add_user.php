<?php
    require_once '../scripts/db_connect.php';
    session_start();

    $notice='';
    $notice2='';
    //notifies user if not everything was input
    if (isset($_SESSION['regdone']) && $_SESSION['regdone'] == true) {
        $notice2 = 'User added';
        
        $_SESSION['regdone'] = false;
    }
    
    else if (isset($_SESSION['registration_failed']) && $_SESSION['registration_failed'] == 'invalid_input') {
        $notice = 'Registration info was not properly input. Please try again.';
        
        $_SESSION['registration_failed'] = '';
    }
    
    //notifies user if password is not long enough
    else if (isset($_SESSION['registration_failed']) && $_SESSION['registration_failed'] == 'invalid_password') {
        $notice = 'Password must be at least 6 characters. Please try again.';
        
        $_SESSION['registration_failed'] = '';
    }
    
    //notifies user if passwords do not match
    else if (isset($_SESSION['registration_failed']) && $_SESSION['registration_failed'] == 'pwdnotmatch') {
        $notice = 'Passwords do not match. Please try again.';
        
        $_SESSION['registration_failed'] = '';
    }
    
    //notifies user if username is already taken
    else if (isset($_SESSION['registration_failed']) && $_SESSION['registration_failed'] == 'usertaken') {
        $notice = 'Username already taken. Please try again.';
        
        $_SESSION['registration_failed'] = '';
    }
    
    else if (isset($_SESSION['registration_failed']) && $_SESSION['registration_failed'] == 'emailtaken') {
        $notice = 'Email already in use. Please try again.';
        
        $_SESSION['registration_failed'] = '';
    }
    
    else if (isset($_SESSION['registration_failed']) && $_SESSION['registration_failed'] == 'phonenumbertaken') {
        $notice = 'Phone Number already in use. Please try again.';
        
        $_SESSION['registration_failed'] = '';
    }
    
    //notifies user if some other error occurs
    else if (isset($_SESSION['registration_failed']) && $_SESSION['registration_failed'] == 'randerr') {
        $notice = 'An error has occurred. Please try again.';
        
        $_SESSION['registration_failed'] = '';
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
        <div class="container-fluid">
            <div class="add_user_form row">
              <div class="text-black">
              <div style='color: red; margin-left:3rem'><?php echo $notice; ?></div>
              <div style='color: green; margin-left:3rem'><?php echo $notice2; ?></div>
                <div class="d-flex align-items-center h-custom-1 px-5 mt-5 pt-5 pt-xl-0 mt-xl-n5" style="flex-direction:row">
                  <form style="width: 100%; display:flex; justify-content:space-between; flex-wrap:wrap" action="../scripts/admin/add_user.php" method="post">
                    <div style="display:flex; flex-direction:column; width:50%; padding-right:1%">
                        <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Add user</h3>
                        <div class="form-outline mb-4">
                        <input type="text" id="first_name" name="first_name" class="form-control form-control-lg" placeholder="First name"/>
                        </div>

                        <div class="form-outline mb-4">
                        <input type="text" id="last_name" name="last_name" class="form-control form-control-lg" placeholder="Last name"/>
                        </div>
                        
                        <div class="form-outline mb-4">
                        <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Email"/>
                        </div>

                        <div class="form-outline mb-4">
                        <input type="password" id="password" name="pass" class="form-control form-control-lg" placeholder="Password"/>
                        </div>

                        <div class="form-outline mb-4">
                        <input type="password" id="confPassword" name="confPass" class="form-control form-control-lg" placeholder="Confirm Password"/>
                        </div>
                    </div>

                    <div style="display:flex; flex-direction:column; width:50%; margin-top:4.1rem">
                        <div class="form-outline mb-4">
                        <input type="tel" id="phone" name="phone" class="form-control form-control-lg" placeholder="Phone number (Ex. 999-999-9999)"/>
                        </div>

                        <div class="form-outline mb-4">
                        <input type="text" id="address" name="address" class="form-control form-control-lg" placeholder="Address"/>
                        </div>

                        <div class="form-outline mb-4">
                        <input type="text" id="city" name="city" class="form-control form-control-lg" placeholder="City"/>
                        </div>
                        
                        <div class="form-outline mb-4">
                        <select style="width:100%" class="form-select-lg" name="state" id="state" placeholder="State">
                            <option value="" disabled selected>State</option>
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

                        <div class="form-outline mb-4">
                        <input type="text" id="zip" name="zip" class="form-control form-control-lg" placeholder="Zip code"/>
                        </div>
                    </div>

                    <div class="pt-1 mb-4">
                      <button style="displ"class="btn btn-info btn-lg btn-block" type="submit">Register</button>
                    </div>
                </div>
            </div> 
        </div>
    </body>
</html>