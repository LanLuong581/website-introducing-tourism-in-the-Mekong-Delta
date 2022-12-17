<?php
include('../config/constants.php');
session_start();
$booking_id = $_GET['booking_id'];
$key=$_GET['key'];
$sql_del = "UPDATE `booking` SET `xoa`='1' WHERE booking_id='$booking_id'";
if (mysqli_query($conn, $sql_del)) {
    // echo"<script>alert('xóa đơn thành công')</script>"; 
    if ($key == 1) {
        header('location:lichsu.php?d=1');
    }
    elseif($key==2){
        header('location:qly_dadat.php?d=1');

    }
   
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
