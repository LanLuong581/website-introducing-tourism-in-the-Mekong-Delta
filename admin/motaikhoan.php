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
//mở tài khoản doanh nghiệp bằng cách update daily_trangthai =1
$account_id = $_GET['account_id'];
$sql_update = "UPDATE `account` SET `daily_trangthai`='1' WHERE  `account_id`='$account_id'";
if (mysqli_query($conn, $sql_update)) {
    // gửi mail cho doanh nghiệp khi mở tài khoản
    $sql_doanhnghiep = "SELECT account_email FROM account WHERE account_id='$account_id'";
    $result = mysqli_query($conn, $sql_doanhnghiep);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $account_email = $row['account_email'];
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
                Tài khoản của bạn trên ViVuMekong đã được mở lại<br>
                Tiếp tục cập nhật thêm nhiều dịch vụ tại ViVuMekong nhé<br>
                Xin cám ơn!
                ";
    $mail->addAddress($account_email);
    $mail->isHTML(true);
    if ($mail->send()) {
        header('location:doanhnghiep.php?c=1');
    } else {
        $message = $mail->ErrorInfo;
    }
    $mail->smtpClose('');

} else {
    echo "<script>alert('chua cap nhat trang thai tour')</script>";
}

