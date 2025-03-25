<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

<!DOCTYPE html>
<html lang="en">

<head>

  <title>REGISTRATION</title>
  <link rel="stylesheet" href="css/regs.css" type="text/css">
</head>

<body>

  <?php

require_once('connection.php');

// if (isset($_POST['send_otp'])) {
//   $email = $_POST['email'];

//   // Generate a random OTP
//   $otp = rand(100000, 999999);

//   // Store OTP in session
//   $_SESSION['otp'] = $otp;
//   $_SESSION['otp_email'] = $email;

//   // Send OTP to email
//   $subject = "Your OTP Code";
//   $message = "Your OTP code is: $otp";
//   $headers = "From: no-reply@kami.com";

//   if (mail($email, $subject, $message, $headers)) {
//       echo '<script>alert("OTP sent to your email.")</script>';
//   } else {
//       echo '<script>alert("Failed to send OTP. Please try again.")</script>';
//   }
// }



if(isset($_POST['regs']))
{
    
    $fname=mysqli_real_escape_string($con,$_POST['fname']);
    $lname=mysqli_real_escape_string($con,$_POST['lname']);
    $email=mysqli_real_escape_string($con,$_POST['email']);
    $date_available=mysqli_real_escape_string($con,$_POST['date_available']);
    $position_applied=mysqli_real_escape_string($con,$_POST['position_applied']);
    $ph=mysqli_real_escape_string($con,$_POST['ph']);
    $pass=mysqli_real_escape_string($con,$_POST['pass']);
    $cpass=mysqli_real_escape_string($con,$_POST['cpass']);
    $gender=mysqli_real_escape_string($con,$_POST['gender']);
    $Pass=md5($pass);
    if(empty($fname)|| empty($lname)|| empty($email)|| empty($date_available)|| empty($position_applied)|| empty($ph)|| empty($pass) || empty($gender))
    {
        echo '<script>alert("please fill the place")</script>';
    }
    else{
        if($pass==$cpass){
        $sql2="SELECT *from users where EMAIL='$email'";
        $res=mysqli_query($con,$sql2);
        if(mysqli_num_rows($res)>0){
            echo '<script>alert("EMAIL ALREADY EXISTS PRESS OK FOR LOGIN!!")</script>';
            echo '<script> window.location.href = "index.php";</script>';

        }
        else{
          $cv_new_name = null;
            // Handling the file upload
            if (isset($_FILES['cv']) && $_FILES['cv']['error'] === 0) {
                $cv_name = $_FILES['cv']['name'];
                $cv_tmp_name = $_FILES['cv']['tmp_name'];
                $cv_size = $_FILES['cv']['size'];
                $cv_error = $_FILES['cv']['error'];

                // Check if the file was uploaded successfully
                if($cv_error === 0){
                    $cv_ext = pathinfo($cv_name, PATHINFO_EXTENSION);
                    $cv_ext = strtolower($cv_ext);

                    // Allow only certain file types
                    $allowed = array('pdf', 'doc', 'docx');
                    if(in_array($cv_ext, $allowed)){
                        // Create uploads directory if it doesn't exist
                        if (!file_exists('uploads')) {
                            mkdir('uploads', 0755, true);
                        }

                        // Save the file in the 'uploads' folder
                        $cv_new_name = uniqid('', true) . '.' . $cv_ext;
                        $cv_dest = 'uploads/' . $cv_new_name;
                        
                        // Debug information
                        error_log("Attempting to move file from: " . $cv_tmp_name . " to: " . $cv_dest);
                        
                        if (move_uploaded_file($cv_tmp_name, $cv_dest)) {
                            error_log("File uploaded successfully to: " . $cv_dest);
                        } else {
                            error_log("Error moving file. PHP error: " . error_get_last()['message']);
                            echo '<script>alert("Error moving the file. Please check server logs.")</script>';
                            exit;
                        }
                    } else {
                        echo '<script>alert("Only PDF, DOC, or DOCX files are allowed.")</script>';
                        exit;
                    }
                } else {
                    error_log("File upload error code: " . $cv_error);
                    echo '<script>alert("Error uploading file. Error code: ' . $cv_error . '")</script>';
                    exit;
                }
            } else {
                $cv_new_name = null;
            }
            $sql="insert into users (FNAME,LNAME,EMAIL,date_available,position_applied,PHONE_NUMBER,PASSWORD,GENDER,CV) 
                values('$fname','$lname','$email', '$date_available' , '$position_applied' ,$ph,'$Pass','$gender','$cv_new_name')";
            $result = mysqli_query($con,$sql);
          

          // $to_email = $email;
          // $subject = "NO-REPLY";
          // $body = "THIS MAIL CONTAINS YOUR AUTHENTICATION DETAILS....\nYour Password is $pass and Your Registered email is $to_email"
          //          ;
          // $headers = "From: sender email";
          
          // if (mail($to_email, $subject, $body, $headers))
          
          // {
          //     echo "Email successfully sent to $to_email...";
          // }
          
          // else
 
          // {
          // echo "Email sending failed!";
          // }
        if($result){
           // echo '<script>alert("Registration Successful Press ok to login")</script>';
           $user_id = mysqli_insert_id($con);
           echo '<script>window.location.href = "page2.php?user_id=' . $user_id . '";</script>';       
           }
        else{
            echo '<script>alert("please check the connection")</script>';
        }
    
        }

        }
        else{
            echo '<script>alert("PASSWORD DID NOT MATCH")</script>';
            echo '<script> window.location.href = "register.php";</script>';
        }
    }
}


?>
  <style>
    body {
      background: #fdcd3b;
      background-size: auto;
      background-position: unset;
      /* background-repeat: ; */
    }

    input#psw {
      width: 300px;
      border: 1px solid #ddd;
      border-radius: 3px;
      outline: 0;
      padding: 7px;
      background-color: #fff;
      box-shadow: inset 1px 1px 5px rgba(0, 0, 0, 0.3);
    }

    input#cpsw {
      width: 300px;
      border: 1px solid #ddd;
      border-radius: 3px;
      outline: 0;
      padding: 7px;
      background-color: #fff;
      box-shadow: inset 1px 1px 5px rgba(0, 0, 0, 0.3);
    }

    #message {
      display: none;
      background: #f1f1f1;
      color: #000;
      position: relative;
      padding: 20px;

      width: 400px;
      margin-left: 1000px;
      margin-top: -500px;
    }

    #message p {
      padding: 10px 35px;
      font-size: 18px;
    }

    /* Add a green text color and a checkmark when the requirements are right */
    .valid {
      color: green;
    }

    .valid:before {
      position: relative;
      left: -35px;
      content: "✔";
    }

    /* Add a red text color and an "x" icon when the requirements are wrong */
    .invalid {
      color: red;
    }

    .invalid:before {
      position: relative;
      left: -35px;
      content: "✖";
    }

    select#positionSelect{
      width:300px;
      border:1px solid #ddd;
      border-radius: 3px;
      outline: 0;
      padding: 7px;
      background-color: #fff;
      box-shadow:inset 1px 1px 5px rgba(0,0,0,0.3);
    }
  </style>

  <button id="back"><a href="index.php">HOME</a></button>
  <h1 id="fam">JOIN OUR FAMILY</h1>
  <div class="main">

    <div class="register">
      <h2>Register Here</h2>

      <form id="register" action="page1.php" method="POST" enctype="multipart/form-data">
        <label>First Name : </label>
        <br>
        <input type="text" name="fname" id="name" placeholder="Enter Your First Name" required>
        <br><br>

        <label>Last Name : </label>
        <br>
        <input type="text" name="lname" id="name" placeholder="Enter Your Last Name" required>
        <br><br>

        <label>Email: </label><br>
        <input type="email" name="email" id="email" placeholder="Enter Valid Email" required><br><br>

        <label>Date Of Avaibility : </label>
        <br>
        <input type="date" name="date_available" id="name" required min="<?php echo date('Y-m-d'); ?>">
        <br><br>

        <labels>Position Applied:</label>
        <br>
        <input type="text" name="position_applied" id="position_applied" placeholder="Enter Your Last Name" required>
        <br><br>

        <label for="ph">Phone Number: </label>
        <input type="tel" id="ph" name="ph" maxlength="10" onkeypress="return onlyNumberKey(event)" placeholder="Enter Your Phone Number" required>
        <br><br>

        <label>Upload CV (PDF, DOC, DOCX) : </label>
        <input type="file" name="cv" accept=".pdf,.doc,.docx" required>

        <!-- Download Sample CV link -->
        <p>Download the <a href="uploads/Crew CV blank form.pdf" download>sample CV</a> here.</p>
        <br><br>

        <label>Password : </label>
        <br>
        <input type="password" name="pass" maxlength="12" id="psw" placeholder="Enter Password"
          pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
          title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
          required>
        <br><br>
        
        <label>Confirm Password : </label>
        <br>
        <input type="password" name="cpass" id="cpsw" placeholder="Renter the password" required>
        <br><br>

        <tr>
          <td>
            <label">Gender : </label>
          </td><br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td>
            <label for="one">Male</label>
            <input type="radio" id="input_enabled" name="gender" value="male" style="width:200px">
          </td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <td>
            <label for="two">Female</label>
            <input type="radio" id="input_disabled" name="gender" value="female" style="width:160px" />
          </td>
        </tr>
        <br><br>

        <input type="submit" class="btnn" value="REGISTER" name="regs" style="background-color: #ff7200;color: white">



        </input>

      </form>
    </div>
  </div>
  <div id="message">
    <h3>Password must contain the following:</h3>
    <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
    <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
    <p id="number" class="invalid">A <b>number</b></p>
    <p id="length" class="invalid">Minimum <b>8 characters</b></p>
  </div>
  <script>
    var myInput = document.getElementById("psw");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");

    // When the user clicks on the password field, show the message box
    myInput.onfocus = function () {
      document.getElementById("message").style.display = "block";
    }

    // When the user clicks outside of the password field, hide the message box
    myInput.onblur = function () {
      document.getElementById("message").style.display = "none";
    }

    // When the user starts to type something inside the password field
    myInput.onkeyup = function () {
      // Validate lowercase letters
      var lowerCaseLetters = /[a-z]/g;
      if (myInput.value.match(lowerCaseLetters)) {
        letter.classList.remove("invalid");
        letter.classList.add("valid");
      } else {
        letter.classList.remove("valid");
        letter.classList.add("invalid");
      }

      // Validate capital letters
      var upperCaseLetters = /[A-Z]/g;
      if (myInput.value.match(upperCaseLetters)) {
        capital.classList.remove("invalid");
        capital.classList.add("valid");
      } else {
        capital.classList.remove("valid");
        capital.classList.add("invalid");
      }

      // Validate numbers
      var numbers = /[0-9]/g;
      if (myInput.value.match(numbers)) {
        number.classList.remove("invalid");
        number.classList.add("valid");
      } else {
        number.classList.remove("valid");
        number.classList.add("invalid");
      }

      // Validate length
      if (myInput.value.length >= 8) {
        length.classList.remove("invalid");
        length.classList.add("valid");
      } else {
        length.classList.remove("valid");
        length.classList.add("invalid");
      }
    }
  </script>
  <script>
    function onlyNumberKey(evt) {

      // Only ASCII character in that range allowed
      var ASCIICode = (evt.which) ? evt.which : evt.keyCode
      if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
      return true;
    }
  </script>
    <script src="script.js"></script>
</body>

</html>