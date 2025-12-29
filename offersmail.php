<?php
include "db.php";

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";

    if (empty($email)) {
        echo "
            <div class='alert alert-warning'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <b>PLease Fill this field..!</b>
            </div>
        ";
        exit();
    } else {
        if (!preg_match($emailValidation, $email)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>this $email is not valid..!</b>
                </div>
            ";
            exit();
        }
        
        // FIX: Replaced mysqli_query with PDO Prepare/Execute
        try {
            // Check if email already exists
            $stmt = $con->prepare("SELECT email_id FROM email_info WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            $count_email = $stmt->rowCount(); // Replaced mysqli_num_rows

            if ($count_email > 0) {
                echo "
                    <div class='alert alert-danger'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <b>Email is already available</b>
                    </div>
                ";
                exit();
            } else {
                // Insert new email
                $sql = "INSERT INTO email_info (email) VALUES (?)";
                $stmt = $con->prepare($sql);
                if ($stmt->execute([$email])) {
                    echo "
                        <div class='alert alert-success'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <b>Thanks for subscribing</b>
                        </div>
                    ";
                }
            }
        } catch (PDOException $e) {
            echo "
                <div class='alert alert-danger'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Database Error: " . $e->getMessage() . "</b>
                </div>
            ";
        }
    }
}
?>