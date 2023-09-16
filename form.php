<?php
include_once "dbactions.php";
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Form</title>
        <link rel="stylesheet" href="https://codepen.io/gymratpacks/pen/VKzBEp#0">
        <link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link rel="stylesheet" href="css/form.css">
        <script src="js/script.js"></script>
        <style>
            .captcha{
                border: 2px solid green;
                background:blue;
                text-align:center;
                width:25%;
                color:#fff;
                fond-size:24px;
                fond-weight:700;
                padding:6px 5px;
                
            }
            #captcha{
                width: 50%;
                margin-right:20px;
            }
        </style>
    </head>
    <body>
        <?php
        $rand=rand(9999,1000);
        session_start();
        $_SESSION['error']="";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name= $_POST["user_name"];
            $email= $_POST["user_email"];
            $pass= $_POST["user_password"];
            $dob= $_POST["date"];
            $mob= $_POST["number"];

            if(isset($_POST['gender'])){
                $gender=$_POST['gender'];
            } else{
                $gender="";
            }

            $address= $_POST["address"];
            $interestArray=array();
            $rand_number=$_POST['ran_captcha'];
            $entered_captcha=$_POST['captcha'];
            if (isset($_POST['interest']) && is_array($_POST['interest'])) {
                foreach ($_POST['interest'] as $selectedOption) {
                    array_push($interestArray,htmlspecialchars($selectedOption) );
                }
                $jsonData = json_encode($interestArray);
            } else {
                $_SESSION['error']="No options selected.";
            }
            $job=$_POST['user_job'];

            $uploadDirectory = 'files/'; // Specify the directory where you want to save uploaded PDFs
            // Get the file information
            $fileName = $_FILES['pdfFile']['name'];
            $tmpFileName = $_FILES['pdfFile']['tmp_name'];
            // Generate a unique file name to prevent overwriting existing files
            $uniqueFileName = uniqid() . '_' . $fileName;


            //serverside validation
            if( $name=="" || $email=="" || $pass=="" || $dob=="" || $mob=="" || $gender=="" || $address=="" || $jsonData=="" || $job=="" || $uniqueFileName==""){
                $_SESSION['error']="All fields are required";
            }else if($rand_number != $entered_captcha){
                ?>
                <script type="text/javascript">
                    alert("captcha error.");
                    break;
                </script>
                <?php
            } else {
                $sql ="INSERT INTO `form_details`(`NAME`, `EMAIL`, `PASSWORD`, `DOB`, `MOB`, `INTERESTS`, `GENDER`, `ADDRESS`, `JOB`, `RESUME`) VALUES ('$name','$email','$pass','$dob','$mob','$jsonData','$gender','$address','$job','$uniqueFileName')";
                if(setData($sql)==true){
                    // Move the uploaded file to the desired directory
                    if (move_uploaded_file($tmpFileName, $uploadDirectory . $uniqueFileName)) {
                        ?>
                        <script>
                            swal({
                            title: "Form Submitted Successfully!",
                            text: "Thank you!",
                            icon: "success",
                            button: "OK"
                        });
                        window.onclick = myFunction;
                        function myFunction() {
                            location.replace("home.php");
                            }
                        </script>
                        <?php
                    } else {
                        ?>
                        <script>
                            swal({
                                title: "Failed!",
                                text: "Issues while moving file!",
                                icon: "warning",
                                button: "OK"
                                });
                            window.onclick = myFunction;
                            function myFunction() {
                                location.replace("form.php");
                            }
                        </script>
                        <?php
                    }
                } else{
                    ?>
                    <script>
                        swal({
                            title: "Failed!",
                            text: "Issues while connecting to the database!",
                            icon: "warning",
                            button: "OK"
                            });
                        window.onclick = myFunction;
                        function myFunction() {
                            location.replace("form.php");
                        }
                    </script>
                    <?php
                }
            }
         }
        ?>
        <div class="row">
            <div class="col-md-12">
                <form id="form" name="myform" method="POST" enctype="multipart/form-data">
                    <h1> Form with all the inputs </h1>
                    
                    <fieldset>
                        <label for="name">Name:</label>
                        <input type="text" min=2 id="name" name="user_name" required>
                        <label for="name_msg" id="name_msg"></label>
                        
                        <label for="email">Email:</label>
                        <input type="email" id="mail" name="user_email" required>
                        <label for="email_msg" id="email_msg"></label>
                    
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="user_password" required>
                        <label for="msg-pass" id="pass-msg"></label>

                        <label for="date">Date of birth:</label>
                        <input type="date" id="date" name="date" max="2023-01-01" required>
                        <label for="msg-pass" id="date-msg"></label>

                        <label for="number">Mobile No:</label>
                        <input type="number" id="number" name="number" required>
                        <label for="msg-num" id="mob-msg"></label>

                        <label>Interests:</label>
                        <input type="checkbox" id="c1" value="development" name="interest[]"><label class="light" for="development">Development</label>
                        <input type="checkbox" id="c2" value="design" name="interest[]"><label class="light" for="design">Design</label>
                        <input type="checkbox" id="c3" value="business" name="interest[]"><label class="light" for="business">Business</label>
                        <label for="msg" id="interest_msg"></label>

                        <label>Gender:</label>
                        <input type="radio" id="male" value="male" name="gender"><label for="under_13" class="light">Male</label>
                        <input type="radio" id="female" value="female" name="gender"><label for="over_13" class="light">Female</label><br>
                        <label for="gntr_msg" id="gntr_msg"></label>
                        
                        <label for="bio">Address:</label>
                        <textarea id="bio" name="address" required></textarea>
                        <label for="msg-address" id="address_msg"></label>

                        <label for="job">Job Role:</label>
                        <select id="job" name="user_job">
                            <option value="frontend_developer">Front-End Developer</option>
                            <option value="php_developer">PHP Developer</option>
                            <option value="python_developer">Python Developer</option>
                        </select>

                        <label for="date">Upload Resume:(.pdf)</label>
                        <input type="file" id="file" name="pdfFile" required>
                        <label for="msg-file" id="file_msg"></label>

                        <input type="hidden" id="ran_captcha" name="ran_captcha" value="<?php echo $rand; ?>">
                        <label for="captcha">Captcha Code:</label>
                        <input type="number" id="captcha" name="captcha" required>
                        <div class="captcha"><?php echo $rand;?></div><br>
                        <label for="msg-captcha" id="captcha_msg"></label>
                    </fieldset>
                    <button type="reset" name="reset" onClick="reset()">Reset</button>
                    <button type="button" value="Upload" onclick="validate()">Upload</button>
                </form>
            </div>
        </div>
    </body>
</html>
