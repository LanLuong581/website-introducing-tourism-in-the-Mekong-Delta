<?php
include('../config/constants.php');
if(isset($_POST['tinh_id'])){
    $tinh_id=$_POST['tinh_id'];
    $sql_huyen=mysqli_query($conn,"select * from district where _province_id='$tinh_id'");
    ?>
    <select name="huyen" class="form-select">
        <option value="">--Chọn Huyện---</option>
        <?php
            while($row=mysqli_fetch_array($sql_huyen)){
                ?>
                <option value="<?php echo $row['id'];?>"><?php echo $row['_name'];?></option>
                <?php
            }
        ?>
    </select>
    <?php
}

if(isset($_POST['s_tinh_id']) && isset($_POST['huyen_id'])){
    $s_tinh_id=$_POST['s_tinh_id'];
    $huyen_id=$_POST['huyen_id'];
    $sql_xa=mysqli_query($conn,"select * from ward where _district_id='$huyen_id' && _province_id='$s_tinh_id'");
    ?>
    <select name="xa" class="form-select">
        <option value="" selected="selected">--Chọn Xã---</option>
        <?php
            while($row=mysqli_fetch_array($sql_xa)){
                ?>
                <option value="<?php echo $row['id'];?>"><?php echo $row['_name'];?></option>
                <?php
            }
        ?>
    </select>
    <?php
}
?>