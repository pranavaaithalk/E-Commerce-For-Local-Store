<?php
session_start();
require "includes/database_connect.php";

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
$item_id = $_GET["item_id"];

$sql_1 = "SELECT * FROM items WHERE id = $item_id";
$result_1 = mysqli_query($conn, $sql_1);
if (!$result_1) {
    echo "Something went wrong!";
    return;
}
$item = mysqli_fetch_assoc($result_1);
if (!$item) {
    echo "Something went wrong!";
    return;
}


$sql_2 = "SELECT * FROM testimonials WHERE item_id = $item_id";
$result_2 = mysqli_query($conn, $sql_2);
if (!$result_2) {
    echo "Something went wrong!";
    return;
}
$testimonials = mysqli_fetch_all($result_2, MYSQLI_ASSOC);

$sql_4 = "SELECT * FROM interested_users_items WHERE item_id = $item_id";
$result_4 = mysqli_query($conn, $sql_4);
if (!$result_4) {
    echo "Something went wrong!";
    return;
}
$interested_users = mysqli_fetch_all($result_4, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $item['name']; ?> | Sri Krishna Stores</title>

    <?php
    include "includes/head_links.php";
    ?>
    <link href="css/item_detail.css" rel="stylesheet" />
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
                <?= $item['name']; ?>
            </li>
        </ol>
    </nav>

    <?php
            $item_images = glob("img/items/" . $item['id'] . "/*");
        ?>
         <div class="item-card item-id-<?= $item['id'] ?> row">
                <div class="image-container col-md-4">
                    <img src="<?= $item_images[0] ?>" style="width:500px;height:500px;"/>
                </div>

    <div class="property-summary page-container">
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
                $is_interested = false;
                foreach ($interested_users as $interested_user) {
                    if ($interested_user['user_id'] == $user_id) {
                        $is_interested = true;
                    }
                }

                if ($is_interested) {
                ?>
                    <i class="is-interested-image fas fa-shopping-cart"></i>
                <?php
                } else {
                ?>
                    <i class="is-interested-image far fa-plus"></i>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="detail-container">
            <div class="property-name"><?= $item['name'] ?></div>
            <div class="property-category">
                <?php
                if ($item['category'] == "VEGETABLES") {
                ?>
                    <img style="width:15%;height:15%;" src="img/VEGETABLE.jpg" />
                <?php
                } elseif ($item['category'] == "DAIRY") {
                ?>
                    <img style="width:25%;height:25%;" src="img/DAIRY.webp" />
                <?php
                } elseif ($item['category'] == "BODY") {
                ?>
                    <img style="width:30%;height:30%;" src="img/BODY.webp" />
                <?php
                }
                ?>
            </div>
        </div>
        <div class="row no-gutters">
            <div class="rent-container col-6">
                <div class="price"><h3>₹ <?= number_format($item['price']) ?>/- </h3>per unit</div>
            </div>
            <div class="button-container col-6">
            <button class="booknow btn btn-primary">Order Now</button>
            </div>
        </div>
    </div>

            </div>
        </div>
    </div>

    <div class="property-about page-container">
        <h1>About the Item</h1>
        <p><?= $item['description'] ?></p>
    </div>

    <div class="property-testimonials page-container">
        <h1>What people say</h1>
        <?php
        foreach ($testimonials as $testimonial) {
        ?>
            <div class="testimonial-block">
                <div class="testimonial-image-container">
                    <img class="testimonial-img" src="img/man.png">
                </div>
                <div class="testimonial-text">
                    <i class="fa fa-quote-left" aria-hidden="true"></i>
                    <p><?= $testimonial['content'] ?></p>
                </div>
                <div class="testimonial-name">- <?= $testimonial['user_name'] ?></div>
            </div>
        <?php
        }
        ?>
    </div>

    <?php
    include "includes/signup_modal.php";
    include "includes/login_modal.php";
    include "includes/footer.php";
    ?>

    <script type="text/javascript" src="js/item_detail.js"></script>
</body>

</html>
