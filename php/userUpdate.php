<?php
include_once("conn.php");

if (isset($_POST['submit'])) {
    $customerId = htmlspecialchars($_POST['customerId']); // Assuming you have a form field for selecting a customer to update
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

    // Check if email is already used by another user
    $emailCheck = $conn->prepare("SELECT * FROM customer WHERE email = :email AND customerID != :customerId");
    $emailCheck->bindParam(":email", $email);
    $emailCheck->bindParam(":customerId", $customerId);
    $emailCheck->execute();
    $emailResult = $emailCheck->fetch(PDO::FETCH_ASSOC);

    // Check if username is already used by another user
    $usernameCheck = $conn->prepare("SELECT * FROM customer WHERE username = :username AND customerID != :customerId");
    $usernameCheck->bindParam(":username", $username);
    $usernameCheck->bindParam(":customerId", $customerId);
    $usernameCheck->execute();
    $usernameResult = $usernameCheck->fetch(PDO::FETCH_ASSOC);

    if ($usernameResult) {
        echo "<script>alert('Username is already used. Please choose a different username.')</script>";
        echo "<script>window.open('../index.php','_self')</script>";
    } else if ($emailResult) {
        echo "<script>alert('Email is already used. Please choose a different email.')</script>";
        echo "<script>window.open('../index.php','_self')</script>";
    } else { // If email and username are not used, proceed with the update
        $query = $conn->prepare("UPDATE customer SET
            firstname = :fName,
            middlename = :mName,
            lastname = :lName,
            contactNum = :Cnumber,
            street = :street,
            brgy = :brgy,
            city = :city,
            province = :province,
            postalCode = :postal,
            email = :email,
            username = :username,
            password = :pword
        WHERE customerID = :customerId");

        $query->bindParam(":customerId", $customerId);
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
            echo "<script>alert('Successfully Updated Account Information.')</script>";
            echo "<script>window.open('userAcc.php','_self')</script>";
        } else {
            echo "<script>alert('Error updating account information. Please try again.')</script>";
        }
    }
}
?>


