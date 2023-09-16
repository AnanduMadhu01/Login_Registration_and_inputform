<?php
    include_once "dbactions.php";
?>
<!DOCTYPE html>
<!-- Coding By CodingNepal - www.codingnepalweb.com -->
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration form</title>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body>
   
  <div class="wrapper">
  <?php
  function validateEmail($email) {
    return (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email))
              ? FALSE : TRUE;
      }
      
    $_SESSION['name']=$_SESSION['email']=$_SESSION['error']="";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name= $_POST["name"];
        $_SESSION['name']=$name;

        $email= $_POST["email"];
        $_SESSION['email']=$email;
        if(!validateEmail($_POST["email"])) {
          $_SESSION['error']="Enter a valid Email.";
        }
        else {
          $email= $_POST["email"];
          $_SESSION['email']=$email;
          $pass= $_POST["pass"];
          $rpass= $_POST["repass"];
          $qry="SELECT * FROM `user_details` WHERE `EMAIL`='$email'";
          $result = getData($qry);
          if ($result->num_rows != 0) {
              $_SESSION['error']="Email aldrady exist.";
          } else if($pass != $rpass){
              $_SESSION['error']="Password missmatch.";
          } else{
              // $newpass=password_hash($pass,PASSWORD_BCRYPT);
              $newpass=md5($pass);
              $sql="INSERT INTO `user_details`(`f1`,`NAME`, `EMAIL`, `PASSWORD`) VALUES ('$name','$email','$newpass')";
              if(setData($sql)==true){
                  ?>
                  <script>
                      swal({
                      title: "Registration Successfull!",
                      text: "You can Login now!",
                      icon: "success",
                      button: "OK"
                  });
                  window.onclick = myFunction;
                  function myFunction() {
                      location.replace("index.php");
                      }
                  </script>
                  <?php
              }
          }
        }
    }
    ?>
    <form name="registrationform" method="POST">
      <h2>Register</h2>
      <div class="input-field">
        <input type="text" name="name" id="name" value="<?php echo $_SESSION['name']; ?>" required>
        <label>Enter your Name</label>
      </div>
      <div class="input-field">
        <input type="email" name="email" id="email" value="<?php echo $_SESSION['email']; ?>" required>
        <label>Enter your email</label>
      </div>
      <div class="input-field">
        <input type="password" name="pass" id="pass" required>
        <label>Enter your password</label>
      </div>
      <div class="input-field">
        <input type="password" name="repass" id="repass" required>
        <label>Re-enter your password</label>
      </div>
      <div class="error">
        <label id="error_message"><?php echo $_SESSION['error'];?></label>
      </div>
      <button type="submit" name="button" id="btnregister">Register</button>
      <div class="register">
        <p>Have an account? <a href="index.php">Login</a></p>
      </div>
    </form>
  </div>
</body>
</html>