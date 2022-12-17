<?php
include('../config/constants.php');
session_start();
if (!isset($_SESSION['acc_account_loaitaikhoan'])) {
    header("location:../templates/login.php");
}
$chitiet_tour_id = $_GET['chitiet_tour_id'];
$sql_close = "UPDATE `chitiet_tour` SET `chitiet_trangthai`='0' WHERE `chitiet_tour_id`='$chitiet_tour_id'";
if (mysqli_query($conn, $sql_close)) {
    header('location:dichvu.php?a=1');
} else {
    echo "lỗi đóng dịch vụ: " . mysqli_error($conn);
}
