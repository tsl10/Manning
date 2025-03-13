<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMINISTRATOR</title>
</head>
<body>
<style>
*{
    margin: 0;
    padding: 0;

}
.hai{
    width: 100%;
    /* background: linear-gradient(to top, rgba(0,0,0,0)50%, rgba(0,0,0,0)50%),url("../images/carbg2.jpg"); */
    background-position: center;
    background-size: cover;
    height: 100vh;
    animation: infiniteScrollBg 50s linear infinite;
}
.main{
    width: 100%;
    background: linear-gradient(to top, rgba(0,0,0,0)50%, rgba(0,0,0,0)50%);
    background-position: center;
    background-size: cover;
    height: 100vh;
    animation: infiniteScrollBg 50s linear infinite;
}
.navbar{
    display:flex;
    gap:30vw;
    width: 1200px;
    height: 75px;
    margin: auto;
}

.icon{
    width:200px;
    float: left;
    height : 70px;
}

.logo{
    color: #ff7200;
    font-size: 35px;
    font-family: Arial;
    padding-left: 20px;
    float:left;
    padding-top: 10px;

}
.menu{
    width: 400px;
    float: left;
    height: 70px;

}

ul{
    float: left;
    display: flex;
    justify-content: center;
    align-items: center;
}

ul li{
    list-style: none;
    margin-left: 62px;
    margin-top: 27px;
    font-size: 14px;

}

ul li a{
    text-decoration: none;
    color: black;
    font-family: Arial;
    font-weight: bold;
    transition: 0.4s ease-in-out;

}

.content-table{
   border-collapse: collapse;
    
    font-size: 0.9em;
    /* min-width: 800px; */
    border-radius: 5px 5px 0 0;
    overflow: hidden;
    box-shadow:0 0  20px rgba(0,0,0,0.15);
    margin-left : 14vw ;
    margin-top: 1.5vw;
    width: 80%;
    height: 500px;
}
.content-table thead tr{
    background-color: orange;
    color: white;
    text-align: left;
}

.content-table th,
.content-table td{
    padding: 0.625vw 0.781vw;
    font-size: 1.4vw;

}

.content-table tbody tr{
    border-bottom: 1px solid #dddddd;
}
.content-table tbody tr:nth-of-type(even){
    background-color: #f3f3f3;

}
.content-table tbody tr:last-of-type{
    border-bottom: 2px solid orange;
}

.content-table thead .active-row{
    font-weight:  bold;
    color: orange;
}


.header{
    margin-top: 70px;
    margin-left: 650px;
}



.nn{
    width:100px;
    background: #ff7200;
    border:none;
    height: 40px;
    font-size: 18px;
    border-radius: 10px;
    cursor: pointer;
    color:white;
    transition: 0.4s ease;

}


.nn a{
    text-decoration: none;
    color: black;
    font-weight: bold;
    
}

.but a{
    text-decoration: none;
    color: black;
}   

.search-container {
    text-align: center;  /* Center the content horizontally */
    margin-top: 2vw;    /* Add some space above */
}

.search-box {
    margin: 2vw 2vw;
    padding: 1vw;
    font-size: 1vw;
    width: 16vw;        /* Set width for the search input */
    border: 1px solid #ccc;
    border-radius: 5px;
}
</style>
<?php

require_once('connection.php');
$search = isset($_GET['search']) ? $_GET['search'] : '';
$query="SELECT * FROM users WHERE position_applied LIKE '%$search%' OR FNAME LIKE '%$search' OR LNAME LIKE '%$search'";
$queryy=mysqli_query($con,$query);
$num=mysqli_num_rows($queryy);


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
                    <li><a href="#">SERVICES</a></li>
                  <li> <button class="nn"><a href="index.php">LOGOUT</a></button></li>
                </ul>
            </div>
            
          
        </div>
        <div>
            <h1 class="header">USERS</h1>
            <form method="GET" action="adminusers.php">
            <input type="text" name="search" class="search-box" placeholder="Search for Users..." value="<?php echo $search; ?>">
            <button type="submit" class="nn">Search</button>
        </form>
            <div>
                <div>
                    <table class="content-table">
                <thead>
                    <tr>
                        <th>NAME</th> 
                        <th>EMAIL</th>
                        <th>Date Of Avaibility</th>
                        <th>Position Applied</th>
                        <th>PHONE NUMBER</th> 
                        <th>GENDER</th> 
                        <th>CV</th> <!-- New column for CV -->
                        <th>DELETE USERS</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                
                
                while($res=mysqli_fetch_array($queryy)){
                
                
                ?>
                <tr  class="active-row">
                    <td><?php echo $res['FNAME']."  ".$res['LNAME'];?></php></td>
                    <td><?php echo $res['EMAIL'];?></php></td>
                    <td><?php echo $res['date_available'];?></php></td>
                    <td><?php echo $res['position_applied'];?></php></td>
                    <td><?php echo $res['PHONE_NUMBER'];?></php></td>
                    <td><?php echo $res['GENDER'];?></php></td>
                    <td>
                    <?php if (!empty($res['cv'])) { ?>
                                    <!-- Provide options for the admin to view or download the CV -->
                                    <a href="uploads/<?php echo $res['cv']; ?>" target="_blank">View CV</a> | 
                                    <a href="uploads/<?php echo $res['cv']; ?>" download>Download CV</a>
                                <?php } else { ?>
                                    No CV Uploaded
                                <?php } ?>
                            </td>
                    <td><button type="submit" class="but" name="approve"><a href="deleteuser.php?id=<?php echo $res['EMAIL']?>">DELETE USER</a></button></td>
                </tr>
               <?php } ?>
                </tbody>
                </table>
                </div>
            </div>
        </div>
</body>
</html>