<?php
include('../config/constants.php');
session_start();
$id=$_GET['id'];
$sql_del="DELETE FROM `blog` WHERE id='$id'";
if(mysqli_query($conn,$sql_del))
{
    header('location:blog.php?d=1');
}
else {
    echo "Error deleting record: " . mysqli_error($conn);
    }
    ?>
