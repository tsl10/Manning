<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>REGISTRATION</title>
   <link rel="stylesheet" href="css/regs.css" type="text/css">
</head>
<body>

<?php
require_once('connection.php');
if (isset($_POST['submit_page2'])) {
    $user_id = $_GET['user_id']; // Get user ID from query string
    $dob = mysqli_real_escape_string($con, $_POST['dob']);
    $place_of_birth = mysqli_real_escape_string($con, $_POST['place_of_birth']);
    $nationality = mysqli_real_escape_string($con, $_POST['nationality']);
    $height = mysqli_real_escape_string($con, $_POST['height']);
    $weight = mysqli_real_escape_string($con, $_POST['weight']);
    $hair_color = mysqli_real_escape_string($con, $_POST['hair_color']);
    $eye_color = mysqli_real_escape_string($con, $_POST['eye_color']);
    $marital_status = mysqli_real_escape_string($con, $_POST['marital_status']);
    $father_name = mysqli_real_escape_string($con, $_POST['father_name']);
    $mother_name = mysqli_real_escape_string($con, $_POST['mother_name']);
    $home_address = mysqli_real_escape_string($con, $_POST['home_address']);

    $sql2 = "INSERT INTO personal_infor (user_id, dob, place_of_birth, nationality, height, weight, hair_color, eye_color, marital_status, father_name, mother_name, home_address) 
             VALUES ('$user_id', '$dob', '$place_of_birth', '$nationality', '$height', '$weight', '$hair_color', '$eye_color', '$marital_status', '$father_name', '$mother_name', '$home_address')";
    $result2 = mysqli_query($con, $sql2);

    if ($result2) {
        // Redi rect to page 3
        echo '<script>window.location.href = "page3.php?user_id=' . $user_id . '";</script>';
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

<button id="back"><a href="page1.php">Back</a></button>

<div class="main">
    <div class="register">

<form id="register" action="page2.php?user_id=<?php echo $_GET['user_id']; ?>" method="POST">
    <label>Date of Birth:</label><br>
    <input type="date" name="dob" required><br><br>

    
    <label>Place of Birth:</label><br>
    <input type="text" name="pob" required><br><br>

    <label>Nationality:</label><br>
    <input type="text" name="nationality" required><br><br>

    <label>Height:</label><br>
    <input type="number" name="height" required><br><br>

    <label>Weight:</label><br>
    <input type="number" name="weight" required><br><br>

    <label>Hair Color:</label><br>
    <input type="text" name="hair_color" required><br><br>

    <label>Eye Color:</label><br>
    <input type="text" name="eye_color" required><br><br>

    <label>Marital Status:</label><br>
    <input type="text" name="marital_status" required><br><br>

    <label>Father's Name:</label><br>
    <input type="text" name="father_name" required><br><br>

    <label>Mother's Name:</label><br>
    <input type="text" name="mother_name" required><br><br>

    <label>Home Address:</label><br>
    <textarea name="home_address" row = "4" col = "10"required></textarea><br><br>

    <input type="submit" value="Next" name="submit_page2">
</form>
</div>
</div>

</body>
</html>