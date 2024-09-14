<?php
session_start();

require("../includes/database_connect.php");
if (!isset($_SESSION["user_id"])) {
    header("location: index.php");
    die();
}

$user_id = $_SESSION['user_id'];
$sql1 = "SELECT * FROM interested_users_items WHERE user_id=$user_id";
$res1 = mysqli_query($conn,$sql1);
if (!$res1) {
    $response = array("success" => false, "message" => "Something went wrong!");
    echo json_encode($response);
    return;
}
$orders = mysqli_fetch_all($res1, MYSQLI_ASSOC);
foreach($orders as $order)
{
    $sq2 = "INSERT INTO orders(user_id,item_id) VALUES($user_id, {$order['item_id']})";
    $res2 = mysqli_query($conn,$sq2);
    if (!$res2) {
        $response = array("success" => false, "message" => "Something went wrong!");
        echo json_encode($response);
        return;
    }
    $sq3 = "DELETE FROM interested_users_items WHERE user_id=$user_id AND item_id={$order['item_id']}";
    $res3 = mysqli_query($conn,$sq3);
    if (!$res3) {
        $response = array("success" => false, "message" => "Something went wrong!");
        echo json_encode($response);
        return;
    }
}
$response = array("success" => true, "message" => "Order Placed Successfully, Thank You");
echo json_encode($response);
mysqli_close($conn);
?>