<?php
include('../config/constants.php');
session_start();
if (!isset($_SESSION['acc_account_loaitaikhoan'])) {
    header("location:../templates/login.php");
} else {
    if ($_SESSION['acc_account_loaitaikhoan'] != 2) {
        header("location:../templates/login.php");
    }
}
$booking_id = $_GET['id'];

$sql_xuat = "UPDATE `booking` SET `booking_trangthai`='5' WHERE booking_id='$booking_id'";
if (mysqli_query($conn, $sql_xuat)) {
    $sql_booking = "SELECT booking.booking_ngaybook,booking.booking_ngaysudung,booking.booking_sl_nguoilon,booking.booking_sl_treem,
    booking.booking_tonggia,booking.kh_id,booking.tour_id,booking.chitiet_tour_id
    FROM (((booking
          INNER JOIN tour ON tour.tour_id=booking.tour_id)
          INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
          INNER JOIN booking_khachhang ON booking_khachhang.kh_id=booking.kh_id)
          WHERE booking.booking_id='$booking_id'";
    $result_booking = mysqli_query($conn, $sql_booking);
    if ($result_booking) {
        while ($booking = mysqli_fetch_assoc($result_booking)) {
            $booking_ngaybook = $booking['booking_ngaybook'];
            $booking_ngaysudung = $booking['booking_ngaysudung'];
            $booking_sl_nguoilon = $booking['booking_sl_nguoilon'];
            $booking_sl_treem = $booking['booking_sl_treem'];
            $booking_tonggia = $booking['booking_tonggia'];
            $kh_id = $booking['kh_id'];
            $tour_id = $booking['tour_id'];
            $chitiet_tour_id = $booking['chitiet_tour_id'];
        }
        $sql_tour = "SELECT tour.tour_ten,province._name as tinh_ten,district._name AS huyen_ten, ward._name AS xa_ten,account.account_email,
        tour.tour_diachi,tour.tour_dienthoai
            FROM ((((tour
                  INNER JOIN province ON province.id=tour.tinh_id)
                  INNER JOIN district ON district.id=tour.huyen_id)
                  INNER JOIN ward ON ward.id=tour.xa_id)
                  INNER JOIN account ON account.account_id=tour.account_id)
            WHERE tour.tour_id='$tour_id'";
        $result_tour = mysqli_query($conn, $sql_tour);
        if ($result_tour) {
            while ($tour = mysqli_fetch_assoc($result_tour)) {
                $tour_ten = $tour['tour_ten'];
                $tinh_ten = $tour['tinh_ten'];
                $huyen_ten = $tour['huyen_ten'];
                $xa_ten = $tour['xa_ten'];
                $account_email = $tour['account_email'];
                $tour_diachi = $tour['tour_diachi'];
                $tour_dienthoai = $tour['tour_dienthoai'];
            }
        }
        $sql_chitiet = "SELECT chitiet_ten,chitiet_gia_nguoilon,chitiet_gia_treem FROM chitiet_tour WHERE chitiet_tour_id='$chitiet_tour_id'";
        $result_chitiet = mysqli_query($conn, $sql_chitiet);
        if ($result_chitiet) {
            while ($chitiet = mysqli_fetch_assoc($result_chitiet)) {
                $chitiet_ten = $chitiet['chitiet_ten'];
                $chitiet_gia_nguoilon = $chitiet['chitiet_gia_nguoilon'];
                $chitiet_gia_treem = $chitiet['chitiet_gia_treem'];
            }
        }
        $sql_khachhang = "SELECT * FROM booking_khachhang WHERE kh_id='$kh_id'";
        $result_khachhang = mysqli_query($conn, $sql_khachhang);
        if ($result_khachhang) {
            while ($khachhang = mysqli_fetch_assoc($result_khachhang)) {
                $info_ho_kh = $khachhang['info_ho_kh'];
                $info_ten_kh = $khachhang['info_ten_kh'];
                $info_email_kh = $khachhang['info_email_kh'];
                $info_sdt_kh = $khachhang['info_sdt_kh'];
            }
        }
    }
} else {
    echo "<script>alert(chua xuat duoc don hang)</script>";
}


// var_dump($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../vendor/paper-css/paper.min.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    <title>ViVuMeKong</title>
    <style>
        @page {
            size: A5 landscape;
        }
    </style>

</head>

<body class="A5 landscape">
    <div id="printableArea">
        <section class="sheet padding-10mm">
            <h5 style="text-align: left;"><?php echo $tour_ten ?></h5>
            <p style="text-align: left;">Số điện thoại: <?php echo $tour_dienthoai ?> <br>
                Email: <?php echo $account_email ?> <br>
                Địa chỉ: <?php echo $tour_diachi ?>, phường(xã) <?php echo $xa_ten ?>, quận(huyện) <?php echo $huyen_ten ?>, <?php echo $tinh_ten ?></p>
            <h3 style="text-align: center;"><?php echo $chitiet_ten ?></h3>
            <h5>Thông tin chi tiết</h5>
            <table class="table">
                <thead>
                    <th>Đối tượng</th>
                    <th>Giá vé</th>
                    <th>Số lượng</th>
                    <th>Ngày đặt</th>
                    <th>Ngày sử dụng</th>
                    <th>Tổng cộng</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Người lớn</td>
                        <td><?php echo number_format($chitiet_gia_nguoilon) ?></td>
                        <td><?php if (isset($booking_sl_nguoilon)) echo $booking_sl_nguoilon ?></td>
                        <td><?php echo date('d/m/Y', strtotime($booking_ngaybook)) ?></td>
                        <td><?php echo date('d/m/Y', strtotime($booking_ngaysudung)) ?></td>
                        <td><?php echo number_format($booking_sl_nguoilon * $chitiet_gia_nguoilon) ?></td>
                    </tr>
                    <tr>
                        <td>Trẻ em</td>
                        <td><?php echo number_format($chitiet_gia_treem) ?></td>
                        <td><?php if (isset($booking_sl_treem)) echo $booking_sl_treem ?></td>
                        <td><?php echo date('d/m/Y', strtotime($booking_ngaybook)) ?></td>
                        <td><?php echo date('d/m/Y', strtotime($booking_ngaysudung)) ?></td>
                        <td><?php echo number_format($booking_sl_treem * $chitiet_gia_treem) ?></td>
                    </tr>
                    <tr>
                        <th>Thành tiền</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th style="font-size: 20px;"><?php echo number_format($booking_tonggia) ?> VND</th>
                    </tr>
                </tbody>
            </table>
            <p style="font-size: 13px;">Lưu ý: <br> * Vé chỉ có giá trị sử dụng trong ngày <br> * Vé không có giá trị đổi thành tiền mặt</p>
            <?php date_default_timezone_set('Asia/Ho_Chi_Minh'); ?>
            <p>Ngày xuất: <?php echo date('h:i:s a m/d/Y ', time()) ?></p>

        </section>
    </div>

    <div class="row" style="margin: 0;">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <a href="dh_homnay.php"><button type="button" class="btn btn-success">Trở lại</button></a>
            <button type="submit" class="btn btn-success" style="float: right;" onclick="printDiv('printableArea')">Xuất hóa đơn</button>

        </div>
        <div class="col-md-3">

        </div>
    </div>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../jquery/jquery-3.6.0.min.js"></script>
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
</body>

</html>