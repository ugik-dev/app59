<?php
session_start();

if (array_key_exists('id', $_COOKIE)) {
    $_SESSION['id'] = $_COOKIE['id']; //stay logged in for long time
    
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,
				initial-scale=1.0">
    <title>Graduation register</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="responsive.css">
</head>

<body>

    <!-- for header part -->
    <header>

        <div class="logosec">
            <div class="logo">Graduation Registration</div>
            <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210182541/Untitled-design-(30).png" class="icn menuicn" id="menuicn" alt="menu-icon">
        </div>

        <!-- <div class="searchbar">
            <input type="text" placeholder="Search">
            <div class="searchbtn">
                <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210180758/Untitled-design-(28).png" class="icn srchicn" alt="search-icon">
            </div>
        </div> -->

        <!-- <div class="message">
            <div class="circle"></div>
            <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210183322/8.png" class="icn" alt="">
            <div class="dp">
                <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png" class="dpicn" alt="dp">
            </div>
        </div> -->

    </header>

    <div class="main-container">
        <div class="navcontainer">
            <nav class="nav">
                <div class="nav-upper-options">
                    <div class="nav-option option1">
                        <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210182148/Untitled-design-(29).png" class="nav-img" alt="dashboard">
                        <h3><a href=loggedInPage.php style="text-decoration: none; color : white"> Dashboard</a></h3>
                    </div>
                    <div class="nav-option option4">
						<img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210183321/6.png" class="nav-img"alt="institution">
						<h3> <a href=about.php style="text-decoration: none;">About University</a></h3>
					</div>

                    <div class="nav-option logout">
                        <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210183321/7.png" class="nav-img" alt="logout">
                        <h3> <a href=index.php?;logout=1 style="text-decoration: none;">Logout</a></h3>
                    </div>

                </div>
            </nav>
        </div>
        <div class="main">

            <!-- <div class="searchbar2">
                <input type="text" name="" id="" placeholder="Search">
                <div class="searchbtn">
                    <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210180758/Untitled-design-(28).png" class="icn srchicn" alt="search-button">
                </div>
            </div> -->

            <div class="box-container">

                <!-- <div class="box box1">
                    <div class="text"> -->
                        <!-- <h2 class="topic-heading">60.5k</h2> -->
                        <!-- <h2 class="topic">Seat Registration</h2>
                    </div> -->

                    <!-- <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210184645/Untitled-design-(31).png" alt="Views"> -->
                <!-- </div> -->

                <!-- <div class="box box2">
                    <div class="text"> -->
                        <!-- <h2 class="topic-heading">150</h2> -->
                        <!-- <h2 class="topic">Qr-Code</h2>
                    </div> -->

                    <!-- <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210185030/14.png" alt="likes"> -->
                <!-- </div> -->

                <!-- <div class="box box3">
                    <div class="text"> -->
                        <!-- <h2 class="topic-heading">320</h2> -->
                        <!-- <h2 class="topic"><a href=profile.php style="text-decoration: none; color:white"> University Profile</a></h2>
                    </div> -->

                    <!-- <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210184645/Untitled-design-(32).png" alt="comments"> -->
                <!-- </div> -->

                <!-- <div class="box box4">
                    <div class="text"> -->
                        <!-- <h2 class="topic-heading">70</h2> -->
                        <!-- <h2 class="topic">Location</h2>
                    </div> -->

                    <!-- <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210185029/13.png" alt="published"> -->
                <!-- </div> -->
            </div>

                <div class="report-body">
                <div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.8381126227764!2d107.1683576142833!3d-6.285000295451094!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6984caf54df305%3A0xb7156354ad963e4d!2sPresident%20University%2C%20Jababeka%20Education%20Park%2C%20Cikarang%2C%20Bekasi!5e0!3m2!1sen!2sid!4v1677393102044!5m2!1sen!2sid" width="1000" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./index.js"></script>
</body>

</html>