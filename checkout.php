<?php
include "includes/navbar.php";
include "backend/connect.php";
$query = $connect->prepare("SELECT * FROM cart WHERE user_id = ?");
$query->execute(array($_SESSION['user_id']));


?>


<div class="container-fluid">
    <h1 class='wish-list-title'>Checkout</h1>
    <?php 
        echo 
        "
        <table class='wishlist-table'>
        <tr>
            <td>#</td>
            <td>Product</td>
            <td>Description</td>
            <td>Price</td>
        </tr>
        ";
        while($row = $query->fetch()){
            $query1 = $connect->prepare("SELECT * FROM products WHERE product_id = ?");
            $query1->execute(array($row[1]));
            while($row1 = $query1->fetch()){
                ?>
                <tr>
                    <td><?= $row1[0]?></td>
                    <td><img src="<?php echo $row1['product_src']; ?>" alt=></td>
                    <td><?php echo $row1['product_name']; ?></td>
                    <td><?php echo $row1['product_price']; ?></td>
                    <input type="hidden" value=<?php echo $row1['product_id']; ?>>
                </tr>
                <?php
            }
        }
        echo "
        <tr>
        <td colspan=3>Total:</td>
        <td><a class='btn btn-primary' href='checkout'>Proceed to check out</a></td>
        </tr>
        </table>
        ";
    
    ?>

</div>






<?php
include "includes/footer.php";