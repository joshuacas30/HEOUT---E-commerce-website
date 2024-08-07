
<?php

include_once("./conn.php");
session_start();

// Check if the user is logged in
if (isset($_SESSION['adminID'])) {
    // User is logged in
    $username = $_SESSION['username'];
   
} else {
    // User is not logged in
    header("location: ../index.php");

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<style>
  button {
  width: 200px;
  border: none; /* Remove the border */
  outline: none; /* Remove the focus border */
  background-color: transparent;
  padding-left: 10px;
  padding-right: 10px;
  height: 80px;
  border: 2px solid transparent;
  
}



button:hover{
  background-color: black;
  color: white;

}
button ::selection{
  border: solid 2px black ;
}
@font-face {
       
       font-family: 'StretchPro.ttf';
       src: url(../fonts/StretchPro.ttf) format('truetype');
       
     }
     @font-face {
       font-family: 'LouisGeorge Cafe Bold';
       src: url(../fonts/Louis\ George\ Cafe\ Bold.ttf) format('truetype');
      
     
     }
   *{
     padding: 0;
     margin: 0;
     font-size: small;
     
   }
   
   nav{
     display:flex;
     justify-content: space-between;
     position: sticky;
     top: 0;
     z-index: 100;
     width: 100%;
     background-color: white;
     padding: 10px;
     box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
     height: 50px;
     padding-left: 40px;
     padding-right: 40px;
     font-family: 'LouisGeorge Cafe Bold';

     
   }
   .logo{
     font-family: 'StretchPro.ttf';
     font-size: 100px;
     cursor: pointer;
     

   }
   .categories{
     display: flex;
     justify-content: space-evenly;
     align-items: center;
     flex-wrap: wrap;
     padding: 0;
     font-family: 'LouisGeorge Cafe Bold';
     
      
   }

.sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
  font-family: 'LouisGeorge Cafe Bold';
  
}

.sidenav a {
  padding: 5px 5px 5px 32px;
  text-decoration: none;
  font-size: 18px;
  color: #818181;
  display: block;
  transition: 0.3s;
  font-family: 'LouisGeorge Cafe Bold';
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 80px;
  margin-top: 10px;
}

#main {
  transition: margin-left 0.5s;
  padding: 16px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}


.bx-menu{
 margin-left: -5px;
  margin-top: none;
}

.styled-table {
        width: 100%;
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 18px;
        text-align: left;
    }

    .styled-table th,
    .styled-table td {
        padding: 15px;
        border-bottom: 1px solid #ddd;
    }

    .styled-table th {
        background-color: #f2f2f2;
    }
.edit{
  display: flex;
  justify-content: center;
  width: 80px;
  padding: 5px;
  background-color: black;
  margin-bottom: 5px;
  
}
.delete{
  display: flex;
  justify-content: center;
  width: 80px;
  padding: 5px;
  background-color: black;
  margin-bottom: 5px;
}

.edit a{

  text-decoration: none;
  color: white;
  
}
.delete a{

  text-decoration: none;
  color: white;
  
}
.container{
  font-family: 'LouisGeorge Cafe Bold';
}
.main{
  font-family: 'LouisGeorge Cafe Bold';
}
.categories{
  font-size: 18px;
}
#button.clicked{
  border-color: black;

}
.categories button {
    border: 2px solid transparent; /* Initial border style */
}

.categories button.clicked {
    border-color: black; /* Border color when clicked */
} 
#product-page thead{
  background-color: black;
}



</style>

<body>
<nav>
    

      <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class='bx bx-x bx-lg'></i></a>
          <div class="text-center">
            <img src="" class="rounded" alt="...">
          </div>
        <a href="#">My Account</a>
        <a href="signout.php">Logout</a>
        
    </div>

    <span cursor:pointer onclick="openNav()" ><i class='bx bx-menu bx-lg' ></i></span>

    <div class="admin">
      <h2>WELCOME, Admin <?php echo $username; ?></h2>
    </div>
    <div class="logo">
      <h2>HEOUT</h2>
    </div>

   

    

  

  </nav>
  

<!-- Use any element to open the sidenav -->
        
        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
<div id="main">
            

    <section class="categories">
      <button id="button">Products</button>
      <button id="orderButton">Orders</button>
      <button id="userButton">Users</button>
      <button id="messButton">Messages</button>

    </section>


    <div class="container">
          <div id="product-page" style="display: block;">
          <h1 style="margin-left: 400px;">Admin - Product List</h1>
          <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addProductModal" style="margin-left: 89.7%;
          width: 90px; height: 30px; border-radius: 0;">Add Product</button>
              <center>
                  <table class="styled-table" style="margin-bottom: 50px;">
                      <thead>
                          <tr>
                              <th>Product Image</th>
                              <th>Name</th>
                              <th>Description</th>
                              <th>Price</th>
                              <th>Product Type</th>
                              <th>Category</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          <!-- fetching data from xampp -->
                          <?php
                          include_once("conn.php");
                          $select = $conn->prepare("SELECT * FROM products");
                          $select->execute();

                          while ($row = $select->fetch()) {
                              $id = $row['productsID'];
                              $productName = $row['productName'];
                              $description = $row['productDesc'];
                              $price = $row['price'];
                              $productImage = $row['productImage'];
                              $productType = $row['productType'];
                              $gender = $row['gender'];
                          ?>
                              <!-- displaying the infos of product  -->
                              <tr>
                                  <td><img src="uploads/<?php echo $productImage; ?>" alt="Picture" width="100"></td>
                                  <td><?php echo $productName; ?></td>
                                  <td><?php echo $description; ?></td>
                                  <td>₱<?php echo $price; ?></td>
                                  <td><?php echo $productType; ?></td>
                                  <td><?php echo $gender; ?></td>
                                  <td>
                                      <div class="edit"><a href="edit.php?uid=<?php echo $id; ?>" >Edit</a></div>
                                      <div class="delete"><a href="delete.php?uid=<?php echo $id; ?>" onclick="return confirm('Are you sure?, There is no coming back if you do this.')">Remove</a></div>
                                  </td>
                              </tr>
                          <?php } ?>
                      </tbody>
                  </table>
              </center>
          </div>
  </div>





      <div id="order-page" style="display: none;" >
          <h1 class="mb-4" style="margin-left: 475px;">Admin - Orders</h1>

          <table class="table table-bordered">
              <thead class="table-dark">
                  <tr>
                      <th>Order ID</th>
                      <th>Customer Name</th>
                      <th>Contact Number</th>
                      <th>Address</th>
                      <th>Product Name</th>
                      <th>Quantity</th>
                      <th>Total Price</th>
                      <th>Status</th>
                      <th>Date Order</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  // Display orders and customer details
                  $selectOrders = $conn->prepare("SELECT customer.*, order_tbl.*, products.productName
                                                  FROM order_tbl
                                                  INNER JOIN customer ON order_tbl.customerID = customer.customerID
                                                  INNER JOIN products ON order_tbl.productsID = products.productsID
                                                  ORDER BY order_tbl.orderID DESC");
                  $selectOrders->execute();

                  while ($orderRow = $selectOrders->fetch(PDO::FETCH_ASSOC)) {
                      $orderId = $orderRow['orderID'];
                      $customerName = $orderRow['firstname'] . ' ' . $orderRow['lastname'];
                      $contactNumber = $orderRow['contactNum'];
                      $address = $orderRow['street'] . '' . $orderRow['brgy'] . ' ' . $orderRow['city'] . ', ' . $orderRow['province'] . ' ' . $orderRow['postalCode'];
                      $street = $orderRow['street'];
                      $brgy = $orderRow['brgy'];
                      $city = $orderRow['city'];
                      $postalCode = $orderRow['postalCode'];
                      $productName = $orderRow['productName'];
                      $quantity = $orderRow['quantity'];
                      $totalPrice = $orderRow['totalPrice'];
                      $orderStatus = $orderRow['orderStatus'];
                      $dateOrder = $orderRow['date_order'];

                      echo "<tr>";
                      echo "<td><strong>$orderId</strong></td>";
                      echo "<td>$customerName</td>";
                      echo "<td>$contactNumber</td>";
                      echo "<td>$address</td>";
                      echo "<td>$productName</td>";
                      echo "<td>$quantity</td>";
                      echo "<td>₱" . number_format($totalPrice, 2) . "</td>";
                      echo "<td><span class='badge bg-info'>$orderStatus</span></td>";
                      echo "<td>$dateOrder</td>";
                      echo "</tr>";
                  }
                  ?>
              </tbody>
          </table>
      </div>

      
  <?php
        include_once("conn.php");
        

        // Fetch all user data from the database except for the password
        $selectUsers = $conn->prepare("SELECT firstname, middlename, lastname, contactNum, street, brgy, city, province, postalCode, email, username FROM customer");
        $selectUsers->execute();

        // Display the fetched user information in a styled table
        echo '<div id="user-page" style="display: none;">';
        echo '<h1 style="margin-left: 475px;">User Information</h1>';
        echo '<table class="styled-table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Name</th>';
        echo '<th>Contact Number</th>';
        echo '<th>Street</th>';
        echo '<th>Barangay</th>';
        echo '<th>City</th>';
        echo '<th>Province</th>';
        echo '<th>Postal Code</th>';
        echo '<th>Email</th>';
        echo '<th>Username</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($userRow = $selectUsers->fetch()) {
            $userName = $userRow['firstname'] . ' ' . $userRow['middlename'] . ' ' . $userRow['lastname'];
            $contactNum = $userRow['contactNum'];
            $street = $userRow['street'];
            $brgy = $userRow['brgy'];
            $city = $userRow['city'];
            $province = $userRow['province'];
            $postalCode = $userRow['postalCode'];
            $email = $userRow['email'];
            $username = $userRow['username'];

            echo '<tr>';
            echo '<td>' . $userName . '</td>';
            echo '<td>' . $contactNum . '</td>';
            echo '<td>' . $street . '</td>';
            echo '<td>' . $brgy . '</td>';
            echo '<td>' . $city . '</td>';
            echo '<td>' . $province . '</td>';
            echo '<td>' . $postalCode . '</td>';
            echo '<td>' . $email . '</td>';
            echo '<td>' . $username . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
?>

<style>
    .styled-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .styled-table th,
    .styled-table td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    .styled-table th {
        background-color: #f2f2f2;
    }
</style>


      
      <div id="mess-page" style="display: none;">
        <h1>Customer's Messages</h1>
        <p>Messages</p>
        <img src="product-image.jpg" alt="Product Image">
      </div>
</div>

 

    
    

<!-- add products modal -->

<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1>Add Products</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="product.php" method="post" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="input-group">
                        <label for="productType">Product Type</label>
                        <select class="form-control" id="productType" name="productType">
                            <option value="Shirt">Shirt</option>
                            <option value="Short">Short</option>
                            <option value="Hoodie">Hoodie</option>
                        </select>
                    </div>
                     <div class="input-group">
                        <label for="category">Category</label>
                        <select class="form-control" id="category" name="category">
                            <option value="Men">Men</option>
                            <option value="Women">Women</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="productImage">Product Image</label>
                        <input type="file" class="form-control" id="productImage" name="productImage" placeholder="productImage">
                    </div>

                    <div class="input-group">
                        <label for="productName">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="productName" placeholder="product name">
                    </div>

                    <div class="input-group">
                        <label for="description">Product Description</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="description">
                    </div>

                    <div class="input-group">
                        <label for="price">Product Price</label>
                        <input type="text" class="form-control" name="price" placeholder="Enter price">
                    </div>

                    <button type="submit" class="btn btn-dark" id="submit" name="submit" value="submit" style="width: 70px; height: 35px;">Add</button>
                    <button type="reset" class="btn btn-dark" name="clear" style="width: 70px; height: 35px;">Clear</button>

                </div>
            </form>
        </div>
    </div>
</div>

<!-- edit product modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
                <h1>Edit Products</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <form action="edit.php" method="post" enctype="multipart/form-data">
              <div class="modal-body">
              <div class="input-group">
                        <label for="productType">Product Type</label>
                        <select class="form-control" id="productType" name="productType">
                            <option value="Shirt">Shirt</option>
                            <option value="Short">Short</option>
                            <option value="Hoodie">Hoodie</option>
                        </select>
                    </div>
                     <div class="input-group">
                        <label for="category">Category</label>
                        <select class="form-control" id="category" name="category">
                            <option value="Men">Men</option>
                            <option value="Women">Women</option>
                        </select>
                    </div>
                  
                <div class="input-group">
                  <label for="productImage">Product Image</label>
                  <input type="file" class="form-control" id="productImage" name="productImage" placeholder="productImage">
                </div>

                <div class="input-group">
                  <label for="productName">Product Name</label>
                  <input type="text" class="form-control" id="productName" name="productName" placeholder="product name">
                </div>

                <div class="input-group">
                  <label for="description">Product Description</label>
                  <input type="text" class="form-control" id="description"name="description" placeholder="description">
                </div>

                <div class="input-group">
                  <label for="price">Product Price</label>
                  <input type="text" class="form-control" name="price" placeholder="Enter price">
                </div>
               
                <button type="submit" class="btn btn-dark" id="submit" name="submit" value="submit">Update</button>
                <button type="reset" class="btn btn-dark" name="clear">Clear</button>
          
              </div>
            </form>  
        </div>
      </div>
    </div>


</body>
<script>

    function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
    }

    function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
    }
</script>
   
  <script>

  // JavaScript code for the functions
function showProductPage() {
  // Use getElementById() to get the product page and the order page elements
  var productPage = document.getElementById("product-page");
  var orderPage = document.getElementById("order-page");
  var userPage = document.getElementById("user-page");
  var messPage = document.getElementById("mess-page");
  // Use style.display to change the visibility of the elements
  productPage.style.display = "block";
  orderPage.style.display = "none";
  userPage.style.display = "none";
  messPage.style.display = "none";
}

function showOrderPage() {
  // Use getElementById() to get the product page and the order page elements
  var productPage = document.getElementById("product-page");
  var orderPage = document.getElementById("order-page");
  var userPage = document.getElementById("user-page");
  var messPage = document.getElementById("mess-page");
  // Use style.display to change the visibility of the elements
  productPage.style.display = "none";
  orderPage.style.display = "block";
  userPage.style.display = "none";
  messPage.style.display = "none";
}
function showUserPage() {
  // Use getElementById() to get the product page and the order page elements
  var productPage = document.getElementById("product-page");
  var orderPage = document.getElementById("order-page");
  var userPage = document.getElementById("user-page");
  var messPage = document.getElementById("mess-page");
  // Use style.display to change the visibility of the elements
  productPage.style.display = "none";
  orderPage.style.display = "none";
  userPage.style.display = "block";
  messPage.style.display = "none";
}

function showMessPage() {
  // Use getElementById() to get the product page and the order page elements
  var productPage = document.getElementById("product-page");
  var orderPage = document.getElementById("order-page");
  var userPage = document.getElementById("user-page");
  var messPage = document.getElementById("mess-page");
  // Use style.display to change the visibility of the elements
  productPage.style.display = "none";
  orderPage.style.display = "none";
  userPage.style.display = "none";
  messPage.style.display = "block";
}

// Use getElementById() to get the button elements
var button = document.getElementById("button");
var orderButton = document.getElementById("orderButton");
var userButton = document.getElementById("userButton");
var messButton = document.getElementById("messButton");
// Use onclick to assign the functions to the buttons
button.onclick = showProductPage;
orderButton.onclick = showOrderPage;
userButton.onclick = showUserPage;
messButton.onclick = showMessPage;


</script>
<script>document.addEventListener('DOMContentLoaded', function () {
    var buttons = document.querySelectorAll('.categories button');

    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            // Remove 'clicked' class from all buttons
            buttons.forEach(function (btn) {
                btn.classList.remove('clicked');
            });

            // Add 'clicked' class to the clicked button
            this.classList.add('clicked');
        });
    });
});
</script>



<!-- <script>
  $(document).ready(function(){
  // attach a click event handler to the button
  $("#submit").click(function(){
    // load the data from product.php into a div element
    $("#container").load("../prodMen.php");
  });
});

</script> -->

</html>