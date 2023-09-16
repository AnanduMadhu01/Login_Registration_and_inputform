<?php
    include_once "dbactions.php";
    session_start();
?>
<!DOCTYPE html>
<!-- Coding By CodingNepal - www.codingnepalweb.com -->
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <title>Login form</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="wrapper">
    <?php
      $_SESSION['email']=$_SESSION['error']="";
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email= $_POST["email"];
        $_SESSION['email']=$email;
        $pass= md5($_POST["pass"]);
        $qry="SELECT * FROM `user_details` WHERE `EMAIL`='$email'";
        $result = getData($qry);
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            if($pass == $row['PASSWORD']){
              $_SESSION['currentuser']=$row['NAME'];
              $_SESSION['id']=$row['ID'];
              ?>
              <script>
                swal({
                title: "Login Successfull!",
                text: "Welcome <?php echo $row['NAME'];?>!",
                icon: "success",
                button: "OK"
                });
                window.onclick = myFunction;
                function myFunction() {
                  location.replace("home.php");
                }
              </script>
              <?php
            } else{
              $_SESSION['error']="Username and password donot match.";
            }
          }
        } else{
          $_SESSION['error']="Email donot exist.";
        }
      }
    ?>
    <form name="loginform" method="POST">
      <h2>Login</h2>
      <div class="input-field">
        <input type="text" name="email" id="email" value="<?php echo $_SESSION['email']; ?>" required>
        <label>Enter your email</label>
      </div>
      <div class="input-field">
        <input type="password" name="pass" id="pass" required>
        <label>Enter your password</label>
      </div>
      <div class="error">
        <label id="error_message"><?php echo $_SESSION['error'];?></label>
      </div>
      <button type="submit" name="btnlogin">Log In</button>
      <div class="register">
        <p>Don't have an account? <a href="registration.php">Register</a></p>
      </div>
    </form>
  </div>
</body>
</html>