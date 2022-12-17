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
$sql_duyet = "UPDATE `booking` SET `booking_trangthai`='1' WHERE booking_id='$booking_id'";
if (mysqli_query($conn, $sql_duyet)) {
    $sql_booking_info = "SELECT tour.tour_ten, chitiet_tour.chitiet_ten,booking.booking_sl_nguoilon,booking.booking_sl_treem,
    booking.booking_ngaybook,booking.booking_ngaysudung,booking.booking_tonggia,account.account_email,tour.tour_dienthoai,province._name as tinh_ten,district._name as huyen_ten, ward._name as xa_ten, tour.tour_diachi
    FROM ((((((booking
          INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
          INNER JOIN tour ON tour.tour_id=booking.tour_id)
          INNER JOIN account ON account.account_id=tour.account_id)
          INNER JOIN province ON province.id=tour.tinh_id)
          INNER JOIN district ON district.id=tour.huyen_id)
          INNER JOIN ward ON ward.id = tour.xa_id)
          WHERE booking_id='$booking_id'";
    $result_info = mysqli_query($conn, $sql_booking_info);
    while ($info = mysqli_fetch_assoc($result_info)) {
        $tour_ten = $info['tour_ten'];
        $chitiet_ten = $info['chitiet_ten'];
        $booking_sl_nguoilon = $info['booking_sl_nguoilon'];
        $booking_sl_treem = $info['booking_sl_treem'];
        $booking_ngaybook = $info['booking_ngaybook'];
        $booking_ngaysudung = $info['booking_ngaysudung'];
        $booking_tonggia = $info['booking_tonggia'];
        $account_email=$info['account_email'];
        $tour_dienthoai=$info['tour_dienthoai'];
        $tinh_ten=$info['tinh_ten'];
        $huyen_ten=$info['huyen_ten'];
        $xa_ten=$info['xa_ten'];
        $tour_diachi=$info['tour_diachi'];


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
    $mail->Subject = "<ViVuMekong> Xác nhận đơn hàng";
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
    
    <h3>Xin chào quý khách hàng</h3>
    <p>$tour_ten đã xác nhận đơn hàng $chitiet_ten của quý khách, thông tin chi tiết như sau</p>
    
    <table>
      <tr>
      <th>Tên khu du lịch</th>
      <th>Tên chi tiết</th>
      <th>Ngày đặt</th>
      <th>Ngày sử dụng</th>
      <th>Người lớn</th>
      <th>Trẻ em</th>
      <th>Tổng giá</th>
      </tr>
      <tr>
        <td>$tour_ten</td>
        <td>$chitiet_ten</td>
        <td>$booking_ngaybook</td>
        <td>$booking_ngaysudung</td>
        <td>$booking_sl_nguoilon</td>
        <td>$booking_sl_treem</td>
        <td>$booking_tonggia</td>
      </tr>
    </table>
    <p>Cảm ơn quý khách đã đặt dịch vụ du lịch tại ViVuMekong, chúc quý khách có những trải nghiêm tuyệt vời.</p>
    <p>Nếu có bất kì thắc mắc, quý khách vui lòng liên hệ khu du lịch $tour_ten</p>
    <p>Số điện thoại: $tour_dienthoai</p>
    <p>Email: $account_email</p>
    <p>Địa chỉ: $tour_diachi, xã $xa_ten, huyện $huyen_ten, tỉnh $tinh_ten </p>
    </body>
    </html>
    ";
    $mail->addAddress($kh_email);
    $mail->isHTML(true);
    if ($mail->send()) {
        header('location:dh_chuaxuly.php?d=1');
    } else {
        $message = $mail->ErrorInfo;
    }
    $mail->smtpClose('');
}
