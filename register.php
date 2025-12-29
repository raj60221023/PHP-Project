<?php
session_start();
include "db.php";

if (isset($_POST["f_name"])) {

    $f_name = $_POST["f_name"];
    $l_name = $_POST["l_name"];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $mobile = $_POST['mobile'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];

    // Validation Regex
    $name_regex = "/^[a-zA-Z ]+$/";
    $email_regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
    $number_regex = "/^[0-9]+$/";

    // Basic Validation
    if(empty($f_name) || empty($l_name) || empty($email) || empty($password) || empty($mobile) || empty($address1)){
        echo "<div class='alert alert-warning'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill all fields!</b>
              </div>";
        exit();
    }
    
    if($password != $repassword){
        echo "<div class='alert alert-warning'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Passwords do not match</b>
              </div>";
        exit();
    }

    try {
        // 1. Check if email already exists
        $sql = "SELECT user_id FROM user_info WHERE email = ? LIMIT 1";
        $stmt = $con->prepare($sql);
        $stmt->execute([$email]);
        
        if($stmt->rowCount() > 0){
            echo "<div class='alert alert-danger'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Email Address is already available. Try another.</b>
                  </div>";
            exit();
        }

        // 2. Hash the password (CRITICAL FOR SECURITY)
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // 3. Insert User
        $sql = "INSERT INTO user_info (first_name, last_name, email, password, mobile, address1, address2) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        
        if($stmt->execute([$f_name, $l_name, $email, $hashed_password, $mobile, $address1, $address2])){
            // Auto Login the user after registration
            $_SESSION["uid"] = $con->lastInsertId();
            $_SESSION["name"] = $f_name;
            
            echo "register_success";
        }
    } catch(PDOException $e) {
        echo "<div class='alert alert-danger'>Database Error: " . $e->getMessage() . "</div>";
    }
}
?>