
<?php
    session_start();
    if(!isset($_SESSION['currentuser'])){
        header("Location: index.php");
        exit();
    }
    include_once "dbactions.php";
    $id=$_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>home</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <?php
    $_SESSION['error']="";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $oldpass= md5($_POST["oldpass"]);
        $newpass= $_POST["newpass"];
        $rnewpass= $_POST["rnewpass"];
        $qry="SELECT * FROM `user_details` WHERE `ID`='$id'";
        $result = getData($qry);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if($oldpass!=$row['PASSWORD']){
                    $_SESSION['error']="Your old password is incorrect.";
                } elseif($newpass != $rnewpass){
                    $_SESSION['error']="Password missmatch";
                } else{
                    $password=md5($newpass);
                    $sql="UPDATE `user_details` SET `PASSWORD`='$password' WHERE `ID`=$id";
                    if(setData($sql)==true){
                        ?>
                        <script>
                            swal({
                            title: "Password changed Successfully!",
                            text: "Use new password next time.",
                            icon: "success",
                            button: "OK"
                        });
                        window.onclick = myFunction;
                        function myFunction() {
                            location.replace("home.php");
                            }
                        </script>
                        <?php
                    }
                }
            }
        }
    }
    ?>
    <div class="container">
        <header>
            <h1><center>Welcome:&nbsp;&nbsp;&nbsp;<?php echo $_SESSION['currentuser'];?></center></h1>
            <span><a href="logout.php">Logout</a></span>
            <div class="btn_newprofile">
                <button onclick="showAddModal();">New profile</button>
            </div>
            
        </header>
        <div id="resetModal" class="wrapper">
            <h2>Reset Your Password</h2>
            <form name="resetform" method="POST">
                <label for="oldpass">Enter old Password:</label>
                <input type="text" name="oldpass" id="oldpass"><br>
                <label for="newpass">Enter new Password:</label>
                <input type="password" name="newpass" id="newpass"><br>
                <label for="rnewpass">Re-enter new Password:</label>
                <input type="password" name="rnewpass" id="rnewpass"><br>
                <label for="error" class="error"><?php echo $_SESSION['error'];?></label>
                <input type="submit" value="RESET" id="btnreset">
                <button type="button" class="btncancel" onclick="closeModal();">Cancel</button>
            </form>
        </div>
        <div class="card" id="formcard">
            <a href="form.php"><img src="images/formicon.png" alt=""></a>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>