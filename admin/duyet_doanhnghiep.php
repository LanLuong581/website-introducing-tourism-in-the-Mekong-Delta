<?php
$connect = new PDO("mysql:host=localhost;dbname=dulichdbscl", "root", "");
include('../config/constants.php');
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
if (!isset($_SESSION['acc_account_loaitaikhoan'])) {
    header("location:../templates/login.php");
}
//  duyệt doanh nghiệp bằng cách cập nhật trạng thái tour
$account_id = $_GET['account_id'];
$sql_update = "UPDATE `account` SET `daily_trangthai`='1' WHERE  `account_id`='$account_id'";
if (mysqli_query($conn, $sql_update)) {
    // gửi mail cho doanh nghiệp khi doanh nghiệp được duyệt: bao gồm email và mật khẩu
    $sql_doanhnghiep = "SELECT account_email,account_password FROM account WHERE account_id='$account_id'";
    $result = mysqli_query($conn, $sql_doanhnghiep);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $account_email = $row['account_email'];
        $account_password = $row['account_password'];
    }
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->CharSet  = "utf-8";
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = "true";
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->Username = "thanhlan581@gmail.com";
    $mail->Password = "aulp lcnw abty txzs";
    $mail->Subject = "ViVuMekong duyệt doanh nghiệp";
    $mail->setFrom("thanhlan581@gmail.com");
    $mail->Body = "Xin chào $account_email,<br>
                Doanh nghiệp của bạn đã được ViVuMekong duyệt<br>
                Chào mừng bạn trở thành đối tác của ViVuMekong<br>
                Vui lòng đăng nhập vào ViVuMekong để thêm các dịch vụ cho doanh nghiệp của bạn tại :http://localhost/DULICHDBSCL/templates/login.php, <br>
                Email: $account_email <br>
                Mật Khẩu: $account_password <br>
                Xin cám ơn!
                ";
    $mail->addAddress($account_email);
    $mail->isHTML(true);
    if ($mail->send()) {
        header('location:doanhnghiep.php?m=1');
    } else {
        $message = $mail->ErrorInfo;
    }
    $mail->smtpClose('');

    // cap nhat mat khau ve dang md5
    $new_account_password=md5($account_password);
    $sql_update_pw="update account set `account_password`='$new_account_password' where `account_email`='$account_email'";
    if(mysqli_query($conn,$sql_update_pw)){

    }
    else{
    echo "<script>alert('chua cap nhat mat khau ve md5')</script>";
        
    }
} else {
    echo "<script>alert('chua cap nhat trang thai tour')</script>";
}

