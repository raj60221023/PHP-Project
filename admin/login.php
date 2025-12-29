<?php
include "db.php";
session_start();

// Check if data is received via POST
if(isset($_POST["email"]) && isset($_POST["password"])){
    $email = $_POST["email"];
    $password = $_POST["password"];

    // 1. Check if email exists using Prepared Statement (Secure)
    try {
        $sql = "SELECT * FROM user_info WHERE email = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$email]);
        
        // Fetch the user data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();

        // 2. Verify Password (using password_verify for security)
        // Note: If you have old users with plain text passwords, they need to reset them 
        // or you must create a new user to test this secure logic.
        if($count == 1 && password_verify($password, $row["password"])){
            $_SESSION["uid"] = $row["user_id"];
            $_SESSION["name"] = $row["first_name"];
            
            echo "true"; // This response is sent back to main.js to reload the page
        } else {
            echo "Invalid Email or Password";
        }
    } catch(PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }
}
?>