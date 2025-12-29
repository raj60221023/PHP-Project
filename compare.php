<?php
include "header.php";
?>
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3 class="breadcrumb-header">Compare Products</h3>
				<ul class="breadcrumb-tree">
					<li><a href="index.php">Home</a></li>
					<li class="active">Compare</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- /BREADCRUMB -->

<!-- SECTION -->
<div class="section">
	<div class="container">
		<div class="row">
            <div class="col-md-12">
                <style>
                    .compare-table { width: 100%; table-layout: fixed; }
                    .compare-table th, .compare-table td { padding: 15px; text-align: center; border: 1px solid #e4e7ed; vertical-align: middle; }
                    .compare-img { width: 150px; height: 150px; object-fit: contain; }
                </style>
                <div class="table-responsive">
                    <table class="table compare-table">
                        <thead>
                            <tr>
                                <th>Feature</th>
                                <?php
                                if(isset($_SESSION['compare_ids']) && count($_SESSION['compare_ids']) > 0){
                                    foreach($_SESSION['compare_ids'] as $pid){
                                        $sql = "SELECT * FROM products WHERE product_id = '$pid'";
                                        $stmt = $con->query($sql); // PDO
                                        $row = $stmt->fetch();
                                        echo "<th>".$row['product_title']."</th>";
                                    }
                                } else {
                                    echo "<th>No products to compare</th>";
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($_SESSION['compare_ids']) && count($_SESSION['compare_ids']) > 0): ?>
                            <tr>
                                <td><strong>Image</strong></td>
                                <?php
                                    foreach($_SESSION['compare_ids'] as $pid){
                                        $sql = "SELECT * FROM products WHERE product_id = '$pid'";
                                        $stmt = $con->query($sql);
                                        $row = $stmt->fetch();
                                        echo "<td><img src='product_images/".$row['product_image']."' class='compare-img'></td>";
                                    }
                                ?>
                            </tr>
                            <tr>
                                <td><strong>Price</strong></td>
                                <?php
                                    foreach($_SESSION['compare_ids'] as $pid){
                                        $sql = "SELECT * FROM products WHERE product_id = '$pid'";
                                        $stmt = $con->query($sql);
                                        $row = $stmt->fetch();
                                        echo "<td><h4 class='product-price'>$".$row['product_price']."</h4></td>";
                                    }
                                ?>
                            </tr>
                            <tr>
                                <td><strong>Description</strong></td>
                                <?php
                                    foreach($_SESSION['compare_ids'] as $pid){
                                        $sql = "SELECT * FROM products WHERE product_id = '$pid'";
                                        $stmt = $con->query($sql);
                                        $row = $stmt->fetch();
                                        echo "<td>".substr($row['product_desc'], 0, 100)."...</td>";
                                    }
                                ?>
                            </tr>
                             <tr>
                                <td><strong>Action</strong></td>
                                <?php
                                    foreach($_SESSION['compare_ids'] as $pid){
                                        echo "<td>
                                            <button pid='$pid' id='product' class='add-to-cart-btn primary-btn'><i class='fa fa-shopping-cart'></i> Add to Cart</button>
                                        </td>";
                                    }
                                ?>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
		</div>
	</div>
</div>
<!-- /SECTION -->

<?php
include "newslettter.php";
include "footer.php";
?>
