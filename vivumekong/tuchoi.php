<?php
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
} else {
    if ($_SESSION['acc_account_loaitaikhoan'] != 2) {
        header("location:../templates/login.php");
    }
}

$booking_id = $_GET['id'];
$kh_email = $_GET['mail'];
$sql_duyet = "UPDATE `booking` SET `booking_trangthai`='2' WHERE booking_id='$booking_id'";
if (mysqli_query($conn, $sql_duyet)) {
    $sql_booking_info = "SELECT tour.tour_ten, chitiet_tour.chitiet_ten,booking.booking_sl_nguoilon,booking.booking_sl_treem,
    booking.booking_ngaybook,booking.booking_ngaysudung,booking.booking_tonggia,account.account_email
    FROM (((booking
          INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
          INNER JOIN tour ON tour.tour_id=booking.tour_id)
          INNER JOIN account ON account.account_id=tour.account_id)
          WHERE booking.booking_id='$booking_id'";
    $result_info = mysqli_query($conn, $sql_booking_info);
    while ($info = mysqli_fetch_assoc($result_info)) {
        $tour_ten = $info['tour_ten'];
        $chitiet_ten = $info['chitiet_ten'];
        $booking_sl_nguoilon = $info['booking_sl_nguoilon'];
        $booking_sl_treem = $info['booking_sl_treem'];
        $booking_ngaybook = $info['booking_ngaybook'];
        $booking_ngaysudung = $info['booking_ngaysudung'];
        $booking_tonggia = $info['booking_tonggia'];
        $account_email = $info['account_email'];

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
    $mail->Subject = "<ViVuMekong> Đơn hàng bị từ chối";
    $mail->setFrom("thanhlan581@gmail.com");
    $mail->Body = "<!DOCTYPE html>
    <html>
    <head>
    <style>
    table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
    }
    </style>
    </head>
    <body>
    
    <p>Xin chào quý khách hàng</p>
    <p><b>$tour_ten</b> đã <b>từ chối</b> đơn hàng <b>$chitiet_ten</b> của quý khách, thông tin chi tiết như sau</p>
    
    <table>
      <tr>
      <th>Tên khu du lịch</th>
      <th>Tên chi tiết</th>
      <th>Ngày đặt</th>
      <th>Ngày sử dụng</th>
      <th>Người lớn</th>
      <th>Trẻ em</th>
      <th>Tổng giá</th>
      <th>Trạng thái</th>

      </tr>
      <tr>
        <td>$tour_ten</td>
        <td>$chitiet_ten</td>
        <td>$booking_ngaybook</td>
        <td>$booking_ngaysudung</td>
        <td>$booking_sl_nguoilon</td>
        <td>$booking_sl_treem</td>
        <td>$booking_tonggia</td>
        <td><b>Từ chối</b></td>

      </tr>
    </table>
    <p>Vui lòng thực hiện đặt lại dịch vụ hoặc liên hệ $tour_ten để biết thêm chi tiết tại email: $account_email.</p>
    <p>ViVuMekong chân thành cảm ơn quý khách.</p>
    </body>
    </html>
    ";
    $mail->addAddress($kh_email);
    $mail->isHTML(true);
    if ($mail->send()) {
        header('location:dh_chuaxuly.php?t=1');
    } else {
        $message = $mail->ErrorInfo;
    }
    $mail->smtpClose('');
}
