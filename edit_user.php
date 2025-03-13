<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>REGISTRATION</title>
   <link rel="stylesheet" href="css/regs.css" type="text/css">
</head>
<body>

<?php
require_once('connection.php');
session_start();

// Ensure the user is logged in (i.e., email exists in session)
if (!isset($_SESSION['email'])) {
    echo "You need to log in first.";
    exit;
}

// Get the user's email from the session
$email = $_SESSION['email'];

// Fetch the user details based on the email
$query = "SELECT * FROM users WHERE EMAIL = ?";
$stmt = mysqli_prepare($con, $query);

// Check if the query preparation was successful
if (!$stmt) {
    die("Query preparation failed: " . mysqli_error($con));
}

mysqli_stmt_bind_param($stmt, "s", $email);  // "s" for string (email is a string)
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if the user exists
if ($row = mysqli_fetch_assoc($result)) {
    // Pre-fill the form with existing user data
    $fname = $row['FNAME'];
    $lname = $row['LNAME'];
    $email = $row['EMAIL'];
    $date_available = $row['date_available'];
    $position_applied = $row['position_applied'];
    $phone_number = $row['PHONE_NUMBER'];
    $gender = $row['GENDER'];
    $cv = $row['cv'];  // Assuming CV is stored as a file name
} else {
    echo "User not found!";
    exit;
}

// Handle the form submission for updating user details
if (isset($_POST['update'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $date_available = $_POST['date_available'];
    $position_applied = $_POST['position_applied'];
    $phone_number = $_POST['phone_number'];
    $gender = $_POST['gender'];

    // Check if a new CV file is uploaded
    if ($_FILES['cv']['name'] != '') {
        $cv = $_FILES['cv']['name'];
        move_uploaded_file($_FILES['cv']['tmp_name'], 'uploads/' . $cv);
    } else {
        $cv = $row['cv'];  // Keep the old CV if none is uploaded
    }

    // Create a new prepared statement for the UPDATE query
    $update_query = "UPDATE users SET 
                        FNAME = ?, 
                        LNAME = ?, 
                        EMAIL = ?, 
                        date_available = ?, 
                        position_applied = ?, 
                        PHONE_NUMBER = ?, 
                        GENDER = ?, 
                        CV = ? 
                     WHERE EMAIL = ?";

    // Prepare the statement for the update
    $update_stmt = mysqli_prepare($con, $update_query);
    
    // Check if the query preparation was successful
    if (!$update_stmt) {
        die("Update query preparation failed: " . mysqli_error($con));
    }

    // Bind the parameters for the update query
    mysqli_stmt_bind_param($update_stmt, "sssssssss", $fname, $lname, $email, $date_available, $position_applied, $phone_number, $gender, $cv, $email);

    // Execute the update query
    if (mysqli_stmt_execute($update_stmt)) {
        echo "<script>alert('Details updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating details.');</script>";
    }
    
    // Close the update statement
    mysqli_stmt_close($update_stmt);
}

// Close the select statement
mysqli_stmt_close($stmt);
?>

<style>
      body{
        background:rgb(251, 251, 251);
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


<button id="back"><a href="profile.php">HOME</a></button>
    <h1 id="fam">Edit Your Profile</h1>
 <div class="main">

<form action="edit_user.php" method="POST" enctype="multipart/form-data">
    <label>First Name: </label>
    <br>
    <input type="text" name="fname" value="<?php echo $fname; ?>" required>
    <br><br>

    <label>Last Name: </label>
    <br>
    <input type="text" name="lname" value="<?php echo $lname; ?>" required>
    <br><br>
    
    <label>Email: </label>
    <br>
    <input type="email" name="email" value="<?php echo $email; ?>" required>
    <br><br>
    
    <label>Date Of Availability: </label>
    <br>
    <input type="date" name="date_available" value="<?php echo $date_available; ?>" required>
    <br><br>
    
    <label>Position Applied: </label>
    <br>
    <input type="text" name="position_applied" value="<?php echo $position_applied; ?>" required>
    <br><br>
    
    <label>Phone Number: </label>
    <br>
    <input type="tel" name="phone_number" value="<?php echo $phone_number; ?>" required>
    <br><br>
    
    <label>Gender: </label>
    <br>
    <input type="radio" name="gender" value="male" <?php echo ($gender == 'male') ? 'checked' : ''; ?>> Male
    <input type="radio" name="gender" value="female" <?php echo ($gender == 'female') ? 'checked' : ''; ?>> Female
    <br><br>
    
    <label>Upload CV (optional): </label>
    <br>
    <input type="file" name="cv"><br><br>
    <input type="submit" name="update" value="Update Profile">
</form>

</body>
</html>
