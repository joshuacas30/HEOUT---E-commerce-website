<?php
include_once("conn.php");

if (isset($_POST['signup'])) {
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

    // Check if email is already used
    $emailCheck = $conn->prepare("SELECT * FROM customer WHERE email = :email");
    $emailCheck->bindParam(":email", $email);
    $emailCheck->execute();
    $emailResult = $emailCheck->fetch(PDO::FETCH_ASSOC);

    // Check if username is already used
    $usernameCheck = $conn->prepare("SELECT * FROM customer WHERE username = :username");
    $usernameCheck->bindParam(":username", $username);
    $usernameCheck->execute();
    $usernameResult = $usernameCheck->fetch(PDO::FETCH_ASSOC);

    if ($usernameResult) {
        echo "<script>alert('Username is already used. Please choose a different username.')</script>";
        echo "<script>window.open('../index.php','_self')</script>";
    } else if ($emailResult) {
        echo "<script>alert('Email is already used. Please choose a different email.')</script>";
        echo "<script>window.open('../index.php','_self')</script>";
    } else { // If email and username are not used, proceed with registration
        $query = $conn->prepare("INSERT INTO customer (firstname, middlename, lastname, contactNum, street, brgy, city, province, postalCode, email, username, password)
        VALUES (:fName, :mName, :lName, :Cnumber, :street, :brgy, :city, :province, :postal, :email, :username, :pword)");
        $query->bindParam(":fName", $firstname);
        $query->bindParam(":mName", $middlename);
        $query->bindParam(":lName", $lastname);
        $query->bindParam(":Cnumber", $contactNum);
        $query->bindParam(":street", $street);
        $query->bindParam(":brgy", $brgy);
        $query->bindParam(":city", $city);
        $query->bindParam(":province", $province);
        $query->bindParam(":postal", $postalCode);
        $query->bindParam(":email", $email);
        $query->bindParam(":username", $username);
        $query->bindParam(":pword", $password);

        $success = $query->execute();

        if ($success) {
            echo "<script>alert('Successfully Created an Account. Thank you.')</script>";
            echo "<script>window.open('../index.php','_self')</script>";
        } else {
            echo "<script>alert('Error creating account. Please try again.')</script>";
        }
    }
}
?>
