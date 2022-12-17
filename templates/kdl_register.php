<?php
include('../config/constants.php');
$error_email = '';
if (isset($_GET['a'])) {
    $error_email = 'Email đã tồn tại';
}

// if (isset($_POST['register_btn'])) {
//     $tour_ten=$_POST['tour_ten'];
//     $account_email=$_POST['account_email'];
//    $tour_dienthoai=$_POST['tour_dienthoai'];
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="style_kdl1.css">
    <script src="../js/check_new.js"></script>
    <title>ViVuMekong</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap');
    </style>
</head>

<body>
    <div class="background">
        <div class="container">
            <div class="doanhnghiep-box">
                <div class="title">
                    <p style="font-family: 'Cinzel', serif;font-size:30px;text-align: center;color:#0096c7;">Hợp tác cùng chúng tôi</p>
                    <p style="font-family: 'Cinzel', serif;font-size:60px;text-align: center;color:#0096c7;line-height:20px">ViVuMekong</p>
                    <br>
                </div>
                <form action="kdl_info_fill.php">
                    <input type="text" class="input-field" name="tour_ten" id="tour_ten" value="" placeholder="Tên doanh nghiệp">
                    <input type="email" class="input-field" name="account_email" id="account_email" value="" placeholder="Email">
                    <span style="color:red"><?php echo $error_email ?></span>
                    <input type="text" class="input-field" name="tour_dienthoai" id="tour_dienthoai" value="" placeholder="Số điện thoại">
                    <button type="submit" onclick="return vali_doanhnghiep();" class="submit-btn" style="border-radius:30px" name="register_btn" id="register_btn">Đăng Ký</button>
                </form>
                <br>
                <div class="row">
                    <a href="../khachhang/index.php" style="color: blue;text-decoration:none; text-align:center">Trở về trang chủ</a>
                </div>

            </div>


        </div>
    </div>


    <script src="../js/bootstrap.js"></script>
    <script src="../jquery/jquery-3.6.0.min.js"></script>
</body>

</html>