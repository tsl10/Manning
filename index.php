<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>KAMI</title>
    <script type="text/javascript">
        window.history.forward();
        function noBack() {
            window.history.forward();
        }
    </script>
    <link  rel="stylesheet" href="css/style.css">
    <script type="text/javascript">
        function preventBack() {
            window.history.forward(); 
        }
          
        setTimeout("preventBack()", 0);
          
        window.onunload = function () { null };
    </script>
</head>
<body>

<?php
require_once('connection.php');
session_start();

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pass = mysqli_real_escape_string($con, $_POST['pass']);

    if (empty($email) || empty($pass)) {
        echo '<script>alert("Please fill in all fields");</script>';
    } else {
        // Use a prepared statement to prevent SQL injection
        $query = "SELECT PASSWORD FROM users WHERE EMAIL = ?";
        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $db_password);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            // Verify the password using password_verify()
            if (password_verify($pass, $db_password)) {
                $_SESSION['email'] = $email;
                header("Location: profile.php");
                exit();
            } else {
                echo '<script>alert("Incorrect password!");</script>';
            }
        } else {
            echo '<script>alert("Error preparing the query!");</script>';
        }
    }
}
?>




    <div class="hai">
        <div class="navbar">
            <div class="icon">
                <h2 class="logo">
                    <img src="images/kmtc_logo_png.png">
                </h2>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="#">HOME</a></li>
                    <li><a href="">ABOUT</a></li>
                    <li><a href="contactus.html">CONTACT</a></li>
                  <li> <button class="adminbtn"><a href="adminlogin.php">ADMIN LOGIN</a></button></li>
                </ul>
            </div>
            
          
        </div>
        <div class="content">
            <h1><span>Lorem, ipsum.</span></h1>
            <p class="par">Lorem ipsum dolor sit.<br>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                Quidem deserunt ex eos harum repellendus accusantium quibusdam praesentium fugiat odit quas.  </p>
            <button class="cn"><a href="page1.php">JOIN US</a></button>
            <div class="form">
                <h2>Login Here</h2>
                <form method="POST"> 
                <input type="email" name="email" placeholder="Enter Email Here">
                <input type="password" name="pass" placeholder="Enter Password Here">
                <a class = "link" href="update_password.php">Reset Password</a></p>
                <input class="btnn" type="submit" value="Login" name="login"></input>
                </form>
                <p class="link">Don't have an account?<br>
                <a href="page1.php">Sign up</a> here</a></p>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
</body>
</html>