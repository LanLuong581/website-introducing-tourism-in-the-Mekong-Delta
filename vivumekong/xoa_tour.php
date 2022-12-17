<?php
   include('../Config/constants.php');

 
    $tour_id=$_GET['tour_id'];
    $sql_xoa_chitiet="DELETE FROM `chitiet_tour` WHERE tour_id='$tour_id'";
    if(mysqli_query($conn,$sql_xoa_chitiet))
    {
        // echo"<script>alert('xóa đơn thành công')</script>"; 
        // header('location:quanlydon.php?m=1');
        $sql_xoa_tour="DELETE FROM `tour` WHERE tour_id='$tour_id'";
        if(mysqli_query($conn,$sql_xoa_tour)){
        echo"<script>alert('xóa tour thành công')</script>"; 
        }
    }
    else {
        echo "Error deleting record: " . mysqli_error($conn);
        }

?>
