<?php
    //includes file with db connection
    require_once './scripts/db_connect.php';

    //gets session info
    session_start();

    //checks if user is not logged in
    if (!isset($_SESSION['loggedin'])) {
        header('Location: ./index.php');
        $_SESSION['relog'] = true;
        
        //closes db conection
	    $db->close();
        exit();
    }

    $notice = '';
    $notice2 = '';
    if (isset($_SESSION['orderQuantity']) && $_SESSION['orderQuantity'] != "") {
      $notice = $_SESSION['orderQuantity'];
      $_SESSION['orderQuantity'] = '';
    } else if (isset($_SESSION['orderPlaced']) && $_SESSION['orderPlaced'] != "") {
      $notice2 = $_SESSION['orderPlaced'];
      $_SESSION['orderPlaced'] = '';
    }

    //queries db for username entered
    $query = "SELECT * FROM cart FULL JOIN products ON products.p_id=product_id WHERE user_id = '".$_SESSION['user_id']."'";
    $result = $db->query($query);
    
    
    //checks if results were returned
    // if ($result->num_rows == 0) {
    //     $_SESSION['emptyCart'] = true;
        
    //     //closes db conection
	  //     $db->close();
	  //     $result->free();
    //     exit();
    // }
    
    //gets associative array from result
    $cart = $result->fetchAll();

    $query2 = "SELECT * FROM users WHERE id = '".$_SESSION['user_id']."'";
    $result2 = $db->query($query2);
    $row2 = $result2->fetch();  

    $cart_ids = array();

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
                    echo "<a class='userIcon active fa-solid fa-cart-shopping me-1 ms-1' href='./cart.php'></a>";
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
        <section class="cart_section" style="overflow:auto">
            <div class="cart_contents">
                <?php 
                $cart_total = 0;
                echo '<div style="color:red; margin: 1rem 3rem 0">'.$notice.'</div>';
                echo '<div style="color:green; margin: 1rem 3rem 0">'.$notice2.'</div>';
                if(count($cart) == 0){
                  echo '<div class="empty_cart" id="empty_cart">';
                  echo '<p class="cart_item_info_header">No items in your cart</p>';
                  echo '</div>';
                  // $db->close();
                  // $result->free();
                  // exit();
                } else {
                  foreach($cart as $row){                    
                    array_push($cart_ids, $row['cart_id']);
                    echo '<div class="empty_cart" id="empty_cart" style="display:none">';
                    echo '<p class="cart_item_info_header">No items in your cart</p>';
                    echo '</div>';
                    echo '<div class="cart_item" id="'.$row['cart_id'].'" name="cart_item">';
                    echo '<div class="cart_item_img" style="width:100px; height:100px; background-color:black">';
                    echo '<img class="product_picture" alt="oops" src="./product_images/'.$row['p_image_url'].'">'; 
                    echo '</div>';
                    echo '<div class="cart_item_info_container">';
                    echo '<p class="cart_item_info_header">Name:</p>';
                    echo '<p class="cart_item_info">'.$row['p_name'].'</p>';
                    echo '</div>';
                    echo '<div class="cart_item_info_container">';
                    echo '<p class="cart_item_info_header">Price:</p>';
                    echo '<p id="'.$row['cart_id'].' price" class="cart_item_info">$'.$row['p_price'].'</p>';
                    echo '</div>';
                    echo '<div id="quantityContainer" class="cart_item_info_container">';
                    echo '<p class="cart_item_info_header">Quantity:</p>';
                    echo '<div class="cart_item_quantity_container">';
                    echo '<button onClick="update_quantity('.$row['cart_id'].', false)" class="update_quantity_button">-</button>';
                    echo '<p class="cart_item_info" id="'.$row['cart_id'].' quantity" style="width:30%">'.$row['product_quantity'].'</p>';
                    echo '<button onClick="update_quantity('.$row['cart_id'].', true)" class="update_quantity_button">+</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="cart_item_info_container">';
                    echo '<p class="cart_item_info_header">Subtotal:</p>';
                    $subtotal = ($row['product_quantity']*$row['p_price']);
                    echo '<p id="'.$row['cart_id'].' subtotal"class="cart_item_info">$'.number_format($subtotal, 2).'</p>';
                    echo '</div>';
                    echo '<div class="cart_item_info_container">';
                    echo '<button id="remove" onClick="remove_from_cart('.$row['cart_id'].')" type="button" class="close btn-danger" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    echo '</div>';
                    echo '</div>';
                    $cart_total += ($row['product_quantity']*$row['p_price']);
                  }
                }
                ?>
        </div>
        <div class="checkout_container">
          <p class="checkout_info_header">Billing info:</p>
          <hr/>
          <form action="./scripts/place_order.php" method="post">
            <div class="form-outline mb-2" style="display:flex; flex-direction:row">
              <input autofocus type="text" id="first_name" name="first_name" class="form-control form-control" placeholder="First Name" style="margin-right:1rem" value="<?php echo $row2['first_name']?>"/>
              <input type="text" id="last_name" name="last_name" class="form-control form-control" placeholder="Last Name" value="<?php echo $row2['last_name']?>"/>
            </div>
            <div class="form-outline mb-2">
              <input type="email" id="email" name="email" class="form-control form-control" placeholder="Email" value="<?php echo $row2['email']?>"/>
            </div>
            <div class="form-outline mb-2">
              <input type="text" id="address" name="address" class="form-control form-control" placeholder="Address" value="<?php echo $row2['address']?>"/>
            </div>
            <div class="form-outline mb-2">
              <input type="text" id="city" name="city" class="form-control form-control" placeholder="City" value="<?php echo $row2['city']?>"/>
            </div>           
            <div class="form-outline mb-2">
              <select class="form-control" name="state" id="state" placeholder="State">
                <option value="<?php echo $row2['state']?>" selected><?php echo $row2['state']?></option>
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
            <div class="form-outline mb-2">
              <input type="text" id="zip" name="zip" class="form-control form-control" placeholder="Zip code" value="<?php echo $row2['zip']?>"/>
            </div>
            <hr/>
            <p class="checkout_info_header">Payment info:</p>
            <div class="form-outline mb-2">
              <input disabled type="text" id="name_on_card" name="name_on_card" class="form-control form-control" placeholder="Name On Card"/>
            </div>   
            <div class="form-outline mb-2">
              <input disabled type="text" id="card_number" name="card_number" class="form-control form-control" placeholder="Card Number (4444 4444 4444 4444)"/>
            </div> 
            <div class="form-outline mb-2">
              <input disabled type="month" id="card_expiration" name="card_expiration" class="form-control form-control" placeholder="Expiration Date"/>
            </div> 
            <div class="form-outline mb-2">
              <input disabled type="text" id="card_cvv" name="card_cvv" class="form-control form-control" placeholder="CVV"/>
            </div> 
            <hr/>
          <p class="checkout_info_header">Total:</p>
          <input type="readonly" id="total" name="total" class="checkout_info" value="<?php echo '$'.number_format($cart_total,2)?>"/>
          <input type="hidden" id="cart_ids" name="cart_ids" value="<?php echo implode(", ", $cart_ids)?>"/>
          <div style="width:100%; display:flex">        
            <button type="submit" class="place_order btn-primary btn-lg">Place order</button>
          </div>
          </form>
        </div>
        </section>
    </body>
    <script>
      var formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
      });

      function remove_from_cart (cart_id) {
        let quantity = parseInt(document.getElementById(cart_id + " quantity").innerHTML);
        let subtotal = parseFloat(document.getElementById(cart_id + " subtotal").innerHTML.substr(1));
        let total = parseFloat(document.getElementById("total").value.substr(1));
        $.ajax({
        url: './scripts/remove_from_cart.php',
        type: 'POST',
        dataType : 'json',
        data: { cart_id: cart_id },
        success: function() {
            console.log("success")
          }
        });
        document.getElementById(cart_id).remove();
        let cart_item = document.getElementsByName("cart_item");        
        if(cart_item.length == 0){
          document.getElementById("empty_cart").style.display="block";
        }
        total = total-subtotal;        
        document.getElementById("total").value = formatter.format(total);
        cart_id_str = cart_id.toString();
        let cart_ids = document.getElementById("cart_ids").value;
        if(cart_ids.includes(", " + cart_id_str)){
          cart_ids = cart_ids.replace(", " + cart_id_str, "");
        } else if (cart_ids.includes(cart_id_str + ", ")) {
          cart_ids = cart_ids.replace(cart_id_str + ", ", "");
        } else {
          cart_ids = cart_ids.replace(cart_id_str, "");
        }

        document.getElementById("cart_ids").value = cart_ids;
        // document.getElementById("cart_ids").innerHTML = cart_ids;
      }

      function update_quantity (cart_id, increase){
        let quantity = parseInt(document.getElementById(cart_id + " quantity").innerHTML);
        let price = parseFloat(document.getElementById(cart_id + " price").innerHTML.substr(1));
        let currSubtotal = parseFloat(document.getElementById(cart_id + " subtotal").innerHTML.substr(1));
        let total = parseFloat(document.getElementById("total").value.substr(1));
        if(increase == true){
          quantity++;
        } else {
          if(quantity == 1){
            return;
          }
          quantity--;
        }
        $.ajax({
        url: './scripts/update_quantity.php',
        type: 'POST',
        dataType : 'json',
        data: { cart_id: cart_id, 
          quantity: quantity },
        success: function() {
            console.log("success")
          }
        });
        subtotal = quantity * price;
        subtotalDiff = subtotal - currSubtotal
        total = total + subtotalDiff
        
        document.getElementById(cart_id + " quantity").innerHTML = quantity;
        document.getElementById(cart_id + " subtotal").innerHTML = formatter.format(subtotal);
        document.getElementById("total").value = formatter.format(total);
      }
    </script>
</html>