<?php
include_once("./php/conn.php");

session_start();
if (isset($_POST['customerOrder'])){
    
        if (isset($_SESSION['customerID'])) {
            $customerId = $_SESSION['customerID'];
            $customerId = $_POST['productsID'];
            $quantity = $_POST['quantities'];
            $totalPrice = $_POST['totalPrice'];

            // Start a transaction to ensure consistency
      

    
                // Insert order data into the order_tbl
                $insertOrder = $conn->prepare("INSERT INTO order_tbl (customerID, productID, quantity, totalPrice, date_order) VALUES (:customer_id, :product_id, :quantity, :total_price, NOW())");

                // Loop through each product in the cart
                
                        // Insert order data
                        $insertOrder->bindParam(':customer_id', $customerId);
                        $insertOrder->bindParam(':product_id', $productId);
                        $insertOrder->bindParam(':quantity', $quantity);
                        $insertOrder->bindParam(':total_price', $totalPrice);
                        $insertOrder->execute();
                    }
    }


?>
