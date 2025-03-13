<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAMI</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    .hai {
        width: 100%;
        background-position: center;
        background-size: cover;
        height: 109vh;
        animation: infiniteScrollBg 50s linear infinite;
    }
    .navbar {
        display: flex;
        gap: 20vw;
        width: 1200px;
        height: 75px;
        margin: auto;
    }
    .icon {
        width: 200px;
        float: left;
        height: 70px;
    }
    .logo {
        color: #ff7200;
        font-size: 35px;
        font-family: Arial;
        padding-left: 20px;
        float: left;
        padding-top: 10px;
    }
    .menu {
        width: 400px;
        float: left;
        height: 70px;
    }
    ul {
        float: left;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    ul li {
        list-style: none;
        margin-left: 62px;
        margin-top: 27px;
        font-size: 1.2vw;
    }
    ul li a {
        text-decoration: none;
        color: black;
        font-family: Arial;
        font-weight: bold;
        transition: 0.4s ease-in-out;
    }
    .user-info {
        margin: 30px auto;
        padding: 20px;
        width: 80%;
        background: rgba(255, 255, 255, 0.8);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        font-size: 1.2vw;
    }
    .user-info div {
        margin-bottom: 10px;
    }
    .user-info h2 {
        color: black;
        background-color: #89cff0;
        margin-bottom: 4vw;
        font-size: 2vw;
    }
    .user-info span {
        font-weight: bold;
        margin-right: 10px;
        min-width: 180px; / Ensures all labels take the same width for proper colon alignment /
        display: inline-block;
        text-align: right;
    }
    .logout-btn:hover {
        background-color: #ff5722;
    }
    .form-row {
        display: flex;
        flex-direction: row;
        gap: 15vw;
        justify-content: space-evenly;
    }
    .form-row .one, .form-row .two {
        display: flex;
        align-items: center;
        width: 50%;
    }
    .nn {
        width: 100px;
        background: #ff7200;
        border: none;
        height: 40px;
        font-size: 18px;
        border-radius: 10px;
        cursor: pointer;
        color: white;
        transition: 0.4s ease;
    }
    .one-entity {
        / margin-left: 11vw; /
    }
    .logout-btn {
        width: 100%;
        text-align: center;
    }
</style>
</head>
<body>
<?php
require_once('connection.php');
session_start();

// Prepare the query with a placeholder for the email
$query = "
    SELECT u.*, p.*, pi.* 
    FROM users u
    LEFT JOIN passport_info p ON u.user_id = p.user_id
    LEFT JOIN personal_infor pi ON u.user_id = pi.user_id
    LEFT JOIN admin a ON u.EMAIL = a.ADMIN_ID
    WHERE u.EMAIL = ?";

$stmt = mysqli_prepare($con, $query);

// Check if the query preparation was successful
if (!$stmt) {
    die("Query preparation failed: " . mysqli_error($con));
}

$email = $_SESSION['email'];  // Assuming the email is stored in the session after login
mysqli_stmt_bind_param($stmt, "s", $email);  // "s" for string (email is a string)

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

// Check if any rows were returned
if ($result) {
    // Fetch the user's data
    $user_data = mysqli_fetch_array($result);

    // Display the user data in vertical format
    echo '<div class="hai">
            <div class="navbar">
                <div class="icon">
                    <a href="index.html" class="logo">
                    <img src="images/kmtc_logo_png.png" class="logo" alt=""></a>
                </div>
                <div class="menu">
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><button class="nn"><a href="index.php">LOGOUT</a></button></li>
                    </ul>
                </div>
            </div>';

    echo '<div class="user-info">
            <h2>User Information</h2>
            <div class = "form-row">
            <div class = "one">
            <span>First Name:</span>' . htmlspecialchars($user_data['FNAME']) . '
            </div>
            <div class = "two">
            <span>Last Name:</span>' . htmlspecialchars($user_data['LNAME']) . '
            </div>
            </div>
            <br>
            <div class = "form-row">
            <div class = "one">
            <span>Email:</span>' . htmlspecialchars($user_data['EMAIL']) . '
            </div>
            <div class = "two">
            <span>Date Available:</span>' . htmlspecialchars($user_data['date_available']) . '
            </div>
            </div>
            <br>
            <div class = "form-row">
            <div class = "one">
            <span>Position Applied:</span>' . htmlspecialchars($user_data['position_applied']) . '
            </div>
            <div clss = "two">
            <span>Phone Number:</span>' . htmlspecialchars($user_data['PHONE_NUMBER']) . '
            </div>
            </div>
            <br>
            <div class = "one-entity">
            <span>Gender:</span>' . htmlspecialchars($user_data['GENDER']) . '
            </div>
            <br>
            <br>
            <h2>Personal Information</h2>
            <div class = "form-row">
            <div class = "one">
            <span>Date of Birth:</span>' . htmlspecialchars($user_data['dob']) . '
            </div>
            <div class = "two">
            <span>Place of Birth:</span>' . htmlspecialchars($user_data['place_of_birth']) . '
            </div>
            </div>
            <br>
            <div class = "form-row">
            <div class = "one">
            <span>Nationality:</span>' . htmlspecialchars($user_data['nationality']) . '
            </div>
            <div class = "two">
            <span>Height(cm):</span>' . htmlspecialchars($user_data['height']) . ' 
            </div>
            </div>
            <br>
            <div class = "form-row">
            <div class = "one">
            <span>Weight(kg):</span>' . htmlspecialchars($user_data['weight']) . ' 
            </div>
            <div class = "two">
            <span>Hair Color:</span>' . htmlspecialchars($user_data['hair_color']) . '
            </div>
            </div>
            <br>
            <div class = "form-row">
            <div class = "one">
            <span>Eye Color:</span>' . htmlspecialchars($user_data['eye_color']) . '
            </div>
            <div class = "two">
            <span>Marital Status:</span>' . htmlspecialchars($user_data['marital_status']) . '
            </div>
            </div>
            <br>
            <div class = "form-row">
            <div class = "one">
            <span>Father Name:</span>' . htmlspecialchars($user_data['father_name']) . '
            </div>
            <div class = "two">
            <span>Mother Name:</span>' . htmlspecialchars($user_data['mother_name']) . '
            </div>
            </div>
            <br>
            <div class = "one-entity">
            <span>Home Address:</span>' . htmlspecialchars($user_data['home_address']) . '
            </div>
            <br>
            <br>
            <h2>Passport Information</h2>
            <div class = "form-row">
            <div class = "one">
            <span>Passport No:</span>' . htmlspecialchars($user_data['passport_no']) . '
            </div>
            <div class = "two">
            <span>Issued Date:</span>' . htmlspecialchars($user_data['issued_date']) . '
            </div>
            </div>
            <br>
            <div class = "form-row">
            <div class = "one">
            <span>Issued Place:</span>' . htmlspecialchars($user_data['issued_place']) . '
            </div>
            <div class = "two">
            <span>Expiring Date:</span>' . htmlspecialchars($user_data['expiring_date']) . '
            </div>
            </div>
            <br>
            <div class = "form-row">
            <div class = "one">
            <span>Issued By:</span>' . htmlspecialchars($user_data['issued_by']) . '
            </div>
            <div class = "two">
            <span>Seaman Book No:</span>' . htmlspecialchars($user_data['seaman_book_no']) . '
            </div>
            </div>
            <br>
            <div class = "form-row">
            <div class = "one">
            <span>Seaman Book Issued Date:</span>' . htmlspecialchars($user_data['seaman_book_issued_date']) . '
            </div>
            <div class = "two">
            <span>Seaman Book Expiring Date:</span>' . htmlspecialchars($user_data['seaman_book_expiring_date']) . '
            </div>
            </div>
            <br>
            <div class = "one-entity">
            <span>Seaman Book Issued By:</span>' . htmlspecialchars($user_data['seaman_book_issued_by']) . '
            </div>
          </div>';

    echo '<a href="edit_user.php" class="logout-btn">Edit</a></div>';

} else {
    echo "No user found.";
}

// Close the prepared statement and the database connection
mysqli_stmt_close($stmt);
mysqli_close($con);
?>
</body>
</html>

