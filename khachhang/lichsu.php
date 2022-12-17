<?php
include('../config/constants.php');
session_start();
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
    <link rel="stylesheet" href="khachhang5.css">
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../jquery/jquery-3.6.0.min.js"></script>
    <script src="ckfinder/ckfinder.js"></script>
    <title>ViVuMekong</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@500&display=swap');
    </style>
    <style>
        .button_submit {
            background-color: #2d7d90;
            border-radius: 5px;
            border: none;
            color: #fff;
            padding: 10px;
            width: 100%;
            font-weight: 600;
            cursor: pointer;
            width: 100px;
            height: 36px;
            padding: 0px 10px;
        }

        .button_submit:hover {
            background: #22577a;
            color: #fff;
        }

        .button_close {
            background-color: #6c757d;
            border-radius: 5px;
            border: none;
            color: #fff;
            padding: 10px;
            width: 100%;
            font-weight: 600;
            text-transform: capitalize;
            cursor: pointer;
            width: 100px;
            height: 36px;
            padding: 0px 10px;
        }

        .button_close:hover {
            background: #495057;
            color: #fff;
        }

        .button_continue {
            background-color: #2d7d90;
            border-radius: 20px;
            border: none;
            color: #fff;
            padding: 10px;
            width: 100%;
            font-weight: 600;
            text-transform: capitalize;
            cursor: pointer;
        }

        .swal2-confirm {
            width: 135px;
        }

        .swal2-cancel {
            width: 85px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="header">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.html" style="font-family: 'Cinzel', serif;font-size: 30px;">ViVuMekong</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="index.php">Trang chủ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="vuichoi.php">Vui Chơi</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="vuontraicay.php">Vườn Trái Cây</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="thamquan.php">Tham Quan</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Blog
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="blog.php?loaiblog=<?php echo "1" ?>">Kinh nghiệm du lịch</a></li>
                                    <li><a class="dropdown-item" href="blog.php?loaiblog=<?php echo "3" ?>">Review ẩm thực</a></li>
                                    <li><a class="dropdown-item" href="blog.php?loaiblog=<?php echo "2" ?>">Phong tục tập quán</a></li>
                                    <li><a class="dropdown-item" href="blog.php?loaiblog=<?php echo "4" ?>">Khác</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="../templates/kdl_register.php">Hợp Tác</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="mytour.php">Giỏ Hàng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="qly_dadat.php">Quản Lý Đơn Hàng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="lichsu.php">Lịch Sử Đặt Hàng</a>
                            </li>
                            <?php
                            if (isset($_SESSION["acc_email"])) {
                            ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" id="account_email" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php
                                        echo ($_SESSION["acc_email"]);
                                        ?>
                                    </a>

                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li data-bs-toggle="modal" data-bs-target="#doanhnghiep_info"><a class="dropdown-item bi bi-person"> Thông tin cá nhân</a></li>
                                        <!-- Button trigger modal -->

                                        <li><a class="dropdown-item bi bi-box-arrow-right" href="../templates/logout.php"> Đăng Xuất</a></li>

                                    </ul>
                                </li>
                            <?php
                            } else {
                            ?>
                                <li class="nav-item">
                                    <a class="nav-link " aria-current="page" href="../templates/login.php">Đăng Nhập/Đăng Ký</a>
                                </li>
                            <?php
                            }
                            ?>



                        </ul>


                    </div>
                </div>
            </nav>
        </div>
        <div class="main-content">
            <form action="" method="post">
                <div class="row" style="margin: 0;padding-top: 50px;">
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-8" style="background-color: #fff;">
                        <?php
                        if (isset($_SESSION["acc_email"])) {
                            $email = $_SESSION["acc_email"];
                        ?>
                            <div class="product_list">
                                <?php
                                $sql_booking_khachhang = "SELECT booking_khachhang.kh_id FROM booking_khachhang WHERE booking_khachhang.info_email_kh='$email'  ORDER BY booking_khachhang.kh_id DESC";
                                $result_booking_khachhang = mysqli_query($conn, $sql_booking_khachhang);
                                if (mysqli_num_rows($result_booking_khachhang) > 0) {
                                ?>
                                    <h4>Tất cả đơn hàng</h4>
                                    <?php
                                    while ($result_id = mysqli_fetch_assoc($result_booking_khachhang)) {
                                        $kh_id = $result_id['kh_id'];
                                        $sql_booking = "SELECT booking.booking_id,chitiet_tour.chitiet_avt,tour.tour_ten,loai_tour.loaitour_ten,chitiet_tour.chitiet_ten,
                                        booking.booking_ngaybook,booking.booking_ngaysudung,booking.booking_sl_nguoilon,booking.booking_sl_treem,
                                        booking.booking_tonggia,booking.booking_trangthai,booking.tour_id
                                        FROM (((booking
                                              INNER JOIN tour ON tour.tour_id = booking.tour_id)
                                              INNER JOIN loai_tour ON loai_tour.loaitour_id=tour.loaitour_id)
                                              INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                              WHERE booking.kh_id='$kh_id' && booking.booking_trangthai ='5' && NOT booking.xoa='1' ORDER BY booking.booking_id DESC";
                                        $result_booking = mysqli_query($conn, $sql_booking);
                                        if (mysqli_num_rows($result_booking) > 0) {

                                            while ($booking = mysqli_fetch_assoc($result_booking)) {
                                                $booking_id = $booking['booking_id'];
                                                $chitiet_avt = $booking['chitiet_avt'];
                                                $tour_ten = $booking['tour_ten'];
                                                $loaitour_ten = $booking['loaitour_ten'];
                                                $chitiet_ten = $booking['chitiet_ten'];
                                                $booking_ngaybook = $booking['booking_ngaybook'];
                                                $booking_ngaysudung = $booking['booking_ngaysudung'];
                                                $booking_sl_nguoilon = $booking['booking_sl_nguoilon'];
                                                $booking_sl_treem = $booking['booking_sl_treem'];
                                                $booking_tonggia = $booking['booking_tonggia'];
                                                $booking_trangthai = $booking['booking_trangthai'];
                                                $tour_id = $booking['tour_id'];
                                    ?>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <img src="../image/<?= $chitiet_avt; ?>" alt="<?= $chitiet_avt; ?>" srcset="" width="200px" height="150px" style="border-radius:3px ;">

                                                    </div>
                                                    <div class="col-md-9">
                                                        <!-- <h5>chitiet_avt <?php echo $chitiet_avt ?></h5> -->
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <span style="font-size: 20px;font-weight:500;text-transform: capitalize">[MSD: <?php echo $booking_id ?>] <?php echo $tour_ten ?></span>
                                                                <br>
                                                                <span style="font-weight: 500; font-size:16px"><?php echo $chitiet_ten ?></span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <span style="font-size: 20px;" class="tong_gia" id="tong_gia"><?php echo number_format($booking_tonggia) ?> VND</span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <span>Ngày đặt:</span> <br>
                                                                <span>Ngày sử dụng:</span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <span><?php echo date('d/m/Y', strtotime($booking_ngaybook)) ?></span> <br>
                                                                <span><?php echo date('d/m/Y', strtotime($booking_ngaysudung)) ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-7" style="text-align: left;">
                                                                <div class="soluong-text">
                                                                    <span>Người lớn (cao từ 140cm)</span><br>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div>
                                                                    <span id="booking_sl_nguoilon" name="booking_sl_nguoilon"><?php echo $booking_sl_nguoilon ?></span><br>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-7" style="text-align: left;">
                                                                <div class="soluong-text">
                                                                    <span>Trẻ em (cao dưới 140cm)</span><br>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div>
                                                                    <span id="booking_sl_treem" name="booking_sl_treem"><?php echo $booking_sl_treem ?></span><br>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-7" style="text-align: left;">
                                                                <div class="trangthai">
                                                                    <span>Trạng thái</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div>
                                                                    <?php
                                                                    if ($booking_trangthai == 5) {
                                                                    ?>
                                                                        <span style="color: blue;">Đã hoàn thành</span>

                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-7" style="text-align: left;">
                                                                <div class="tacvu">
                                                                    <span>Tác vụ</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5" style="display:inline">
                                                                <?php
                                                                if ($booking_trangthai == 5) {
                                                                ?>
                                                                    <a href="../khachhang/chitiet.php?tour_id=<?php echo $tour_id ?>" class="btn btn-warning">Cảm nhận</a>
                                                                    <button type="button" class="btn button_submit" data-bs-toggle="modal" data-bs-target="#lienhe<?php echo $tour_id ?>">
                                                                        Liên hệ
                                                                    </button>
                                                                    <a href="xoa.php?booking_id=<?php echo $booking_id ?>&key=1" class="btn btn-danger xoa_don" style="width:50px">Xóa</a>

                                                                <?php
                                                                }
                                                                ?>
                                                                <!-- Modal -->
                                                                <div class="modal fade" id="booking<?php echo $booking_id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <form class="main-form" action="" method="POST" enctype="multipart/form-data">

                                                                                <div class="modal-header" style="background: #2d7d90;color:#fff">
                                                                                    <h5 class="modal-title" id="exampleModalLabel">Chi tiết đơn hàng</h5>

                                                                                </div>
                                                                                <?php
                                                                                $sql_booking_modal = "SELECT booking.booking_id,tour.tour_ten,loai_tour.loaitour_ten,
                                                                                chitiet_tour.chitiet_ten,chitiet_tour.chitiet_gia_nguoilon,chitiet_tour.chitiet_gia_treem,
                                                                                booking.booking_ngaybook,booking.booking_ngaysudung,booking.booking_sl_nguoilon,booking.booking_sl_treem,
                                                                                booking.booking_tonggia
                                                                                FROM (((booking
                                                                                      INNER JOIN tour ON tour.tour_id=booking.tour_id)
                                                                                      INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                                                                      INNER JOIN loai_tour ON loai_tour.loaitour_id=tour.loaitour_id)
                                                                                      WHERE booking_id='$booking_id'";
                                                                                $result_booking_modal = mysqli_query($conn, $sql_booking_modal);
                                                                                if (mysqli_num_rows($result_booking_modal) > 0) {
                                                                                    while ($booking_modal = mysqli_fetch_assoc($result_booking_modal)) {
                                                                                        $booking_id = $booking_modal['booking_id'];
                                                                                        $tour_ten = $booking_modal['tour_ten'];
                                                                                        $loaitour_ten = $booking_modal['loaitour_ten'];
                                                                                        $chitiet_gia_nguoilon = $booking_modal['chitiet_gia_nguoilon'];
                                                                                        $chitiet_gia_treem = $booking_modal['chitiet_gia_treem'];
                                                                                        $booking_ngaybook = $booking_modal['booking_ngaybook'];
                                                                                        $booking_ngaysudung = $booking_modal['booking_ngaysudung'];
                                                                                        $booking_sl_nguoilon = $booking_modal['booking_sl_nguoilon'];
                                                                                        $booking_sl_treem = $booking_modal['booking_sl_treem'];
                                                                                        $booking_tonggia = $booking_modal['booking_tonggia'];
                                                                                    }
                                                                                }

                                                                                ?>
                                                                                <div class="modal-body">
                                                                                    <div class="col-md-12">
                                                                                        <div col-md-12>

                                                                                            <div class="form-group">
                                                                                                <div class="row">
                                                                                                    <div class="col-md-12">

                                                                                                        <label for="tour_ten" style="font-size: 20px;font-weight:600;text-transform:capitalize;"><?php echo $tour_ten ?></label>
                                                                                                        <br>
                                                                                                        <label for="chitiet_ten" style="font-size: 18px;"><?php echo $chitiet_ten ?></label>
                                                                                                        <input type="hidden" class="gia_nguoilon" value="<?php echo $chitiet_gia_nguoilon ?>" name="gia_nguoilon" id="gia_nguoilon" />
                                                                                                        <input type="hidden" class="gia_treem" value="<?php echo $chitiet_gia_treem ?>" name="gia_treem" id="gia_treem" />
                                                                                                        <input type="hidden" class="booking_id" value="<?php echo $booking_id ?>" name="booking_id" id="booking_id" />
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="row">
                                                                                                    <div class="col-md-4" style="width:134px">
                                                                                                        <label for="booking_date">Ngày sử dụng: </label>
                                                                                                    </div>
                                                                                                    <div class="col-md-4">
                                                                                                        <input type="date" class="form-control ngaysudung" id="modal_ngaysudung" name="modal_ngaysudung" value="<?php echo $booking_ngaysudung ?>">
                                                                                                    </div>
                                                                                                    <div class="col-md-4">

                                                                                                    </div>

                                                                                                </div>
                                                                                                <div class="row">
                                                                                                    <div class="col-md-5" style="padding-right: 0px;">
                                                                                                        <label for="nguoilon">Người lớn (cao từ 140cm)</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-3" style="padding-right: 0px;">
                                                                                                        <label for="chitiet_gia_nguoilon"><?php echo number_format($chitiet_gia_nguoilon) ?> VND</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-4">
                                                                                                        <div class="input-group">
                                                                                                            <input type="number" class="form-control sl_nguoilon" id="modal_sl_nguoilon" name="modal_sl_nguoilon" onmouseover="min_soluong()" onchange="total()" min="0" value="<?php echo $booking_sl_nguoilon ?>">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <br>
                                                                                                <div class="row">
                                                                                                    <div class="col-md-5" style="padding-right: 0px;">
                                                                                                        <label for="booking_sl_treem">Trẻ em (cao dưới 140cm)</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-3" style="padding-right: 0px;">
                                                                                                        <label for="chitiet_gia_treem"><?php echo number_format($chitiet_gia_treem) ?> VND</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-4">
                                                                                                        <div class="input-group">

                                                                                                            <input type="number" class="form-control sl_treem" id="modal_sl_treem" name="modal_sl_treem" onmouseover="min_soluong()" onchange="total()" min="0" value="<?php echo $booking_sl_treem ?>">

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <hr>
                                                                                                <div class="row">
                                                                                                    <div class="col-md-5">
                                                                                                        <label for="booking_tonggia">Tổng cộng: </label>
                                                                                                    </div>
                                                                                                    <div class="col-md-7">
                                                                                                        <input class="form-control booking_tonggia" type="text" id="modal_tonggia" name="modal_tonggia" value="0" style="font-size: 20px;">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>


                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn button_close" data-bs-dismiss="modal">Close</button>
                                                                                    <button type="submit" class="btn button_submit" id="save_btn" name="save_btn">Lưu</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- modal -->
                                                                <!-- modal xem thong tin doanh nghiep -->
                                                                <div class="modal fade" id="lienhe<?php echo $tour_id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog ">
                                                                        <div class="modal-content bg-modal">
                                                                            <div class="modal-header" style="background: #2d7d90;color:#fff">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Thông Tin Doanh Nghiệp</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <?php
                                                                            // $account_email = $_SESSION["acc_email"];
                                                                            $sql = "SELECT tour.tour_id, tour.tour_ten,tour.tour_avt,tour.tour_dienthoai,province._name as tinh_ten,district._name as huyen_ten,
                                                                            ward._name as xa_ten,tour.tour_diachi,tour.tour_trangthai,loai_tour.loaitour_ten,account.account_email
                                                                            FROM ((((( tour
                                                                                  INNER JOIN province ON province.id=tour.tinh_id)
                                                                                  INNER JOIN district ON district.id=tour.huyen_id)
                                                                                  INNER JOIN ward ON ward.id=tour.xa_id)
                                                                                  INNER JOIN loai_tour ON loai_tour.loaitour_id=tour.loaitour_id)
                                                                                  INNER JOIN account ON account.account_id=tour.account_id)
                                                                                  WHERE tour.tour_id='$tour_id'";
                                                                            $result = mysqli_query($conn, $sql);
                                                                            if (mysqli_num_rows($result) > 0) {
                                                                                // output data of each row
                                                                                while ($row = mysqli_fetch_assoc($result)) {

                                                                            ?>
                                                                                    <div class="modal-body">
                                                                                        <div class="table-info">
                                                                                            <div>
                                                                                                <?php
                                                                                                if ($row['tour_avt'] == NULL) {
                                                                                                ?>
                                                                                                    <div class="hinh" style="margin: 0 28%;">
                                                                                                        <img src="../image/avt.svg" alt="" srcset="" style="width: 300px; height:200px;">

                                                                                                    </div>
                                                                                                <?php
                                                                                                } else {
                                                                                                ?>
                                                                                                    <div class="hinh" style="text-align:center">
                                                                                                        <img src="../image/<?php echo $row['tour_avt'] ?>" alt="" srcset="" style="width: 300px; height:200px">

                                                                                                    </div>
                                                                                                <?php
                                                                                                }
                                                                                                ?>
                                                                                                <table class="table">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th scope="col">Tên khu du lịch:</th>
                                                                                                            <td><?php echo $row['tour_ten'] ?></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th scope="col">Địa Chỉ:</th>
                                                                                                            <td><?php echo $row['tour_diachi'] ?>,<?php echo $row['xa_ten'] ?>,<?php echo $row['huyen_ten'] ?>,<?php echo $row['tinh_ten'] ?></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th scope="col">Số Điện Thoại:</th>
                                                                                                            <td><?php echo $row['tour_dienthoai'] ?></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th scope="col">Email:</th>
                                                                                                            <td><a href="mailto:<?php echo $row['account_email'] ?>" style="color:#22577a;text-decoration:none"><?php echo $row['account_email'] ?></a> </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th scope="col">Loại Hình Kinh Doanh:</th>
                                                                                                            <td><?php echo $row['loaitour_ten'] ?></td>
                                                                                                        </tr>
                                                                                                    </thead>

                                                                                                </table>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn button_close" data-bs-dismiss="modal">Đóng</button>

                                                                                    </div>

                                                                            <?php
                                                                                }
                                                                            } else {
                                                                                echo "Chưa có dữ liệu";
                                                                            }
                                                                            ?>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- end modal xem thong tin doanh nghiep -->
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!-- <div class="col-md-1">

                                                    </div> -->
                                                </div>
                                                <br>
                                <?php

                                            }
                                        }
                                    }
                                }

                                ?>

                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="row">
                                <div class="col-md-2">

                                </div>
                                <div class="col-md-8" style="text-align: center;">
                                    <div class="empty-cart" style="background-color: #fff;height:200px;margin-bottom:10%;padding-top:20px;padding-bottom:20px">
                                        <h4 style="margin-bottom:30px">Bạn chưa đăng nhập</h4>
                                        <h5>Vui lòng <a href="../templates/login.php" style="text-decoration: none;color:red">đăng nhập</a> hoặc <a href="../templates/register.php" style="text-decoration: none;">đăng ký</a> để xem các dịch vụ đã đặt</h5>
                                        <hr style="height:0.5px;margin:0px 50px">
                                        <a class="btn button_submit" href="index.php" role="button" style="margin-top:30px;width:178px">Quay lại trang chủ</a>
                                    </div>
                                </div>
                                <div class="col-md-2">

                                </div>
                            </div>
                        <?php
                        }
                        ?>

                    </div>
                    <div class="col-md-2">

                    </div>
                </div>
            </form>
        </div>
        <?php
        include("../templates/footer.html")
        ?>
    </div>

    <!-- chatbot -->
    <script>
        let __protocol = document.location.protocol;
        let __baseUrl = __protocol + '//livechat.fpt.ai/v35/src';

        let prefixNameLiveChat = 'ViVuMekong';
        let objPreDefineLiveChat = {
                appCode: '10beec9651fcac98d958c41cdaba49f7',
                themes: '',
                appName: prefixNameLiveChat ? prefixNameLiveChat : 'Live support',
                thumb: '',
                icon_bot: ''
            },
            appCodeHash = window.location.hash.substr(1);
        if (appCodeHash.length == 32) {
            objPreDefineLiveChat.appCode = appCodeHash;
        }

        let fpt_ai_livechat_script = document.createElement('script');
        fpt_ai_livechat_script.id = 'fpt_ai_livechat_script';
        fpt_ai_livechat_script.src = __baseUrl + '/static/fptai-livechat.js';
        document.body.appendChild(fpt_ai_livechat_script);

        let fpt_ai_livechat_stylesheet = document.createElement('link');
        fpt_ai_livechat_stylesheet.id = 'fpt_ai_livechat_script';
        fpt_ai_livechat_stylesheet.rel = 'stylesheet';
        fpt_ai_livechat_stylesheet.href = __baseUrl + '/static/fptai-livechat.css';
        document.body.appendChild(fpt_ai_livechat_stylesheet);

        fpt_ai_livechat_script.onload = function() {
            fpt_ai_render_chatbox(objPreDefineLiveChat, __baseUrl, 'livechat.fpt.ai:443');
        }
    </script>
    <!-- end chatbot -->
</body>

</html>