<?php
// login_script.php
include "db.php";

header('Content-Type: application/json'); // Return JSON

if (isset($_POST["email"]) && isset($_POST["password"])) {
    
    // 1. CSRF Check
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(["status" => "error", "message" => "Security Validation Failed. Refresh page."]);
        exit();
    }

    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];

    try {
        $stmt = $con->prepare("SELECT * FROM user_info WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch();

        if ($row && password_verify($password, $row['password'])) {
            // 2. Prevent Session Fixation
            session_regenerate_id(true);

            $_SESSION["uid"] = $row["user_id"];
            $_SESSION["name"] = $row["first_name"];

            // Update Cart Logic
            $ip_add = $_SERVER["REMOTE_ADDR"];
            $update = $con->prepare("UPDATE cart SET user_id = ? WHERE ip_add = ? AND user_id = -1");
            $update->execute([$row["user_id"], $ip_add]);

            echo json_encode(["status" => "success", "message" => "Login Successful"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid email or password"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database error"]);
    }
}
?>