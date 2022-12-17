<?php
include('../config/constants.php');
session_start();
$loaitour_id=$_GET['loaitour_id'];
$sql_update="UPDATE `loai_tour` SET `loaitour_trangthai`='0' WHERE loaitour_id ='$loaitour_id'";
if(mysqli_query($conn,$sql_update))
{
    header('location:doanhnghiep.php?dd=1');
}
else {
    echo "Error deleting record: " . mysqli_error($conn);
    }
    ?>
