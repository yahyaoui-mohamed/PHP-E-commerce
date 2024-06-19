<?php 
session_start();
if(!isset($_SESSION["admin"])){
  header("location: login.php");
}
else{
    include "../backend/connect.php";
    $req = $connect->prepare("SELECT * FROM users WHERE user_priority = ?");
    $req->execute(array(1));
    $res = $req->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/admin.css"/>
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
  <title>Admin Dashboard</title>
</head>
<body>

<nav class="sidebar">
  <div class="admin">
    <div class="admin-img">
      <img src="../img/user.png" alt=""/>  
    </div>
    <div class="admin-info">
      <h4>
        <?php echo $res["user_lastname"];?>
      </h4>  
      <p class="email">
        <?php echo $res["user_email"];?>
      </p>
    </div>
  </div>  
<ul>
  <!-- editproduct -->
    <li <?php echo (!isset($_GET["page"]) ? "class='active'" : "") ?> ><a href="./"><i class="fi fi-rr-home"></i> Dashboard</a></li>
    <li <?php echo (isset($_GET["page"]) &&  $_GET["page"] === "cart" ? "class='active'" : "") ?> ><a href="?page=cart"><i class="fi fi-rr-shopping-cart"></i>Orders</a></li>
    <li <?php echo (isset($_GET["page"]) &&  $_GET["page"]  === "customers" ? "class='active'" : "") ?> ><a href="?page=customers"><i class="fi fi-rr-users"></i>Customers</a></li>
    <li <?php echo (isset($_GET["page"]) &&  ($_GET["page"]  === "products" || $_GET["page"]  === "productadd" || $_GET["page"]  === "editproduct") ? "class='active'" : "") ?> ><a href="?page=products"><i class="fi fi-rr-box-open"></i>Products</a></li>
    <li <?php echo (isset($_GET["page"]) &&  $_GET["page"]  === "messages" ? "class='active'" : "") ?> ><a href="?page=messages"><i class="fi fi-rr-envelope"></i>Messages</a></li>
    <li <?php echo (isset($_GET["page"]) &&  $_GET["page"]  === "settings" ? "class='active'" : "") ?> ><a href="?page=settings"><i class="fi fi-rr-settings"></i>Settings</a></li>
    <li><a href="../backend/logout.php"><i class="fi fi-rr-sign-out-alt"></i>Logout</a></li>
  </ul>
</nav>

<div class="content">
  <?php 
    if(isset($_GET["page"])){

      if($_GET["page"] === "products"){
          $query = $connect->prepare("SELECT * FROM products");
          $query->execute();
        ?>

<!-- Start Product Page -->
        <h1>List of products</h1>
        <table class="table">
          <thead>
            <a class="btn" id="add-product" href="?page=productadd"><i class="fi fi-rr-plus"></i> Add product</a>
            <tr>
              <th>Product ID</th>
              <th>Product Name</th>
              <th>Product Price</th>
              <th>Product Image</th>
              <th>Details</th>
            </tr>
      </thead>
            <?php 
              while($res = $query->fetch()){
                echo 
                "
                <tr>
                  <td>$res[0]</td>
                  <td>$res[1]</td>
                  <td>$res[2]</td>
                  <td><img src='../$res[3]'/></td>
                  <td>
                  <a href='#'><i class='fi fi-rr-eye'></i></a>
                  <a href='?page=editproduct&id=$res[0]'><i class='fi fi-rr-edit'></i></a>
                  <a href='deleteproduct?id=$res[0]'><i class='fi fi-rr-trash'></a></i> 
                  </td>
                </tr>
                ";

              }
            
            ?>
        </table>
      <?php
      }
      else if($_GET["page"] === 'editproduct'){
        $query = $connect->prepare("SELECT * FROM products WHERE product_id = ?");
        $query->execute(array($_GET["id"]));
        $product = $query->fetch();
        if($_SERVER["REQUEST_METHOD"] === "POST"){
          $path = "img/products/";
          $productname = $_POST["productname"];
          $productprice = $_POST["productprice"];
          $productimage = $_POST["productimage"];
          if(strlen($productimage) == 0){
            $productimage = $product[3];
          }
          else{
            $productimage = $path.$productimage;
          }
          $req = $connect->prepare("UPDATE products SET product_name = ?, product_price = ?, product_src = ? WHERE product_id = ?");
          $req->execute(array($productname, $productprice, $productimage, $product[0]));
          header("location: ?page=products");
        }
        ?>
        <form class="admin-settings" method="POST">
          <div class="form-group">
            <input type="text" name="productname" class="form-control" placeholder="First Name" value="<?php echo $product[1] ?>" />
          </div>

          <div class="form-group">
            <input type="number" name="productprice" class="form-control" placeholder="Last Name" value="<?php echo $product[2] ?>" />
          </div>

          <div class="form-group">
            <img src="<?php echo "../".$product[3] ;?>" />
            <input type="file" name="productimage"/>
          </div>

          <div class="form-group">
            <input type="submit" class="btn btn-primary" placeholder="Password"/>
          </div>

      </form>

        <?php
      }
      else if($_GET["page"] === 'settings'){
        ?>
    <!-- Settings Page -->

    <h1>Settings</h1>
    <?php
        if($_SERVER["REQUEST_METHOD"] === "POST"){
          $firstname = $_POST["firstname"];
          $lastname  = $_POST["lastname"];
          $email     = $_POST["email"];
          $password  = $_POST["password"];
          $req = $connect->prepare("UPDATE users SET user_firstname = ?, user_lastname = ?, user_email = ?, user_password = ? WHERE user_priority = ?");
          $_SESSION["user_email"] = $email;
          $req->execute(array($firstname, $lastname, $email, $password, 1));
          header("location:?page=settings");
        }
        $req = $connect->prepare("SELECT * FROM users WHERE user_email = ?");
        $req->execute(array($_SESSION["user_email"]));
        $res = $req->fetch();
      ?>
    <form class="admin-settings" method="POST" action="?page=settings">
        <div class="form-group">
          <input type="text" name="firstname" class="form-control" placeholder="First Name" value="<?php echo $res[1] ?>" />
        </div>

        <div class="form-group">
          <input type="text" name="lastname" class="form-control" placeholder="Last Name" value="<?php echo $res[2] ?>" />
        </div>

        <div class="form-group">
          <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $res[3] ?>" />
        </div>

        <div class="form-group">
          <input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo $res[4] ?>" />
        </div>

        <div class="form-group">
          <input type="submit" class="btn btn-primary" placeholder="Password"/>
        </div>

    </form>

<?php
      }

      else if($_GET["page"] === 'customers'){
        $query = $connect->prepare("SELECT * FROM users WHERE user_priority = 0");
        $query->execute();
        ?>

<!-- Start Product Page -->
        <h1>List of customers</h1>
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Fistname</th>
              <th>Lastname</th>
              <th>Email</th>
              <th>Registration Date</th>
            </tr>
      </thead>
            <?php 
              while($res = $query->fetch()){
                echo 
                "
                <tr>
                  <td>$res[0]</td>
                  <td>$res[1]</td>
                  <td>$res[2]</td>
                  <td>$res[3]</td>
                  <td>$res[6]</td>
                </tr>
                ";

              }
            
            ?>
        </table>
    <?php
      }
      if($_GET["page"] === "orders"){
        $query = $connect->prepare("SELECT * FROM cart ");
        $query->execute();
        ?>

<!-- Start Product Page -->
        <h1>List of orders</h1>
        <table class="table">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Product Name</th>
              <th>Date</th>
              <th>Price</th>
              <th>Status</th>
              <th></th>
            </tr>
      </thead>
            <?php 
              while($res = $query->fetch()){
                echo 
                "
                <tr>
                  <td>$res[0]</td>
                  <td>$res[1]</td>
                  <td>$res[2]</td>
                  <td>$10.00</td>
                  <td><span class='order-status order-$res[4]'>"?>
                  <?php
                  echo strtoupper($res[4][0]).substr($res[4],1);
                  ?>
                  <?php
                  echo
                  "</span></td>
                  <td>
                  <a href='#' class='dropdown-button'><i class='fi fi-rr-menu-dots-vertical'></i></a>
                    <div class='dropdown'>
                      <div class='dropdown-menu'>
                        <a href='confirm.php?id=$res[0]'><i class='fi fi-rr-check'></i>Confirm</a>
                        <a href='cancel.php?id=$res[0]'><i class='fi fi-rr-cross-small'></i></i>Cancel</a>
                      </div>
                    </div>
                  </td>
                </tr>
                ";

              }
            
            ?>
        </table>
    <?php
      }
      else if($_GET["page"] == "productadd"){
        ?>
        <h1>Add new product</h1>
<form class="admin-settings" method="POST" action="?page=productadd" enctype="multipart/form-data">
        <?php 
        if($_SERVER["REQUEST_METHOD"] === "POST"){
          $uploaddir = '../img/products/';
          $uploadfile = $uploaddir . basename($_FILES['image']['name']);
          move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
          $name  = $_POST["name"];
          $price = $_POST["price"];
          $image = substr($uploadfile, 3);
          $req = $connect->prepare("INSERT INTO products VALUES ('','$name','$price','$image',0)");
          $req->execute();
          header("location: ?page=products");
        }
        ?>
        <div class="form-group">
          <input type="text" name="name" class="form-control" placeholder="Product Name" />
        </div>

        <div class="form-group">
          <input type="number" name="price" class="form-control" placeholder="Product Price"/>
        </div>

        <div class="form-group">
          <input type="file" name="image"/>
        </div>

        <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Add"/>
        </div>

    </form>
        <?php
      }
    }

    
    else{
      $query = $connect->prepare("SELECT * FROM products");
      $query->execute();
      $products = $query->rowCount();
      
      $query = $connect->prepare("SELECT * FROM orders");
      $query->execute();
      $orders = $query->rowCount();
      
      $sales = 0;
      $query = $connect->prepare("SELECT * FROM orders WHERE order_status = 'complete'");
      $query->execute();
      while($res = $query->fetch()){
        $query1 = $connect->prepare("SELECT product_price FROM products WHERE product_id = ?");
        $query1->execute(array($res["product_id"]));
        $sales += $query1->fetch()[0];
      }

      $todaySales = 0;
      $query = $connect->prepare("SELECT * FROM orders WHERE order_status = 'complete' AND order_date = ?");
      $query->execute(array(date("Y-m-d")));
      while($res = $query->fetch()){
        $query1 = $connect->prepare("SELECT product_price FROM products WHERE product_id = ?");
        $query1->execute(array($res["product_id"]));
        $todaySales += $query1->fetch()[0];
      }
    ?>
      <h1>Dashboard</h1>
      <div class="dashboard">
        <div class="stats">
          
          <div class="stat-item">
            <a class="stat-icon">
              <i class="fi fi-rr-box-open"></i>  
            </a>
            <div class="stat-number">
              <?php echo $products;?>
            </div>
            <div class="stat-title">
                Total Products
            </div>
          </div>

          <div class="stat-item">
            <a class="stat-icon">
              <i class="fi fi-rr-basket-shopping-simple"></i>
            </a>
            <div class="stat-number">
              $<?php echo $sales; ?>.00
            </div>
            <div class="stat-title">
                Total Sales
            </div>
          </div>

          <div class="stat-item">
            <a class="stat-icon">
                <i class="fi fi-rr-shopping-cart"></i>
            </a>
            <div class="stat-number">
              <?php echo $orders; ?>
            </div>
            <div class="stat-title">
                Total Orders
            </div>
          </div>

          <div class="stat-item">
            <a class="stat-icon">
              <i class="fi fi-rr-coins"></i>
            </a>
            <div class="stat-number">
              $<?php echo $todaySales; ?>.00
            </div>
            <div class="stat-title">
                Today Sales
            </div>
          </div>

        </div>
      </div>
    <?php

    }
  ?>
</div>
<script src="main.js"></script>
</body>
</html>