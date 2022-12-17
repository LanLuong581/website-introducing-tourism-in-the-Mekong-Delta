<?php
include('../config/constants.php');
require('../templates/send_mail.php');
session_start();
$booking_id = $_GET['booking_id'];
$sql_del = "UPDATE `booking` SET `booking_trangthai`='3' WHERE booking_id='$booking_id'";
if (mysqli_query($conn, $sql_del)) {
    $sql_kdl_mail = "SELECT account.account_email 
    FROM ((booking
          INNER JOIN tour ON tour.tour_id=booking.tour_id)
          INNER JOIN account ON account.account_id=tour.account_id)
          WHERE booking.booking_id='$booking_id'";
    $result_email = mysqli_query($conn, $sql_kdl_mail);
    if (mysqli_num_rows($result_email) > 0) {
        while ($account = mysqli_fetch_assoc($result_email)) {
            $account_email = $account['account_email'];
        }
    }
    $noidung="<p>Xin chào quý đối tác</p>";
    $noidung .= "<p>ViVuMekong thông báo đơn hàng có mã số " . $booking_id . " đã bị hủy</p>";
    $noidung .="<p>Xin cám ơn</p>";
    $tieude = "<ViVuMekong>Có đơn bị hủy";
    $mailcapnhat = $account_email;
    $mail = new Mailer();
    $mail->dathangmail($tieude, $noidung, $mailcapnhat);
    header('location:qly_dadat.php?d=1');
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
