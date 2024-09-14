<?php
session_start();
require "includes/database_connect.php";

if (!isset($_SESSION["user_id"])) {
    header("location: index.php");
    die();
}
$user_id=$_SESSION["user_id"];
$total_price=0;
$sq1 = "SELECT full_name, address FROM users WHERE id=$user_id";
$add = mysqli_query($conn,$sq1);
if(!$add)
{
    echo "Something went wrong!";
    return;
}
$add = mysqli_fetch_assoc($add);
if (!$add) {
    echo "Something went wrong!";
    return;
}
$sql_2 = "SELECT * 
            FROM interested_users_items iui
            INNER JOIN items i ON iui.item_id = i.id";
$result_2 = mysqli_query($conn, $sql_2);
if (!$result_2) {
    echo "Something went wrong!";
    return;
}
$interested_users_items = mysqli_fetch_all($result_2, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CART | Sri Krishna Stores</title>

    <?php
    include "includes/head_links.php";
    ?>
    <link href="css/items_list.css" rel="stylesheet" />
</head>

<body>
    <?php
    include "includes/header.php";
    ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="shopping.php">Shopping Page</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                CART
            </li>
        </ol>
    </nav>

    <div class="page-container">
        
        <?php
        foreach ($interested_users_items as $item) {
            $total_price = $total_price+$item['price'];
            $item_images = glob("img/items/" . $item['id'] . "/*");
        ?>
            <div class="item-card item-id-<?= $item['id'] ?> row">
                <div class="image-container col-md-4">
                    <img src="<?= $item_images[0] ?>" />
                </div>
                <div class="content-container col-md-8">
                    <div class="row no-gutters justify-content-between">
                        <?php
                        $total_rating = round($item['rating'], 1);
                        ?>
                        <div class="star-container" title="<?= $total_rating ?>">
                            <?php
                            $rating = $total_rating;
                            for ($i = 0; $i < 5; $i++) {
                                if ($rating >= $i + 0.8) {
                            ?>
                                    <i class="fas fa-star"></i>
                                <?php
                                } elseif ($rating >= $i + 0.3) {
                                ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php
                                } else {
                                ?>
                                    <i class="far fa-star"></i>
                            <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="interested-container">
                            <?php
                            $is_interested = true;
                            
                            if ($is_interested) {
                            ?>
                                <i class="is-interested-image fas fa-times" item_id="<?= $item['id'] ?>"></i>
                            <?php
                            } else {
                            ?>
                                <i class="is-interested-image fas fa-plus" item_id="<?= $item['id'] ?>"></i>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="detail-container">
                        <div class="property-name"><h4><?= $item['name'] ?></h4></div>
                        <div class="property-category">
                            <?php
                            if ($item['category'] == "VEGETABLES") {
                            ?>
                                <img style="width:10%;height:10%;" src="img/VEGETABLE.jpg" />
                            <?php
                            } elseif ($item['category'] == "DAIRY") {
                            ?>
                                <img style="width:10%;height:10%;" src="img/DAIRY.webp" />
                            <?php
                            } elseif ($item['category'] == "BODY") {
                            ?>
                                <img style="width:15%;height:15%;" src="img/BODY.webp" />
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row no-gutters">
                        <div class="price-container col-6">
                            <div class="price"><h4>₹ <?= number_format($item['price']) ?>/-</h4></div>
                            <div class="price-unit">per unit</div>
                            <div class="quantity"><h5>Quantity Available:<?= number_format($item['quantity']) ?></h5></div>
                        </div>
                        <div class="button-container col-6">
                            <a href="item_detail.php?item_id=<?= $item['id'] ?>" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        
        if (count($interested_users_items) == 0) {
        ?>
            <div class="no-property-container">
                <p>CART IS EMPTY</p>
            </div>
        <?php
        }
        if($total_price!=0)
        {
        ?>
        <div class="item-card row" style="padding:20px;">
            <h3> Total Cart Value = ₹<?= $total_price ?>/-</h3>
        </div>
        <?php } ?>
        <div class="item-card" style="padding:15px;">
            <div>
            <h5><i class="fa fa-address-card"></i>Delivery Address:</h5>
            </div>
            <div>
            <h3><i class="fa fa-user"></i> <?= $add['full_name'] ?></h3>
            </div>
            <div>
            <h5><i class="fa fa-home"></i><?= $add['address'] ?></h5>
            </div>
        </div>
        <?php 
        if (count($interested_users_items) != 0) {
        ?><div class="row no-gutters justify-content-center">
            <a id="ban_btn2" class="link" href="#" data-toggle="modal" data-target="#book-modal">
                <i class="fa fa-bolt"></i>Book Now
        </a>
        </div>
        <?php } ?>
    </div>


    <?php
    include "includes/signup_modal.php";
    include "includes/login_modal.php";
    include "includes/book_modal.php";
    include "includes/footer.php";
    ?>

    <script type="text/javascript" src="js/items_list.js"></script>
</body>

</html>
