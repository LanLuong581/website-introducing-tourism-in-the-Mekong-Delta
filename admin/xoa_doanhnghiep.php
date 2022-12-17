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
//xóa tài khoản doanh nghiệp bẳng cách xóa lần lượt các bảng: phản hồi, bình luận, booking,chi tiết,tour,account
$account_id = $_GET['account_id'];
$sql_tour = "SELECT tour.tour_id,account.account_email
FROM (`tour`
      INNER JOIN account ON account.account_id=tour.account_id)
WHERE account.account_id='$account_id'";
$result_tour = mysqli_query($conn, $sql_tour);
if (mysqli_num_rows($result_tour) > 0) {
    while ($tour_row = mysqli_fetch_assoc($result_tour)) {
        $tour_id = $tour_row['tour_id'];
        $account_email = $tour_row['account_email'];
    }
    $sql_phanhoi_del = "DELETE FROM `phanhoi` WHERE tour_id='$tour_id'";
    if (mysqli_query($conn, $sql_phanhoi_del)) {
        $sql_binhluan_del = "DELETE FROM `binhluan` WHERE tour_id='$tour_id'";
        if (mysqli_query($conn, $sql_binhluan_del)) {
            $sql_booking_del = "DELETE FROM `booking` WHERE tour_id='$tour_id'";
            if (mysqli_query($conn, $sql_booking_del)) {
                $sql_chitiet_del = "DELETE FROM `chitiet_tour` WHERE tour_id='$tour_id'";
                if (mysqli_query($conn, $sql_chitiet_del)) {
                    $sql_tour_del = "DELETE FROM `tour` WHERE tour_id='$tour_id'";
                    if (mysqli_query($conn, $sql_tour_del)) {
                        $sql_account_del = "DELETE FROM `account` WHERE account_id='$account_id'";
                        if (mysqli_query($conn, $sql_account_del)) {

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
                                    Tài khoản doanh nghiệp của bạn trên ViVuMekong đã bị xóa
                                    vì một lý do nào đó, chúng tôi rất tiếc vì điều này,<br>
                                    Vui lòng liên hệ ViVuMekong để được giải đáp.<br>
                                    Xin cám ơn!
                                    ";
                            $mail->addAddress($account_email);
                            $mail->isHTML(true);
                            if ($mail->send()) {
                                header('location:doanhnghiep.php');
                            } else {
                                $message = $mail->ErrorInfo;
                            }
                            $mail->smtpClose('');
                        } else {
                            echo "<script>console.log('loi xoa bang account')</script>";
                        }
                    } else {
                        echo "<script>console.log('loi xoa bang tour')</script>";
                    }
                } else {
                    echo "<script>console.log('loi xoa bang chi tiet tour')</script>";
                }
            } else {
                echo "<script>console.log('loi xoa bang booking')</script>";
            }
        } else {
            echo "<script>console.log('loi xoa bang binhluan')</script>";
        }
    } else {
        echo "<script>console.log('loi xoa bang phan hoi')</script>";
    }
}
// $sql_update = "UPDATE `account` SET `daily_trangthai`='3' WHERE  `account_id`='$account_id'";
// if (mysqli_query($conn, $sql_update)) {
//     // gửi mail cho doanh nghiệp khi bị đóng tài khoản
//     $sql_doanhnghiep = "SELECT account_email FROM account WHERE account_id='$account_id'";
//     $result = mysqli_query($conn, $sql_doanhnghiep);
//     if (mysqli_num_rows($result) > 0) {
//         $row = mysqli_fetch_assoc($result);
//         $account_email = $row['account_email'];
//     }
//     $mail = new PHPMailer();
//     $mail->isSMTP();
//     $mail->CharSet  = "utf-8";
//     $mail->Host = "smtp.gmail.com";
//     $mail->SMTPAuth = "true";
//     $mail->SMTPSecure = "tls";
//     $mail->Port = 587;
//     $mail->Username = "thanhlan581@gmail.com";
//     $mail->Password = "aulp lcnw abty txzs";
//     $mail->Subject = "ViVuMekong duyệt doanh nghiệp";
//     $mail->setFrom("thanhlan581@gmail.com");
//     $mail->Body = "Xin chào $account_email,<br>
//                 Tài khoản của bạn trên ViVuMekong đã bị tạm đóng do vi phạm điều khoản sử dụng<br>
//                 Vui lòng liên hệ ViVuMekong để được giải đáp và mở lại tài khoản<br>
//                 Xin cám ơn!
//                 ";
//     $mail->addAddress($account_email);
//     $mail->isHTML(true);
//     if ($mail->send()) {
//         header('location:doanhnghiep.php?c=1');
//     } else {
//         $message = $mail->ErrorInfo;
//     }
//     $mail->smtpClose('');

// } else {
//     echo "<script>alert('chua cap nhat trang thai tour')</script>";
// }
