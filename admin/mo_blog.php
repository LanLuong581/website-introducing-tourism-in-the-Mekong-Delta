<?php
include('../config/constants.php');
session_start();
$id=$_GET['id'];
$sql_update="UPDATE `blog` SET `blog_status`='1' WHERE id='$id'";
if(mysqli_query($conn,$sql_update))
{
    header('location:blog.php?u=1');
}
else {
    echo "Error deleting record: " . mysqli_error($conn);
    }
    ?>
