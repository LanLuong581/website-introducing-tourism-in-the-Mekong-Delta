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
$account_id = $_GET['account_id'];
//xóa tài khoản khách hàng bằng cách xóa các phản hồi trong bảng phản hồi
// tim khachhang_id theo account_id va email de gui mail cho khach hang thong bao xoa tai khoan
$sql_khachhang = "SELECT `khachhang_id`,account.account_email
FROM (`khachhang` 
      INNER JOIN account ON account.account_id=khachhang.account_id)
      WHERE account.account_id='$account_id'";
$result_khachhang = mysqli_query($conn, $sql_khachhang);
if (mysqli_num_rows($result_khachhang) > 0) {
    while ($khachhang_row = mysqli_fetch_assoc($result_khachhang)) {
        $khachhang_id = $khachhang_row['khachhang_id'];
        $account_email = $khachhang_row['account_email'];
    }
    // xoa khach hang trong bang phan hoi
    $sql_phanhoi_del = "DELETE FROM `phanhoi` WHERE khachhang_id='$khachhang_id'";
    if (mysqli_query($conn, $sql_phanhoi_del)) {
        // xoa khachhang trong bang binh luan
        $sql_binhluan_del = "DELETE FROM `binhluan` WHERE khachhang_id='$khachhang_id'";
        if (mysqli_query($conn, $sql_binhluan_del)) {
            // xoa khachhang trong bang khachhang
            $sql_khachhang_del = "DELETE FROM `khachhang` WHERE khachhang_id='$khachhang_id'";
            if (mysqli_query($conn, $sql_khachhang_del)) {
                // xoa khach hang trong bang account
                $sql_account = "DELETE FROM `account` WHERE account_id='$account_id'";
                if (mysqli_query($conn, $sql_account)) {
                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->CharSet  = "utf-8";
                    $mail->Host = "smtp.gmail.com";
                    $mail->SMTPAuth = "true";
                    $mail->SMTPSecure = "tls";
                    $mail->Port = 587;
                    $mail->Username = "thanhlan581@gmail.com";
                    $mail->Password = "aulp lcnw abty txzs";
                    $mail->Subject = "<ViVuMekong> Xóa tài khoản";
                    $mail->setFrom("thanhlan581@gmail.com");
                    $mail->Body = "Xin chào $account_email,<br>
                                    Tài khoản của bạn trên ViVuMekong đã bị xóa
                                    vì một lý do nào đó, chúng tôi rất tiếc vì điều này,<br>
                                    Vui lòng liên hệ ViVuMekong để được giải đáp.<br>
                                    Xin cám ơn!
                                    ";
                    $mail->addAddress($account_email);
                    $mail->isHTML(true);
                    if ($mail->send()) {
                        header('location:khachhang.php');
                    } else {
                        $message = $mail->ErrorInfo;
                    }
                    $mail->smtpClose('');

                    echo "<script>console.log('da xoa thanh cong tai khoan khach hang')</script>";
                } else {
                    echo "<script>console.log('loi xoa account')</script>";
                }
            } else {
                echo "<script>console.log('loi xoa khachhang')</script>";
            }
        } else {
            echo "<script>console.log('loi xoa binh luan')</script>";
        }
    } else {
        echo "<script>console.log('loi xoa phan hoi')</script>";
    }
}

