<?php
session_start();
include "db.php";

if (isset($_SESSION["uid"])) {

    $f_name = $_POST["firstname"];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip= $_POST['zip'];
    $cardname= $_POST['cardname'];
    $cardnumber= $_POST['cardNumber'];
    $expdate= $_POST['expdate'];
    $cvv= $_POST['cvv'];
    $user_id=$_SESSION["uid"];
    $cardnumberstr=(string)$cardnumber;
    $total_count=$_POST['total_count'];
    $prod_total = $_POST['total_price'];
    
    try {
        // Get Max Order ID
        $sql2 = "SELECT MAX(order_id) AS max_val from `orders_info`";
        $stmt = $con->query($sql2);
        $row = $stmt->fetch();
        $order_id = $row['max_val'];
        $order_id = $order_id + 1;

        // Insert Order Info
        $sql = "INSERT INTO `orders_info` 
        (`order_id`,`user_id`,`f_name`, `email`,`address`, 
        `city`, `state`, `zip`, `cardname`,`cardnumber`,`expdate`,`prod_count`,`total_amt`,`cvv`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $con->prepare($sql);
        $stmt->execute([
            $order_id, $user_id, $f_name, $email, 
            $address, $city, $state, $zip, 
            $cardname, $cardnumberstr, $expdate, $total_count, $prod_total, $cvv
        ]);

        // Insert Order Products
        $i = 1;
        while($i <= $total_count) {
            $prod_id = $_POST['prod_id_'.$i];
            $prod_price = $_POST['prod_price_'.$i];
            $prod_qty = $_POST['prod_qty_'.$i];
            
            $sub_total = (int)$prod_price * (int)$prod_qty;
            
            $sql1 = "INSERT INTO `order_products` 
            (`order_pro_id`,`order_id`,`product_id`,`qty`,`amt`) 
            VALUES (NULL, ?, ?, ?, ?)";
            
            $stmt1 = $con->prepare($sql1);
            $stmt1->execute([$order_id, $prod_id, $prod_qty, $sub_total]);
            
            $i++;
        }

        // Clear Cart
        $del_sql = "DELETE from cart where user_id=?";
        $stmt_del = $con->prepare($del_sql);
        $stmt_del->execute([$user_id]);

        // Redirect
        echo "<script>alert('Order placed successfully!'); window.location.href='index.php';</script>";

    } catch(PDOException $e) {
        echo $e->getMessage();
    }
    
} else {
    echo "<script>window.location.href='index.php'</script>";
}
?>