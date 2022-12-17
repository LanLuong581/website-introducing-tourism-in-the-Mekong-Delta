<?php
include('../config/constants.php');


session_start();
if (!isset($_SESSION['acc_account_loaitaikhoan'])) {
    header("location:../templates/login.php");
} else {
    if ($_SESSION['acc_account_loaitaikhoan'] != 2) {
        header("location:../templates/login.php");
    }
}

$booking_id = $_GET['id'];
$sql_duyet = "UPDATE `booking` SET `booking_trangthai`='0' WHERE booking_id='$booking_id'";
if (mysqli_query($conn, $sql_duyet)) {
    header('location:dh_homnay.php?h=1');

}
