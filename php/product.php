
   

<?php
    
     include_once("conn.php");

     session_start();
     // saving product in the database

     if(isset($_POST['submit'])){
         $productName = htmlspecialchars($_POST['productName']);
         $description = htmlspecialchars($_POST['description']);
         $price = htmlspecialchars($_POST['price']);
         $productType = htmlspecialchars($_POST['productType']); // Added productType
         $gender = htmlspecialchars($_POST['category']); // Added gender

         $imgFile = $_FILES["productImage"]["name"];
         $temp_name = $_FILES["productImage"]["tmp_name"];
         $imgSize = $_FILES["productImage"]["size"];
         $upload_dir = "uploads/";

         $imgExt = (pathinfo($imgFile, PATHINFO_EXTENSION));

         // valid extension
         $valid_ext = array('jpeg','jpg','gif', 'png');

         // rename picture
         $newname = rand(1000,10000000).".".$imgExt;
         move_uploaded_file($temp_name, $upload_dir.$newname);

         // validation for image type and size could be added here

         $query = $conn->prepare("INSERT INTO products (productName, productDesc, price, productType, gender, productImage, date_added)
         VALUES (:pName, :productDesc, :price, :productType, :category, :pic, NOW())");
         $query->bindParam(":pName", $productName);
         $query->bindParam(":productDesc", $description);
         $query->bindParam(":price", $price);
         $query->bindParam(":productType", $productType);
         $query->bindParam(":category", $gender);
         $query->bindParam(":pic", $newname);
         $query->execute();

         echo "<script>alert('Product successfully added to the inventory. Thank you')</script>";
         echo "<script>window.open('admin.php','_self')</script>";
     }
 
?>

