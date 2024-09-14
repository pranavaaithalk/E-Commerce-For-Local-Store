<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WELCOME | SRI-KRISHNA STORES</title>

    <?php
    include "includes/head_links.php";
    ?>
    <link href="css/home.css" rel="stylesheet" />
</head>

<body>
    <?php
    include "includes/header.php";
    ?>

    <div class="banner-container">
        <div class="justify-content">
            <?php
                //Check if user is loging or not
                if (!isset($_SESSION["user_id"])) {
                    ?>
                    <h2 class="white pb-3">TO START SHOPPING</h2>
                    <h3 class="white pb-3">LOGIN/SIGN UP NOW</h3>
                    <span  >
                        <a id="ban_btn" href="#" data-toggle="modal" data-target="#signup-modal">
                            <i class="fas fa-user"></i>Signup
                        </a>
                        <a id="ban_btn" class="link" href="#" data-toggle="modal" data-target="#login-modal">
                            <i class="fas fa-sign-in-alt"></i>Login
                        </a>
                </span>
                <?php
                } else {
                ?>
                    <div class='nav-name'>
                        <h2 class="white pb-3">You Are Successfully Verified!</h2>
                        <h3 class="white pb-3">Go Shopping Now</h3>
                    </div>
                    <a id="ban_btn" href="shopping.php">
                        <i class="fas fa-bolt"></i>Shop Now
                    </a>
                    <a id="ban_btn" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i>Logout
                    </a>
                <?php
                }
                ?>
        </div>

    </div>


    <?php
    include "includes/signup_modal.php";
    include "includes/login_modal.php";
    include "includes/footer.php";
    ?>

</body>

</html>
