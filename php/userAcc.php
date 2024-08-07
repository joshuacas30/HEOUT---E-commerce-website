<?php
include_once("conn.php");

session_start();
// Check if the user is logged in
if (isset($_SESSION['customerID'])) {
    // User is logged in
    $username = $_SESSION['username'];
} else {
    // User is not logged in
    $username = "Guest";
}

// Check if the user is logged in
if (isset($_SESSION['customerID'])) {
    // User is logged in
    $username = $_SESSION['username'];
    $customerID = $_SESSION['customerID'];

    // Fetch customer information from the database
    $query = $conn->prepare("SELECT * FROM customer WHERE customerID = :customerID");
    $query->bindParam(':customerID', $customerID);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);
} else {
    // User is not logged in
    $username = "Guest";
}


// Check if the user is logged in
if (isset($_SESSION['customerID'])) {
    $userId = $_SESSION['customerID'];

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect updated information from the form
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $contactNum = $_POST['contactNum'];
        $street = $_POST['street'];
        $brgy = $_POST['brgy'];
        $city = $_POST['city'];
        $province = $_POST['province'];
        $postalCode = $_POST['postalCode'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['pass'];  // Assuming this is the new password, adjust as needed

        // Update customer information in the database
        $updateQuery = $conn->prepare("UPDATE customer SET firstname = :fname, middlename = :mname, lastname = lname, contactNum = :contactNum, street = :street, brgy = :brgy, city = :city, province = :province, postalCode = :postalCode, email = :email, username = : username, password = :password WHERE customerID = :customerId");
        $updateQuery->bindParam(':fname', $firstname);
        $updateQuery->bindParam(':mname', $middlename);
        $updateQuery->bindParam(':lname', $lastname);
        $updateQuery->bindParam(':contactNum', $contactNum);
        $updateQuery->bindParam(':street', $street);
        $updateQuery->bindParam(':brgy', $brgy);
        $updateQuery->bindParam(':city', $city);
        $updateQuery->bindParam(':province', $province);
        $updateQuery->bindParam(':postalCode', $postalCode);
        $updateQuery->bindParam(':email', $email);
        $updateQuery->bindParam(':username', $username);
        $updateQuery->bindParam(':password', $password);
        $updateQuery->bindParam(':customerId', $userId);

        if ($updateQuery->execute()) {
            echo "<script>alert('Account information updated successfully.')</script>";
        } else {
            echo "<script>alert('Failed to update account information.')</script>";
        }
    }

    // Fetch the user's information
    $selectUser = $conn->prepare("SELECT * FROM customer WHERE customerID = :customerId");
    $selectUser->bindParam(':customerId', $userId);
    $selectUser->execute();
    $user = $selectUser->fetch();
} else {
    // Redirect or handle if the user is not logged in
    header("Location: ../index.php");
    exit();
}

// Check if the user is logged in
if (isset($_SESSION['customerID'])) {
    // User is logged in
    $userId = $_SESSION['customerID'];

    // Fetch orders for the logged-in user from order_tbl
    $selectOrders = $conn->prepare("SELECT order_tbl.*, products.* FROM order_tbl 
                                    INNER JOIN products ON order_tbl.productsID = products.productsID
                                    WHERE order_tbl.customerID = :customerID");
    $selectOrders->bindParam(':customerID', $userId);
    $selectOrders->execute();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/userAcc.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <title>My Account</title>
</head>

<style>
    * {
        padding: 0;
        margin: 0;
        font-size: small;
        font-family: Arial, Helvetica, sans-serif;

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
        margin-right: 0px;
        

    }

    .menu-right a {
        /* background-color: red; */
        text-decoration: none;
        color: black;
    }

    .dropdown:hover>.dropdown-menu {
        display: block;
        font-family: Arial, Helvetica, sans-serif;

    }

    .dropdown>.dropdown-toggle:active {
        /*Without this, clicking will make it sticky*/
        pointer-events: none;

    }
    footer {
        display: grid;
        place-items: center;
        padding: 20px;
        width: 100%;
        height: 300px;

        background-color: white;
        text-decoration: none;
        font-size: 24px;

    }

    footer a {
        text-decoration: none;
        color: black;
    }

    main {
        display: flex;
        justify-content: inline-block;
    }

    * {
        padding: 0;
        margin: 0;
    }

    .image-container {
        text-align: center;
        /* Center the content horizontally */
        padding: 20px;
        /* Add padding for spacing */
        border: 1px solid #ddd;
        /* Add a border for visual separation */
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 20px;
        /* Adjust the padding value as needed */
        text-align: left;
    }

    th {
        white-space: nowrap;
        background-color: #f2f2f2;
    }

    #autoExpandingInput {
        width: 100px;
        min-height: 20px;
        padding: 10px;
        box-sizing: border-box;
        overflow-y: hidden;
        resize: none;
    }

    .sideBar {
        padding: 10px;
    }

 

    tfoot {
        white-space: nowrap;
    }



    * {
        padding: 0;
        margin: 0;
        font-size: small;

    }

    .bx-menu {
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


    .categories {
        font-size: 18px;
    }

    .categories button {
        border: 2px solid transparent;
        /* Initial border style */
    }


    #product-page thead {
        background-color: black;
    }

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

    footer {
        width: 100%;
        min-height: 200px;
        border-top: solid 1px black;
        background-color: black;
        color: white;
    }

    footer a {
        text-decoration: none;
        color: white;
    }

    .secondary-header {
        width: 100%;
        display: flex;
        justify-content: space-around;
        place-items: center;
        border-bottom: 1px solid black;
        color: white;
        padding-bottom: 40px;
        padding-top: 40px;
    }

    .secondary-nav {
        display: flex;


    }
    .secondary-nav ul {
        list-style: none;
        gap: 2rem;

    }

    .socials {
        width: 100%;
        height: fit-content;
        display: flex;
        justify-content: center;
        place-items: center;
        gap: 2rem;
        margin-top: 20px;

    }

    .secondary-logo span {
        font-size: 2vw;
        font-weight: 700;
        cursor: pointer;
    }
</style>

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
            <a href="../index.php">Home</a>
            <!-- cart -->
            <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                <i class='bx bx-cart bx-sm bx-tada-hover'></i></button>
            <!-- account -->
            <div class="dropdown">
                <button class="btn " type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false"><i class='bx bx-user bx-tada-hover bx-sm'></i></button>
                <ul class="dropdown-menu dropdown-menu-end">
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




    <body>


        <!-- Use any element to open the sidenav -->

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main">

            <!-- <section class="categories">
            <button id="messButton">Personal Informations</button>
            <button id="orderButton">My orders</button>
        </section>
     -->

            <div class="container">

                <div id="mess-page" style="display: block;">
                    <form action="userUpdate.php" method="post" enctype="multipart/form-data">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="text-center" style="font-size: 28px;">Personal Information</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td><label for="fullname">Fullname</label></td>
                                        <td><input type="text" class="form-control" id="fullname" name="fullname" " value=" <?php echo $user['firstname']; ?> <?php echo $user['middlename']; ?> <?php echo $user['lastname']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="address">Address</label></td>
                                        <td><input type="text" class="form-control" id="address" name="address" value="<?php echo $user['street']; ?>, <?php echo $user['brgy']; ?>, <?php echo $user['city']; ?>,
<?php echo $user['province']; ?>, <?php echo $user['postalCode']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="contactNum">Contact Number</label></td>
                                        <td><input type="number" class="form-control" id="contactNum" name="contactNum" value="<?php echo $user['contactNum']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="email">Email</label></td>
                                        <td><input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="username">Username</label></td>
                                        <td><input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="password">Password</label></td>
                                        <td><input type="passowrd" maxlength="8" class="form-control" id="password" name="password" value="<?php echo $user['password']; ?>"></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <button type="submit" class="btn btn-dark" id="submit" name="submit" value="submit">Update</button>
                                            <button type="reset" class="btn btn-dark" name="clear">Clear</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <input type="hidden" name="customerID" id="customerID" value="<?php echo $customerID; ?>">
                        </div>
                    </form>


                    <div id="order-page" style="display: block;">
                        <h1 style="margin-left: 480px;">My Orders</h1>
                        <center>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $grandTotal = 0; // Initialize grand total

                                    // Display orders and details
                                    while ($orderRow = $selectOrders->fetch(PDO::FETCH_ASSOC)) {
                                        $orderId = $orderRow['orderID'];
                                        $productName = $orderRow['productName'];
                                        $price = $orderRow['price'];
                                        $quantity = $orderRow['quantity'];
                                        $totalPrice = $orderRow['totalPrice'];
                                        $orderStatus = $orderRow['orderStatus'];

                                        echo "<tr>";
                                        echo "<td><strong>$orderId</strong></td>";
                                        echo "<td>$productName</td>";
                                        echo "<td>₱" . number_format($price, 2) . "</td>";
                                        echo "<td>$quantity</td>";
                                        echo "<td>₱" . number_format($totalPrice, 2) . "</td>";
                                        echo "<td><span class='badge bg-info'>$orderStatus</span></td>";
                                        echo "</tr>";

                                        // Accumulate total price for grand total
                                        $grandTotal += $totalPrice;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td><strong>Grand Total: ₱<?php echo number_format($grandTotal, 2); ?></strong></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </center>
                    </div>


                </div>
            </div>




            <script>
                function openNav() {
                    document.getElementById("mySidenav").style.width = "250px";
                    document.getElementById("main").style.marginLeft = "250px";
                }

                function closeNav() {
                    document.getElementById("mySidenav").style.width = "0";
                    document.getElementById("main").style.marginLeft = "0";
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
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var buttons = document.querySelectorAll('.categories button');

                    buttons.forEach(function(button) {
                        button.addEventListener('click', function() {
                            // Remove 'clicked' class from all buttons
                            buttons.forEach(function(btn) {
                                btn.classList.remove('clicked');
                            });

                            // Add 'clicked' class to the clicked button
                            this.classList.add('clicked');
                        });
                    });
                });
            </script>


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
            <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


    </body>

</html>