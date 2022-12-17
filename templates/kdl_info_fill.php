<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
$connect = new PDO("mysql:host=localhost;dbname=dulichdbscl", "root", "");
include('../config/constants.php');
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$account_email = $_GET["account_email"];
$tour_dienthoai = $_GET["tour_dienthoai"];
$tour_ten = $_GET["tour_ten"];
$account_password = '';
$loaitour_id = '';
$tinh_id = '';
$huyen_id = '';
$xa_id = '';
$tour_diachi = '';
// $tour_trangthai = '';

if (isset($_POST['them_tour'])) {
    $otp = rand(100000, 999999);
    $loaitour_id = $_POST['loaitour_id'];
    $tinh_id = $_POST['tinh_id'];
    $huyen_id = $_POST['huyen_id'];
    $xa_id = $_POST['xa_id'];
    $tour_diachi = $_POST['tour_diachi'];

    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randompw = substr(str_shuffle($permitted_chars), 0, 15);
    $data = array(
        ':account_email'    =>  $account_email,
        ':account_password' =>  $randompw,
        ':account_loaitaikhoan' =>  '2',
        ':account_trangthai'   =>  '0',
        ':account_OTP'  =>  $otp

    );
    $email_query = "select * from account where account_email='" . $account_email . "'";
    $statement_email = $connect->prepare($email_query);
    $statement_email->execute();
    $total_row = $statement_email->rowCount();
    if ($total_row > 0) {
        header("location:kdl_register.php?a=1");
    } else {
        $sql_otp = "INSERT INTO `account`(`account_password`,`account_email`, `account_loaitaikhoan`, `account_OTP`, `account_trangthai`)
    SELECT * FROM (SELECT :account_password,:account_email,:account_loaitaikhoan,:account_OTP,:account_trangthai) AS tmp
    WHERE NOT EXISTS(
        SELECT account_email from account where account_email= :account_email) LIMIT 1";
        $statement = $connect->prepare($sql_otp);
        $statement->execute($data);
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->CharSet  = "utf-8";
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = "true";
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->Username = "thanhlan581@gmail.com";
        $mail->Password = "aulp lcnw abty txzs";
        $mail->Subject = "ViVuMekong xác minh tài khoản";
        $mail->setFrom("thanhlan581@gmail.com");
        $mail->Body = "Xin chào $account_email,<br>
            Bạn đang đăng ký tài khoản cho doanh nghiệp tại ViVuMekong<br>
            Mã xác thực của bạn là $otp";
        $mail->addAddress($account_email);
        $mail->isHTML(true);
        if ($mail->send()) {
            header("location:../templates/otp.php?account_email=" . $account_email);
        } else {
            $message = $mail->ErrorInfo;
        }
        $mail->smtpClose('');
        $sql_account_id = "SELECT account_id FROM `account` WHERE account_email='$account_email'";
        $result = mysqli_query($conn, $sql_account_id);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $account_id = $row['account_id'];
                $sql_themtour = "INSERT INTO `tour`(`loaitour_id`, `account_id`, `tour_ten`, `tour_dienthoai`, `tinh_id`, `huyen_id`, `xa_id`, `tour_diachi`, `tour_ngaytao`, `tour_trangthai`,`tour_avt`)
               VALUES ('$loaitour_id','$account_id','$tour_ten','$tour_dienthoai','$tinh_id','$huyen_id','$xa_id','$tour_diachi',SYSDATE(),'0','bg5.png')";
                if (mysqli_query($conn, $sql_themtour)) {
                } else {
                    echo "lỗi thêm tour" . mysqli_error($conn);
                }
            }
        } else {
            echo "<script>alert('không tìm thấy account id')</script>";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../jquery/jquery-3.6.0.min.js"></script>
    <script src="ckfinder/ckfinder.js"></script>
    <title>ViVuMeKong</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@500&display=swap');

        .button_submit {
            background-color: #2d7d90;
            border-radius: 5px;
            border: none;
            color: #fff;
            padding: 10px;
            width: 100%;
            font-weight: 600;
            text-transform: capitalize;
            cursor: pointer;
            /* width: 100px; */
            height: 36px;
            padding: 0px 10px;
        }

        .button_submit:hover {
            background: #22577a;
            color: #fff;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".tinh").change(function() {
                var tinh_id = $(this).val();
                $.ajax({
                    url: "../vivumekong/tinh_huyen_xa.php",
                    method: "POST",
                    data: {
                        tinh_id: tinh_id
                    },
                    success: function(data) {
                        $(".huyen").html(data);
                    }
                });
            });

            $(".huyen").change(function() {
                var s_tinh_id = $(".tinh").val();
                var huyen_id = $(this).val();
                $.ajax({
                    url: "../vivumekong/tinh_huyen_xa.php",
                    method: "POST",
                    data: {
                        s_tinh_id: s_tinh_id,
                        huyen_id: huyen_id
                    },
                    success: function(data) {
                        $(".xa").html(data);
                    }
                });
            });
        });
    </script>
</head>

<body>
    <div class="wrapper">
        <div class="header">
            <nav class="navbar navbar-expand-lg navbar-light ">
                <div class="container-fluid">
                    <a class="navbar-brand" href="../khachhang/khachhang_index.php" style="font-family: 'Cinzel', serif;font-size: 30px;">ViVuMekong</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="about.php">Về chúng tôi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="tinhnang.php">Tính năng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="huongdan.php">Hướng Dẫn</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>
        </div>

        <div class="main-content" style="background-color: #f8f9fa;">
            <form action="" method="post" style="margin:0">
                <div class="col-md-12">
                    <div class="row" style="margin: 0;">
                        <div class="col-md-2">

                        </div>
                        <div class="col-md-8" style="background-color: #fff;margin:30px 0px;padding:20px">

                            <?php
                            $sql_loaitour = "SELECT * FROM loai_tour where not loaitour_trangthai='0';";
                            $result_loaitour = mysqli_query($conn, $sql_loaitour);
                            $loaitour_list = [];
                            while ($row = mysqli_fetch_array($result_loaitour, MYSQLI_ASSOC)) {
                                $loaitour_list[] = [
                                    'loaitour_id' => $row['loaitour_id'],
                                    'loaitour_ten' => $row['loaitour_ten'],
                                ];
                            }

                            ?>
                            <form class="main-form" action="" method="post" name="frmAddTour" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="avt">
                                            <img src="../image/Seet.png" srcset="" style="display:block;width:485px;height:400px; opacity: 0.8;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 style="text-align: center;color:#2d7d90">Thông Tin Doanh Nghiệp</h4>
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <label for="tour_ten" class="form-label" style="color:#2d7d90">Tên doanh nghiệp</label>
                                                <input name="tour_ten" id="tour_ten" cols="30" rows="1" class="form-control" value="<?php echo $_GET['tour_ten']; ?>" > </input>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="loaitour_id" class="form-label required" style="color:#2d7d90">Loại doanh nghiệp</label>
                                                <select name="loaitour_id" id="loaitour_id" class="form-select" required>
                                                    <?php foreach ($loaitour_list as $loaitour_ls) : ?>
                                                        <option value="<?= $loaitour_ls['loaitour_id'] ?>"><?= $loaitour_ls['loaitour_ten'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <label for="account_email" class="form-label" style="color:#2d7d90">Email</label>
                                                <input type="text" class="form-control" id="account_email" name="account_email" value=<?php echo $_GET["account_email"]; ?>>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tour_dienthoai" class="form-label" style="color:#2d7d90">Số điện thoại</label>
                                                <input type="text" class="form-control" id="tour_dienthoai" name="tour_dienthoai" value=<?php echo $_GET["tour_dienthoai"]; ?>>
                                            </div>
                                        </div>

                                        <div class="row g-3">
                                            <!-- tinh -->
                                            <div class="col-md-4">
                                                <label for="tinh_id" class="form-label required" style="color:#2d7d90">Tỉnh</label>
                                                <select class=" tinh form-select" id="tinh_id" name="tinh_id" required>
                                                    <option selected="selected">---Chọn Tỉnh---</option>
                                                    <?php
                                                    $sql_tinh = mysqli_query($conn, "SELECT * FROM `province` WHERE id='8' ||id='12' || id='16' || id='26' 
                                                    || id='30' || id='37' ||id='39' || id='40' || id='47' || id='48' || id='52' || id='53' || id='55'");
                                                    while ($row = mysqli_fetch_array($sql_tinh)) {
                                                    ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['_name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- huyen -->
                                            <div class="col-md-4">
                                                <label for="huyen_id" class="form-label required" style="color:#2d7d90">Huyện</label>
                                                <select class="huyen form-select" id="huyen_id" name="huyen_id" required>
                                                    <option selected="selected" id="huyen_id">--Chọn Huyện---</option>
                                                </select>
                                            </div>

                                            <!-- xa -->
                                            <div class="col-md-4">
                                                <label for="xa_id" class="form-label required" style="color:#2d7d90">Xã</label>
                                                <select class="xa form-select" id="xa_id" name="xa_id" required>
                                                    <option selected="selected" id="xa_id">--Chọn Xã---</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="tour_diachi" class="form-label" style="color:#2d7d90">Địa chỉ chi tiết</label>
                                                <input type="text" class="form-control" id="tour_diachi" name="tour_diachi" required>
                                            </div>
                                        </div>
<br><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input class="btn button_submit" type="submit" value="Đăng ký" id="them_tour" name="them_tour">

                                            </div>
                                        </div>

                                    </div>

                                    <br>

                            </form>
                        </div>
                        <div class="col-md-2">

                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="footer">
            <?php include("../templates/footer.html") ?>
        </div>
    </div>
</body>

</html>