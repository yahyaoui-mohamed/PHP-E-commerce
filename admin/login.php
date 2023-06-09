<?php 
include "../backend/connect.php";
session_start();
if(isset($_SESSION["admin"])){
  header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/admin.css"/>
  <title>Admin Login</title>
</head>
<body>
  <form class="admin-login" method="POST" action="<?php echo $_SERVER["PHP_SELF"] ?>">
    <?php 
      if($_SERVER["REQUEST_METHOD"] === "POST"){
        $email    = $_POST["email"];
        $password = $_POST["password"];
        $req = $connect->prepare("SELECT * FROM users WHERE user_email = ? AND user_password = ? AND user_priority = ?");
        $req->execute(array($email, $password, 1));
        $res = $req->fetch();
        if($req->rowCount() > 0){
          $_SESSION["admin"] = true;
          $_SESSION["user_id"] = $res[0];
          $_SESSION["user_firstname"] = $res[1];
          $_SESSION["user_lastname"] = $res[2];
          $_SESSION["user_email"] = $res[3];
          $_SESSION["admin"] = $res[4];
          header("location: index.php");
        }
        else{
          echo "Invalid email/password"; 
        }
      }
    ?>  
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Email" name="email"/>
    </div>
    <div class="form-group">
      <input type="password" class="form-control" placeholder="Password" name="password"/>
    </div>
    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Login"/>
    </div>
  </form>

</body>
</html>