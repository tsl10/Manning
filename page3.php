<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>REGISTRATION</title>
   <link rel="stylesheet" href="css/regs.css" type="text/css">
</head>
<body>

<?php
require_once('connection.php');
if (isset($_POST['submit_page3'])) {
    $user_id = $_GET['user_id'];
    $passport_no = mysqli_real_escape_string($con, $_POST['passport_no']);
    $issued_date = mysqli_real_escape_string($con, $_POST['issued_date']);
    $issued_place = mysqli_real_escape_string($con, $_POST['issued_place']);
    $expiring_date = mysqli_real_escape_string($con, $_POST['expiring_date']);
    $issued_by = mysqli_real_escape_string($con, $_POST['issued_by']);
    $seaman_book_no = mysqli_real_escape_string($con, $_POST['seaman_book_no']);
    $seaman_book_issued_date = mysqli_real_escape_string($con, $_POST['seaman_book_issued_date']);
    $seaman_book_expiring_date = mysqli_real_escape_string($con, $_POST['seaman_book_expiring_date']);
    $seaman_book_issued_by = mysqli_real_escape_string($con, $_POST['seaman_book_issued_by']);

    $sql3 = "INSERT INTO passport_info (user_id, passport_no, issued_date, issued_place, expiring_date, issued_by, seaman_book_no, seaman_book_issued_date, seaman_book_expiring_date, seaman_book_issued_by) 
             VALUES ('$user_id', '$passport_no', '$issued_date', '$issued_place', '$expiring_date', '$issued_by', '$seaman_book_no', '$seaman_book_issued_date', '$seaman_book_expiring_date', '$seaman_book_issued_by')";
    $result3 = mysqli_query($con, $sql3);

    if ($result3) {
      // Redirect with PHP header
      
      header("Location: psucess.php");
      exit; // Make sure to call exit after header redirection to prevent further script execution
    } else {
      echo '<script>alert("Error saving data.")</script>';
    }
  
}

?>
<style>
      body{
        background:  #fdcd3b;
        background-size: auto;
         background-position:unset;
         /* background-repeat: ; */
      }
      input#psw{
    width:300px;
    border:1px solid #ddd;
    border-radius: 3px;
    outline: 0;
    padding: 7px;
    background-color: #fff;
    box-shadow:inset 1px 1px 5px rgba(0,0,0,0.3);
}
input#cpsw{
    width:300px;
    border:1px solid #ddd;
    border-radius: 3px;
    outline: 0;
    padding: 7px;
    background-color: #fff;
    box-shadow:inset 1px 1px 5px rgba(0,0,0,0.3);
}
  #message {
  display:none;
  background: #f1f1f1;
  color: #000;
  position: relative;
  padding: 20px;
  
  width: 400px;
  margin-left:1000px;
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
}</style> 

<button id="back"><a href="page2.php">Back</a></button>

<div class="main">
    <div class="register">

<form id="register" action="page3.php?user_id=<?php echo $_GET['user_id']; ?>" method="POST">
    <label>Passport Number:</label><br>
    <input type="text" name="passport_no" maxlength="10" required><br><br>

    <label>Passport Issued Date:</label><br>
    <input type="date" name="issued_date" required><br><br>

    <label>Passport Place:</label><br>
    <input type="text" name="issued_place" required><br><br>

    <label>Passport Expiry Date:</label><br>
    <input type="date" name="expiring_date" required><br><br>

    <label>Issued by Government:</label><br>
    <input type="text" name="issued_by" required><br><br>

    <label>National Seaman's Book Number:</label><br>
    <input type="text" name="seaman_book_no" maxlength="10" required><br><br>

    <label>National Seaman's Book Issued Date:</label><br>
    <input type="date" name="seaman_book_issued_date" required><br><br>

    <label>National Seaman's Book Expiry Date:</label><br>
    <input type="date" name="seaman_book_expiring_date" required><br><br>

    <label>Issued by Government:</label><br>
    <input type="text" name="seaman_book_issued_by" required><br><br>

    <input type="submit" value="Next" name="submit_page3">
</form>
</div>
</div>

</body>
</html>