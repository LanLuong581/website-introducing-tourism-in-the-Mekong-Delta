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

$message = '';
$error_email = '';
$error_password = '';
$error_repassword = '';
$account_email = '';
$account_password = '';
$re_password = '';

if (isset($_POST['register_btn'])) {
    if (empty($_POST['account_email'])) {
        $error_email = "<label class='text-danger'>Vui lòng nhập email</label>";
    } else {
        $account_email = trim($_POST["account_email"]);
        if (!filter_var($account_email, FILTER_VALIDATE_EMAIL)) {
            $error_email = '<label class="text-danger">Vui lòng nhập đúng email</label>';
        }
    }

    if (empty($_POST['account_password'])) {
        $error_password = "<label class='text-danger'>Vui lòng nhập mật khẩu</label>";
    } else {
        $account_password = trim($_POST["account_password"]);
        $account_password = md5($account_password);
    }

    if (empty($_POST['re_password'])) {
        $error_repassword = "<label class='text-danger'>Vui lòng nhập lại mật khẩu</label>";
    } else {
        $re_password = trim($_POST["re_password"]);
        $re_password = md5($re_password);
        if ($re_password != $account_password) {
            $error_repassword = "<label class='text-danger'>Mật khẩu nhập lại không đúng</label>";
        }
    }

    if ($error_email == '' && $error_password == '' && $error_repassword == '') {
        $otp = rand(100000, 999999);
        $data = array(
            ':account_email'    =>  $account_email,
            ':account_password' =>  $account_password,
            ':account_loaitaikhoan' =>  '3',
            ':account_trangthai'   =>  '0',
            ':khachhang_trangthai'   =>  '1',
            ':account_OTP'  =>  $otp
        );
        $email_query = "select * from account where account_email='" . $account_email . "'";
        $statement_email = $connect->prepare($email_query);
        $statement_email->execute();
        $total_row = $statement_email->rowCount();

        if ($total_row > 0) {
            $message = '<label class="text-danger">Email này đã tồn tại</label>';
            // echo "<script language='javascript'> 
            // Swal.fire({
            //     icon: 'error',
            //     title: 'Email đã tồn tại',
            //     text: 'vui lòng điền email'
            // })
            // </script>";
        } else {
            $query = "INSERT INTO `account`(`account_password`,`account_email`, `account_loaitaikhoan`, `account_OTP`, `account_trangthai`,`khachhang_trangthai`)
            SELECT * FROM (SELECT :account_password,:account_email,:account_loaitaikhoan,:account_OTP,:account_trangthai,:khachhang_trangthai) AS tmp
            WHERE NOT EXISTS(
                SELECT account_email from account where account_email= :account_email) LIMIT 1";
            $statement = $connect->prepare($query);
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
            Bạn đang đăng ký tàì khoản của ViVuMekong<br>
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
                    $tinh_id = '1';
                    $huyen_id = '1';
                    $xa_id = '1';
                    $sql_khachhang = "INSERT INTO `khachhang`(`account_id`,`khachhang_ho`,`khachhang_ten`,`tinh_id`,`huyen_id`,`xa_id`) VALUES ('$account_id','userName$account_id','userName$account_id','$tinh_id','$huyen_id','$xa_id')";
                    if (mysqli_query($conn, $sql_khachhang)) {
                    } else {
                        echo "lỗi thêm tour" . mysqli_error($conn);
                    }
                }
            } else {
                echo "<script>alert('không tìm thấy account id')</script>";
            }
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="style4.css">
    <!-- <script src="../js/checker.js"></script> -->
    <script src="../js/check_new.js"></script>
    <title>ViVuMekong</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap');
    </style>
</head>

<body>
    <div class="background">
        <div class="container">
            <div class="form-box">
                <div class="title">
                    <p style="font-family: 'Cinzel', serif;font-size:60px;text-align: center;color:#0096c7;">ViVuMekong</p>
                    <h3 style="text-align: center;font-family: 'Cinzel', serif;">Đăng Ký</h3>
                </div>
                <form id="register" method="post">
                    <?php echo $message; ?>
                    <input type="email" class="input-field" name="account_email" id="account_email" placeholder="Email">
                    <input type="password" class="input-field" name="account_password" id="account_password" placeholder="Mật Khẩu">
                    <?php echo $error_password; ?>
                    <input type="password" class="input-field" name="re_password" id="re_password" placeholder="Nhập Lại Mật Khẩu">
                    <?php echo $error_repassword; ?>
                    <button type="submit" onclick="return validate();" class="submit-btn" style="border-radius:30px" name="register_btn" id="register_btn">Đăng Ký</button>
                </form>
                <br>
                <div class="row">
                    <p style="text-align:center">Bạn đã có tài khoản? <a href="../templates/login.php" style="color: red;text-decoration:none">Đăng nhập</a></p>
                </div>
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