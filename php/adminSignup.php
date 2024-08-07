<?php
include_once("conn.php");


if(isset($_POST['submit'])){
    $firstname = htmlspecialchars($_POST['firstname']);
    $middlename = htmlspecialchars($_POST['middlename']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $contactNum = htmlspecialchars($_POST['contactNum']);
    $street = htmlspecialchars($_POST['street']);
    $brgy = htmlspecialchars($_POST['brgy']);
    $city = htmlspecialchars($_POST['city']);
    $province = htmlspecialchars($_POST['province']);
    $postalCode = htmlspecialchars($_POST['postalCode']);
    $email = htmlspecialchars($_POST['email']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['pass']);

    $query = $conn->prepare("INSERT INTO admin_tbl (firstname, middlename, lastname, contactNum, street, brgy, city, province, postalCode, email, username, pass)
    VALUES (:fName, :mName, :lName, :Cnumber, :street, :brgy, :city, :province, :postal, :email, :username, :pword)");
    $query->bindParam(":fName",$firstname);
    $query->bindParam(":mName",$middlename);
    $query->bindParam(":lName",$lastname);
    $query->bindParam(":Cnumber",$contactNum);
    $query->bindParam(":street",$street);
    $query->bindParam(":brgy",$brgy);
    $query->bindParam(":city",$city);
    $query->bindParam(":province",$province);
    $query->bindParam(":postal",$postalCode);
    $query->bindParam(":email",$email);
    $query->bindParam(":username",$username);
    $query->bindParam(":pword",$password);
   
    $query->execute();

    echo "<script>alert('Successfully Registered as Admin. Thankyou')</script>";
    echo "<script>window.open('../index.php','_self')</script>";
}

?>