<?php
// Ensure session is active to access CSRF token
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

# Logic to handle "Ready to Checkout" login flow
if (isset($_POST["login_user_with_product"])) {
    // Get product list array
    $product_list = $_POST["product_id"];
    // Convert to JSON for cookie storage
    $json_e = json_encode($product_list);
    // Create cookie (Secure flag enabled for safety)
    setcookie("product_list", $json_e, strtotime("+1 day"), "/", "", "", TRUE);
}
?>

<div class="wait overlay">
    <div class="loader"></div>
</div>

<div class="container-fluid">
    <div class="login-marg">
        
        <form onsubmit="return false" id="login" class="login100-form">
            
            <input type="hidden" name="csrf_token" value="<?php echo isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : ''; ?>">

            <div class="billing-details jumbotron" style="background: #ffffff; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                
                <div class="section-title">
                    <h2 class="login100-form-title p-b-49" style="text-align: center; font-weight: 800; color: #333; margin-bottom: 30px; text-transform: uppercase; letter-spacing: 1px;">
                        Welcome Back
                    </h2>
                </div>
                
                <div class="form-group" style="margin-bottom: 25px;">
                    <label for="email" style="font-weight: 600; color: #555; margin-bottom: 8px;">Email Address</label>
                    <input class="input input-borders" type="email" name="email" placeholder="Enter your email" id="email" required 
                           style="height: 50px; border-radius: 25px; border: 1px solid #eee; padding: 0 20px; box-shadow: inset 0 2px 5px rgba(0,0,0,0.03); width: 100%;">
                </div>
                
                <div class="form-group" style="margin-bottom: 25px;">
                    <label for="password" style="font-weight: 600; color: #555; margin-bottom: 8px;">Password</label>
                    <input class="input input-borders" type="password" name="password" placeholder="Enter your password" id="password" required
                           style="height: 50px; border-radius: 25px; border: 1px solid #eee; padding: 0 20px; box-shadow: inset 0 2px 5px rgba(0,0,0,0.03); width: 100%;">
                </div>
                
                <div class="text-right" style="margin-bottom: 30px; text-align: right;">
                    <a href="#" style="font-size: 13px; color: #D10024; font-weight: 600; transition: color 0.3s;">Forgot Password?</a>
                </div>
                
                <input class="primary-btn btn-block" type="submit" Value="Login" 
                       style="height: 50px; border-radius: 25px; font-weight: 700; font-size: 16px; background: #D10024; border: none; color: #fff; cursor: pointer; transition: all 0.3s ease; width: 100%;">
                
                <div class="panel-footer" style="background: none; border: none; margin-top: 20px; padding: 0;">
                    <div class="alert alert-danger" id="e_msg" style="display: none; border-radius: 10px; font-size: 14px; text-align: center;"></div>
                </div>

                <div class="text-center" style="margin-top: 25px; font-size: 14px; color: #666;">
                    <span>Don't have an account? </span>
                    <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#Modal_register" style="color: #D10024; font-weight: 700; margin-left: 5px;">Register Here</a>
                </div>

            </div>
        </form>
        </div>
</div>