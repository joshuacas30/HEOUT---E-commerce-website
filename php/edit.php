<?php
include_once("conn.php");
// session_start();


$uid = $_GET['uid'];

$select = $conn->prepare("SELECT * FROM products WHERE productsID = :id");
$select->bindParam(":id", $uid);
			$select->execute();
			
			while($row = $select->fetch()){
				$productName = $row['productName'];
				$description = $row['productDesc'];
				$price = $row['price'];
        $productImage = $row['productImage'];
			}
			
if(isset($_POST['submit'])){
	
	$productName = $_POST['productName'];
	$description = $_POST['description'];
	$price = $_POST['price'];
 

  $imgFile = $_FILES["productImage"]["name"];
  $temp_name = $_FILES["productImage"]["tmp_name"];
  $imgSize =$_FILES["productImage"]["size"];
  $upload_dir = "uploads/";

  $imgExt = (pathinfo($imgFile, PATHINFO_EXTENSION));

      // valid extension
  $valid_ext = array('jpeg','jpg','gif', 'png');

      // rename picture
  $newname = rand(1000,10000000).".".$imgExt;
  move_uploaded_file($temp_name, $upload_dir.$newname);
	
	$query = $conn->prepare("UPDATE products SET productName = :pName, productDesc = :productDesc, price = :price, productImage = :productImage WHERE productsID = :id");
	$query->bindParam(":pName",$productName);
	$query->bindParam(":productDesc",$description);
  $query->bindParam(":price",$price);
	$query->bindParam(":productImage",$newname);
	$query->bindParam(":id", $uid);
	$query->execute();
	
	echo "<script>alert('Successfully Updated!')</script>";
	echo "<script>window.open('admin.php','_self')</script>";
	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <style>
    form {
      max-width: 600px;
      margin: 20px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    table {
      width: 100%;
    }

    th, td {
      padding: 10px;
      text-align: left;
    }

    .text-center {
      text-align: center;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    .form-control {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
    }

    button {
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      border: none;
      border-radius: 4px;
    }

    .btn-dark {
      background-color: #343a40;
      color: #fff;
    }

    .btn-dark:hover {
      background-color: #292b2c;
    }
  </style>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="2" class="text-center" style="font-size: 28px;">Edit Products</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><label for="productImage">Product Image</label></td>
                    <td><input type="file" class="form-control" id="productImage" name="productImage" accept="image/*" value="<?php echo $newname; ?>"></td>
                </tr>
                <tr>
                    <td><label for="productName">Product Name</label></td>
                    <td><input type="text" class="form-control" id="productName" name="productName" placeholder="Product Name" value="<?php echo $productName; ?>"></td>
                </tr>
                <tr>
                    <td><label for="description">Product Description</label></td>
                    <td><input type="text" class="form-control" id="description" name="description" placeholder="Product Description" value="<?php echo $description; ?>"></td>
                </tr>
                <tr>
                    <td><label for="price">Product Price</label></td>
                    <td><input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" value="<?php echo $price; ?>"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-center">
                        <button type="submit" class="btn btn-dark" id="submit" name="submit" value="submit">Update</button>
                        <button type="reset" class="btn btn-dark" name="clear">Clear</button>
                        <a href="admin.php"><button type="button" class="btn btn-dark" name="clear">Cancel</button></a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</form>


</body>
</html>