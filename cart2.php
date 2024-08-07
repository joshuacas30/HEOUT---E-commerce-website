<?php
session_start();
include_once("./php/conn.php");

// Check if the user is logged in
if (isset($_SESSION['customerID'])) {
  // User is logged in
  $userId = $_SESSION['customerID'];
  $username = $_SESSION['username'];

  // Check if the form is submitted to update the cart
  if (isset($_POST['update-cart'])) {
    // Iterate through the submitted quantities
    foreach ($_POST['quantity'] as $productId => $newQuantity) {
      // Fetch product details
      $selectProduct = $conn->prepare("SELECT * FROM products WHERE productsID = :productsID");
      $selectProduct->bindParam(':productsID', $productId);
      $selectProduct->execute();
      $product = $selectProduct->fetch(PDO::FETCH_ASSOC);

      // Calculate total price based on the updated quantity
      $totalPrice = $product['price'] * $newQuantity;

      // Update quantity and total price in the cart_tbl table
      $updateCart = $conn->prepare("UPDATE cart_tbl SET quantity = :quantity, totalPrice = :totalPrice WHERE customerID = :customerID AND productsID = :productsID");
      $updateCart->bindParam(':quantity', $newQuantity);
      $updateCart->bindParam(':totalPrice', $totalPrice);
      $updateCart->bindParam(':customerID', $userId);
      $updateCart->bindParam(':productsID', $productId);
      $updateCart->execute();
    }
    echo "<script>alert('Cart updated successfully');</script>";
  }

  // Check if the form is submitted to remove an item
  if (isset($_POST['remove-item']) && isset($_POST['removeProductId'])) {
    $removeProductId = $_POST['removeProductId'];

    // Use prepared statement to delete the item from cart_tbl
    $deleteQuery = $conn->prepare("DELETE FROM cart_tbl WHERE customerID = :customerID AND productsID = :productsID");
    $deleteQuery->bindParam(':customerID', $userId);
    $deleteQuery->bindParam(':productsID', $removeProductId);
    $deleteQuery->execute();

    echo "<script>alert('Item removed from cart');</script>";
  }

  // Check if the form is submitted to complete the order
  if (isset($_POST['complete-order'])) {
    $insertQuery = $conn->prepare("INSERT INTO order_tbl (customerID, productsID, quantity, totalPrice, orderStatus) 
                                     SELECT customerID, productsID, quantity, totalPrice, 'Processing' FROM cart_tbl WHERE customerID = :customerID");
    $insertQuery->bindParam(":customerID", $userId);
    $insertQuery->execute();

    $deleteQuery = $conn->prepare("DELETE FROM cart_tbl WHERE customerID = :customerID");
    $deleteQuery->bindParam(":customerID", $userId);
    $deleteQuery->execute();
    echo "<script>alert('Order Completed');</script>";
    echo "<script>window.open('cart2.php','_self')</script>";
  }

  // Fetch products from cart_tbl for the logged-in user
  $selectCart = $conn->prepare("SELECT cart_tbl.*, products.* FROM cart_tbl 
                                  INNER JOIN products ON cart_tbl.productsID = products.productsID
                                  WHERE cart_tbl.customerID = :customerID");
  $selectCart->bindParam(':customerID', $userId);
  $selectCart->execute();

  // Display products and calculate grand total
  $grandTotal = 0;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Cart</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    @font-face {

      font-family: 'StretchPro.ttf';
      src: url(fonts/StretchPro.ttf) format('truetype');

    }

    @font-face {
      font-family: 'LouisGeorge Cafe Bold';
      src: url(fonts/Louis\ George\ Cafe\ Bold.ttf) format('truetype');

    }

    * {
      padding: 0;
      margin: 0;
      font-size: small;

    }

    nav {
      display: flex;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 100;
      width: 100%;
      background-color: white;
      padding: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      height: 50px;
      padding: 0px 20px;

    }

    .logo {
      display: flex;
      justify-content: center;
      place-items: center;
      cursor: pointer;
    }

    .logo span {
      font-size: 2vw;
      font-weight: 700;
    }

    .categories {
      display: flex;
      justify-content: space-evenly;
      align-items: center;
      flex-wrap: wrap;
      padding: 0;

    }

    .menu-right {
      display: flex;
      justify-content: space-around;
      align-items: center;
      flex-wrap: nowrap;



    }

    .menu-right a {
      /* background-color: red; */
      text-decoration: none;
      color: black;


    }

    .dropdown:hover>.dropdown-menu {
      display: block;

    }

    .dropdown>.dropdown-toggle:active {
      /*Without this, clicking will make it sticky*/
      pointer-events: none;

    }

    header {
      overflow: hidden;
      background-color: black;
      color: white;
      font-family: 'LouisGeorge Cafe Bold';
      white-space: nowrap;


    }

    .discount-slide {
      display: inline-block;
      padding: 10px;
      margin: 10px;
      font-family: 'LouisGeorge Cafe Bold';
      animation: 10s slide infinite linear;
    }

    .btn-complete-order {

      background-color: black;
      color: white;
      border: none;
      padding: 10px 20px;
      cursor: pointer;

    }

    .btn-update-cart {
      border: 1px solid black;
      background-color: transparent;
      color: black;
      padding: 10px 20px;
    }

    .btn-cont-shopping {
      border: none;
      color: black;

    }

    .btn-remove {
      border: none;
      background-color: transparent;
    }

    .btn-remove:hover {
      color: red;

    }

    @keyframes slide {
      from {
        transform: translateX(0);
      }

      to {
        transform: translateX(-100%);
      }

    }
  </style>
</head>

<body>

  <nav>

    <div class="categories">

      <!-- men -->
      <div class="dropdown">
        <button class="btn" type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false">MEN</button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <li><a class="dropdown-item" href="prodMen.php">Shirt</a></li>
          <li><a class="dropdown-item" href="prodMen.php">Shorts</a></li>

        </ul>
      </div>
      <!-- women -->
      <div class="dropdown">
        <button class="btn " type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false">WOMEN</button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <li><a class="dropdown-item" href="prodWomen.php">Shirt</a></li>
          <li><a class="dropdown-item" href="prodWomen.php">Short</a></li>

        </ul>
      </div>
    </div>

    <div class="logo"><span>HEOUT</span></div>

    <!-- cart and account menu -->
    <div class="menu-right">
      <a href="index.php">Home</a>
      <!-- cart -->
      <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
        <i class='bx bx-cart bx-sm bx-tada-hover'></i></button>
      <!-- account -->
      <div class="dropdown">
        <button class="btn " type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false"><i class='bx bx-user bx-tada-hover bx-sm'></i></button>
        <ul class="dropdown-menu ">
          <span style="margin-left: 9px;">Welcome,<?php echo $username; ?></span>
          <li> <?php if (isset($_SESSION['customerID'])) : ?>

              <a href="./php/signout.php" style="margin-left: 9px;">Logout</a>
            <?php else : ?>
          <li><button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#signinModal">
              Sign in
            </button></li>
        <?php endif; ?></li>

        <li><a href="./php/userAcc.php"><button type="button" class="btn">
              My Account
            </button></a></li>

        <li><button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#adminSigninModal">
            Log in as admin
          </button></li>
        </ul>
      </div>

    </div>

  </nav>


  <form action='' method='post' class="container mt-5">
    <center>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Product</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total Price</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $grandTotal = 0;

          if (isset($_SESSION['customerID'])) {
            while ($row = $selectCart->fetch(PDO::FETCH_ASSOC)) {
              $productId = $row['productsID'];
              $productName = $row['productName'];
              $productImage = $row['productImage'];
              $price = $row['price'];
              $quantity = $row['quantity'];
              $totalItemPrice = $price * $quantity;
              $grandTotal += $totalItemPrice;
          ?>
              <tr>
                <td>
                  <img src="./php/uploads/<?php echo $productImage; ?>" alt="Product Image" width="100">
                  <br><?php echo $productName; ?>
                </td>
                <td>₱<?php echo $price; ?></td>
                <td>
                  <input type='number' name='quantity[<?php echo $productId; ?>]' value='<?php echo $quantity; ?>' min='1' class="form-control" style="width: 50px;">
                </td>
                <td>₱<?php echo $totalItemPrice; ?></td>
                <td>
                  <button type='submit' name='remove-item' class="btn-remove">Remove</button>
                  <input type='hidden' name='removeProductId' value='<?php echo $productId; ?>'>
                </td>
              </tr>
              <?php
            }
          } else {
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
              foreach ($_SESSION['cart'] as $productId) {
                $selectProduct = $conn->prepare("SELECT * FROM products WHERE productsID = :productsID");
                $selectProduct->bindParam(':productsID', $productId);
                $selectProduct->execute();
                $product = $selectProduct->fetch(PDO::FETCH_ASSOC);

                $productName = $product['productName'];
                $productImage = $product['productImage'];
                $price = $product['price'];
                $quantity = 1; // Default quantity for session cart
                $totalItemPrice = $price * $quantity;
                $grandTotal += $totalItemPrice;
              ?>
                <tr>
                  <td>
                    <img src="./php/uploads/<?php echo $productImage; ?>" alt="Product Image" width="100">
                    <br><?php echo $productName; ?>
                  </td>
                  <td>₱<?php echo $price; ?></td>
                  <td>
                    <input type='number' name='quantity[<?php echo $productId; ?>]' value='<?php echo $quantity; ?>' min='1' class="form-control" style="width: 50px;" disabled>
                  </td>
                  <td>₱<?php echo $totalItemPrice; ?></td>
                  <td>
                    <button type='submit' name='remove-session-item' class="btn-remove">Remove</button>
                    <input type='hidden' name='removeProductId' value='<?php echo $productId; ?>'>
                  </td>
                </tr>
          <?php
              }
            }
          }
          ?>
        </tbody>
      </table>
    </center>
    <p class="fw-bold mt-4" style="margin-left: 80%;">Grand Total: ₱<?php echo $grandTotal; ?></p>
    <?php if (isset($_SESSION['customerID'])) { ?>
      <button type='submit' name='update-cart' class="btn-update-cart">Update Cart</button>
      <button type='submit' name='complete-order' class="btn-complete-order">Complete Order</button>
    <?php } else { ?>
      <a href="index.php" class="btn">Log in to Complete Order</a>
    <?php } ?>
  </form>
  <a href='prodMen.php' class="btn-cont-shopping" style="margin-left: 560px; ">Continue Shopping</a>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>


<!-- modal signup  -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1>Create an Account</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./php/signup.php" method="post">
        <div class="modal-body">

          <div class="input-group">
            <span class="input-group-text"><ion-icon name="person-outline"></ion-icon></span>
            <input type="text" name="firstname" id="firstname" class="form-control fname" placeholder="Firstname">
          </div>

          <div class="input-group">
            <span class="input-group-text"><ion-icon name="person-outline"></ion-icon></span>
            <input type="text" name="middlename" id="middlename" class="form-control" placeholder="Middlename">
          </div>
          <div class="input-group">
            <span class="input-group-text"><ion-icon name="person-outline"></ion-icon></span>
            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Lastname">
          </div>

          <div class="input-group">
            <span class="input-group-text"><ion-icon name="call-outline"></ion-icon></span>
            <input type="number" name="contactNum" id="contactNum" class="form-control" placeholder="Contact number">
          </div>

          <div class="input-group">
            <span class="input-group-text">Address</span>
            <input type="text" name="street" id="street" class="form-control" placeholder="Building no./Street name">
            <input type="text" name="brgy" id="brgy" class="form-control" placeholder="Barangay">

          </div>

          <div class="input-group">
            <input type="text" name="city" id="city" class="form-control" placeholder="City/Municipality">
            <input type="text" name="province" id="province" class="form-control" placeholder="Province">
            <input type="number" name="postalCode" id="postalCode" class="form-control" placeholder="Postal code">
          </div>

          <div class="input-group">
            <span class="input-group-text"><ion-icon name="mail-outline"></ion-icon></span>
            <input type="email" name="email" id="email" class="form-control" placeholder="Your Email">

          </div>
          <div class="input-group">
            <span class="input-group-text"><ion-icon name="at-circle-outline"></ion-icon></span>
            <input type="text" name="username" id="username" class="form-control" placeholder="Username">
          </div>

          <div class="input-group">
            <span class="input-group-text"><ion-icon name="lock-closed-outline"></ion-icon></span>
            <input type="password" name="pass" id="pass" class="form-control" placeholder="Password" maxlength="8">
          </div>

          <label for="">Already have an account?</label>
          <button type="button" name="signup" id="signup" class="btn" data-bs-toggle="modal" data-bs-target="#signinModal">
            Sign in
          </button><br><br>


          <button type="submit" class="btn btn-dark" name="signup" id="signup">Sign Up</button>
          <button type="reset" class="btn btn-dark" name="clear">Clear</button>

        </div>
      </form>
    </div>
  </div>
</div>
</form>

<!-- modal signin -->


<div class="modal fade" id="signinModal" tabindex="-1" aria-labelledby="signinModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1>Log In</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./php/signin.php" method="post">
        <div class="modal-body">

          <div class="input-group">
            <span class="input-group-text"><ion-icon name="at-circle-outline"></ion-icon></span>
            <input type="text" class="form-control" name="username" placeholder="Username">
          </div>

          <div class="input-group">
            <span class="input-group-text"><ion-icon name="lock-closed-outline"></ion-icon></span>
            <input type="password" class="form-control" name="password" placeholder="Password">
          </div>
          <label for="">Doesn't have an account?</label>
          <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#signupModal">
            Sign up
          </button><br><br>
          <button type="submit" class="btn btn-dark" id="signin" name="signin" value="sign in">Sign In</button>
          <button type="reset" class="btn btn-transparent" name="clear">Clear</button>

        </div>
      </form>
    </div>
  </div>
</div>

<!-- admin modal signup -->
<!-- modal signup  -->
<div class="modal fade" id="adminSignupModal" tabindex="-1" aria-labelledby="adminSignupModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1>Create an Admin Account</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./php/adminSignup.php" method="post">
        <div class="modal-body">

          <div class="input-group">
            <span class="input-group-text"><ion-icon name="person-outline"></ion-icon></span>
            <input type="text" name="firstname" id="firstname" class="form-control fname" placeholder="Firstname">
          </div>

          <div class="input-group">
            <span class="input-group-text"><ion-icon name="person-outline"></ion-icon></span>
            <input type="text" name="middlename" id="middlename" class="form-control" placeholder="Middlename">
          </div>
          <div class="input-group">
            <span class="input-group-text"><ion-icon name="person-outline"></ion-icon></span>
            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Lastname">
          </div>

          <div class="input-group">
            <span class="input-group-text"><ion-icon name="call-outline"></ion-icon></span>
            <input type="number" name="contactNum" id="contactNum" class="form-control" placeholder="Contact number">
          </div>

          <div class="input-group">
            <span class="input-group-text">Address</span>
            <input type="text" name="street" id="street" class="form-control" placeholder="Building no./Street name">
            <input type="text" name="brgy" id="brgy" class="form-control" placeholder="Barangay">

          </div>

          <div class="input-group">
            <input type="text" name="city" id="city" class="form-control" placeholder="City/Municipality">
            <input type="text" name="province" id="province" class="form-control" placeholder="Province">
            <input type="number" name="postalCode" id="postalCode" class="form-control" placeholder="Postal code">
          </div>

          <div class="input-group">
            <span class="input-group-text"><ion-icon name="mail-outline"></ion-icon></span>
            <input type="email" name="email" id="email" class="form-control" placeholder="Your Email">

          </div>
          <div class="input-group">
            <span class="input-group-text"><ion-icon name="at-circle-outline"></ion-icon></span>
            <input type="text" name="username" id="username" class="form-control" placeholder="Username">
          </div>

          <div class="input-group">
            <span class="input-group-text"><ion-icon name="lock-closed-outline"></ion-icon></span>
            <input type="password" name="pass" id="pass" class="form-control" placeholder="Password">
          </div>

          <label for="">Already have an account?</label>
          <button type="button" name="signup" id="signup" class="btn" data-bs-toggle="modal" data-bs-target="#adminSigninModal">
            Sign in
          </button><br><br>


          <button type="submit" class="btn btn-dark" name="submit" id="submit">Sign Up</button>
          <button type="reset" class="btn btn-dark" name="clear">Clear</button>

        </div>
      </form>
    </div>
  </div>
</div>
<!-- admin modal sign in-->
<div class="modal fade" id="adminSigninModal" tabindex="-1" aria-labelledby="adminSigninModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1>Log In as Admin</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./php/adminSignin.php" method="post">
        <div class="modal-body">

          <div class="input-group">
            <span class="input-group-text"><ion-icon name="at-circle-outline"></ion-icon></span>
            <input type="text" class="form-control" name="username" placeholder="Username">
          </div>

          <div class="input-group">
            <span class="input-group-text"><ion-icon name="lock-closed-outline"></ion-icon></span>
            <input type="password" class="form-control" name="password" placeholder="Password">
          </div>
          <label for="">Doesn't have an account?</label>
          <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#adminSignupModal">
            Sign up
          </button><br><br>
          <button type="submit" class="btn btn-dark" id="signin" name="signin" value="sign in">Sign In</button>
          <button type="reset" class="btn btn-dark" name="clear">Clear</button>

        </div>
      </form>
    </div>
  </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasRightLabel">Recently added products</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <?php
    // Fetch recently added products by the user
    if (isset($_SESSION['customerID'])) {
      $userId = $_SESSION['customerID'];

      $selectCart = $conn->prepare("SELECT products.productImage, products.productName, products.price, cart_tbl.productsID
                                           FROM cart_tbl
                                           JOIN products ON cart_tbl.productsID = products.productsID
                                           WHERE cart_tbl.customerID = :customerID");
      $selectCart->bindParam(':customerID', $userId);
      $selectCart->execute();

      if ($selectCart->rowCount() > 0) {
        // Display each product in the offcanvas
        while ($row = $selectCart->fetch()) {
          echo '<div class="d-flex justify-content-between mb-3">';
          echo '<img src="./php/uploads/' . $row['productImage'] . '" alt="' . $row['productName'] . '" style="max-width: 80px; max-height: 80px;">';
          echo '<div>';
          echo '<p class="mb-0">' . $row['productName'] . '</p>';
          echo '<p class="mb-0">₱' . $row['price'] . '</p>';
          echo '</div>';
          echo '<button type="button" class="btn  btn-md" style="color:red;" onclick="removeProduct(' . $row['productsID'] . ')">Remove</button>';
          echo '</div>';
        }
      } else {
        echo '<h5>Your cart is empty</h5>';
      }
    } else {
      echo '<h5>Your cart is empty</h5>';
    }
    ?>
    <a href="cart2.php"><button type="button" class="btn btn-dark" style="width: 100%;">View Cart</button></a>
  </div>
</div>


</html>