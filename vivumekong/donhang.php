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

$email = $_SESSION["acc_email"];
$result_tour = mysqli_query($conn, "SELECT tour_id
    FROM (tour
          INNER JOIN account ON account.account_id=tour.account_id)
          WHERE account.account_email='$email'");
while ($row = mysqli_fetch_array($result_tour)) {
    $tour_id = $row['tour_id'];
}

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
    <link rel="stylesheet" href="../css/jquery.dataTables.min.css">
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../jquery/jquery-3.6.0.min.js"></script>
    <script src="ckfinder/ckfinder.js"></script>
    <title>ViVuMeKong</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@500&display=swap');

        .button_submit {
            background-color: #2d7d90;
            border-radius: 5px;
            border: none;
            color: #fff;
            padding: 10px;
            width: 100%;
            font-weight: 600;
            text-transform: capitalize;
            cursor: pointer;
            width: 185px;
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

        .ul_btn {
            display: inline;
        }

        .li_btn {
            display: inline;
            width: 100px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".tinh").change(function() {
                var tinh_id = $(this).val();
                $.ajax({
                    url: "tinh_huyen_xa.php",
                    method: "POST",
                    data: {
                        tinh_id: tinh_id
                    },
                    success: function(data) {
                        $(".huyen").html(data);
                    }
                });
            });

            $(".huyen").change(function() {
                var s_tinh_id = $(".tinh").val();
                var huyen_id = $(this).val();
                $.ajax({
                    url: "tinh_huyen_xa.php",
                    method: "POST",
                    data: {
                        s_tinh_id: s_tinh_id,
                        huyen_id: huyen_id
                    },
                    success: function(data) {
                        $(".xa").html(data);
                    }
                });
            });
        });
    </script>
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
                                <a class="nav-link " aria-current="page" href="gioithieu.php">Giới Thiệu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="dichvu.php">Dịch Vụ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="dh_homnay.php">Đơn Hàng</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="account_email" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php
                                    if (isset($_SESSION["acc_email"])) {
                                        echo ($_SESSION["acc_email"]);
                                    }

                                    ?>
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li data-bs-toggle="modal" data-bs-target="#doanhnghiep_info"><a class="dropdown-item bi bi-person"> Thông tin cá nhân</a></li>
                                    <!-- Button trigger modal -->

                                    <li><a class="dropdown-item bi bi-box-arrow-right" href="../templates/logout.php"> Đăng Xuất</a></li>

                                </ul>
                            </li>

                        </ul>
                        <!-- modal thong tin doanh nghiep -->
                        <div class="modal fade" id="doanhnghiep_info" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog ">
                                <div class="modal-content bg-modal">
                                    <div class="modal-header" style="background: #2d7d90;color:#fff">
                                        <h5 class="modal-title" id="exampleModalLabel">Thông Tin Doanh Nghiệp</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <?php
                                    $account_email = $_SESSION["acc_email"];
                                    $sql = "SELECT tour.tour_id, tour.tour_ten,tour.tour_avt,tour.tour_dienthoai,province._name as tinh_ten,district._name as huyen_ten,
                                     ward._name as xa_ten,tour.tour_diachi,account_email,tour.tour_trangthai,loai_tour.loaitour_ten
                                     FROM ((((( account
                                           INNER JOIN tour ON tour.account_id=account.account_id)
                                           INNER JOIN province ON province.id=tour.tinh_id)
                                           INNER JOIN district ON district.id=tour.huyen_id)
                                           INNER JOIN ward ON ward.id=tour.xa_id)
                                           INNER JOIN loai_tour ON loai_tour.loaitour_id=tour.loaitour_id)
                                           WHERE account.account_email='$account_email'";
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $tour_id = $row['tour_id'];
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
                                                <button class="btn button_submit" data-bs-target="#update<?php echo $tour_id ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Cập nhật</button>
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
                        <!-- modal thong tin ca nhan -->
                        <!-- Modal cap nhat thong tin doanh nghiep -->
                        <div class="modal fade" id="update<?php echo $tour_id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="modal-header" style="background: #2d7d90;color:#fff">
                                            <h5 class="modal-title" id="exampleModalLabel" style="font-size:30px">Cập nhật thông tin</h5>
                                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            $sql_tour = "SELECT tour_id,tour_ten,tinh_id,huyen_id,xa_id,loaitour_id,tour_dienthoai,tour_diachi,tour_avt FROM `tour`
                                                      WHERE tour_id='$tour_id'";
                                            $result_tour = mysqli_query($conn, $sql_tour);
                                            if (mysqli_num_rows($result_tour) > 0) {
                                                while ($tour_result = mysqli_fetch_assoc($result_tour)) {
                                                    $tour_id = $tour_result['tour_id'];
                                                    $tour_ten = $tour_result['tour_ten'];
                                                    $tinh_id = $tour_result['tinh_id'];
                                                    $huyen_id = $tour_result['huyen_id'];
                                                    $xa_id = $tour_result['xa_id'];
                                                    $loaitour_id = $tour_result['loaitour_id'];
                                                    $tour_dienthoai = $tour_result['tour_dienthoai'];
                                                    $tour_diachi = $tour_result['tour_diachi'];
                                                    $tour_avt = $tour_result['tour_avt'];
                                                }

                                                $sql_loaitour = "SELECT * FROM loai_tour";
                                                $result_loaitour = mysqli_query($conn, $sql_loaitour);
                                                $loaitour_list = [];
                                                while ($row = mysqli_fetch_array($result_loaitour, MYSQLI_ASSOC)) {
                                                    $loaitour_list[] = [
                                                        'loaitour_id' => $row['loaitour_id'],
                                                        'loaitour_ten' => $row['loaitour_ten'],
                                                    ];
                                                }
                                            ?>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <input type="hidden" id="tour_id" name="tour_id" value="<?php echo $tour_id ?>">
                                                        <div class="col-md-12" style="text-align: center;">
                                                            <label for="tour_avt" class="form-label required"></label>
                                                            <img src="../image/<?= $tour_avt; ?>" alt="<?= $tour_avt; ?>" srcset="" width="300px" height="200px" style="border-radius:3px ;">
                                                            <input type="hidden" name="pre_chitiet_avt" value="<?php echo $tour_avt; ?>" />
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <label for="tour_avt" class="form-label required" style="font-weight: 500;">Chọn ảnh mới</label>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input class="form-control" type="file" name="update_tour_avt" id="update_tour_avt" value="<?php echo $tour_avt ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <label for="" class="form-label" style="font-weight: 500;">Tên doanh nghiệp</label>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" style="border: none;" id="update_tour_ten" name="update_tour_ten" value="<?php echo $tour_ten ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <label for="" class="form-label" style="font-weight: 500;">Số điện thoại</label>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" style="border: none;" id="update_tour_dienthoai" name="update_tour_dienthoai" value="<?php echo $tour_dienthoai ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <label for="" class="form-label" style="font-weight: 500;">Loại hình doanh nghiệp</label>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <select name="update_loaitour_id" id="update_loaitour_id" class="form-select" required>
                                                                <?php foreach ($loaitour_list as $loaitour_ls) : ?>
                                                                    <?php
                                                                    $loaitour_selected = '';
                                                                    $loaitour_edit = $loaitour_id;
                                                                    if ($loaitour_ls['loaitour_id'] == $loaitour_edit) {
                                                                        $loaitour_selected = 'selected';
                                                                    }
                                                                    ?>
                                                                    <option value="<?= $loaitour_ls['loaitour_id'] ?>" <?= $loaitour_selected ?>><?= $loaitour_ls['loaitour_ten'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="diachi">
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <label for="tinh_id" class="form-label required" style="font-weight: 500;">Tỉnh</label>
                                                                <select class=" tinh form-select" id="update_tinh_id" name="update_tinh_id" required>
                                                                    <option selected="selected">---Chọn Tỉnh---</option>
                                                                    <?php
                                                                    $sql_tinh = mysqli_query($conn, "select * from province");
                                                                    while ($row = mysqli_fetch_array($sql_tinh)) {
                                                                    ?>
                                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['_name']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="huyen_id" class="form-label required" style="font-weight: 500;">Huyện</label>
                                                                <select class="huyen form-select" id="update_huyen_id" name="update_huyen_id" required>
                                                                    <option selected="selected" id="huyen_id">--Chọn Huyện---</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="xa_id" class="form-label required" style="font-weight: 500;">Xã</label>
                                                                <select class="xa form-select" id="update_xa_id" name="update_xa_id" required>
                                                                    <option selected="selected" id="xa_id">--Chọn Xã---</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="" class="form-label" style="font-weight: 500;">Địa chỉ chi tiết</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" style="border:none" id="update_tour_diachi" name="update_tour_diachi" value="<?php echo $tour_diachi ?>">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            <?php
                                            }

                                            ?>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn button_close" data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn button_submit" id="update_submit" name="update_submit">Lưu</button>
                                        </div>
                                    </form>

                                </div>

                            </div>
                        </div>
                        <!-- end modal cap nhat thong tin doanh nghiep -->

                    </div>
                </div>
            </nav>
        </div>

        <div class="main-content" style="background-color: #f8f9fa;min-height:80vh">
            <div class="control">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ul_btn">
                    <li class="nav-item li_btn"><button type="submit" class="btn button_submit" onclick="hienthi_homnay()" id="homnay_btn">Đơn hàng hôm nay</button></li>
                    <li class="nav-item li_btn"><button type="submit" class="btn button_submit" onclick="hienthi_saptoi()" id="saptoi_btn">Đơn hàng sắp tới</button></li>
                    <li class="nav-item li_btn"><button type="submit" class="btn button_submit" onclick="hienthi_daqua()" id="daqua_btn">Đơn hàng đã qua</button></li>
                    <li class="nav-item li_btn"><button type="submit" class="btn button_submit" onclick="hienthi_tatca()" id="tatca_btn">Tất cả đơn hàng</button></li>
                </ul>
            </div>
            <div class="data_table" style="padding-top: 12px;">
                <div class="donhang_list hom_nay">
                    <h5 style="text-align: center;">Đơn hàng hôm nay</h5>
                    <table class="table" id="today_order">
                        <thead>
                            <tr class="table-success">
                                <th scope="col">STT</th>
                                <th scope="col">Họ KH</th>
                                <th scope="col">Tên KH</th>
                                <th scope="col">SDT</th>
                                <th scope="col">Email</th>
                                <th scope="col">Dịch vụ</th>
                                <th scope="col">Ngày đặt</th>
                                <th scope="col">Ngày sử dụng</th>
                                <th scope="col">Người lớn</th>
                                <th scope="col">Trẻ em</th>
                                <th scope="col">Tổng giá</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_booking = "SELECT booking.booking_id,booking.chitiet_tour_id,chitiet_tour.chitiet_ten,
                        booking.booking_ngaybook,booking.booking_ngaysudung,booking.booking_sl_nguoilon,booking.booking_sl_treem,
                        booking.booking_tonggia,booking.booking_trangthai,booking.kh_id,booking_khachhang.info_ho_kh,
                        booking_khachhang.info_ten_kh,booking_khachhang.info_sdt_kh,booking_khachhang.info_email_kh
                        FROM ((booking
                              INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                              INNER JOIN booking_khachhang ON booking_khachhang.kh_id=booking.kh_id)
                              WHERE booking.tour_id='$tour_id' && DATE(booking.booking_ngaysudung) = DATE(NOW())";
                            $result_booking = mysqli_query($conn, $sql_booking);
                            $n = 1;
                            if (mysqli_num_rows($result_booking) > 0) {
                                while ($booking = mysqli_fetch_assoc($result_booking)) {
                                    $booking_id = $booking['booking_id'];
                                    $chitiet_tour_id = $booking['chitiet_tour_id'];
                                    $chitiet_ten = $booking['chitiet_ten'];
                                    $booking_ngaybook = $booking['booking_ngaybook'];
                                    $booking_ngaysudung = $booking['booking_ngaysudung'];
                                    $booking_sl_nguoilon = $booking['booking_sl_nguoilon'];
                                    $booking_sl_treem = $booking['booking_sl_treem'];
                                    $booking_tonggia = $booking['booking_tonggia'];
                                    $booking_trangthai = $booking['booking_trangthai'];
                                    $kh_id = $booking['kh_id'];
                                    $info_ho_kh = $booking['info_ho_kh'];
                                    $info_ten_kh = $booking['info_ten_kh'];
                                    $info_sdt_kh = $booking['info_sdt_kh'];
                                    $info_email_kh = $booking['info_email_kh'];

                            ?>
                                    <tr style="background-color: #fff;">
                                        <td><?php echo $n++ ?></td>
                                        <td><?php echo $info_ho_kh ?></td>
                                        <td><?php echo $info_ten_kh ?></td>
                                        <td><?php echo $info_sdt_kh ?></td>
                                        <td><?php echo $info_email_kh ?></td>
                                        <td><?php echo $chitiet_ten ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($booking_ngaybook)) ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($booking_ngaysudung)) ?></td>
                                        <td><?php echo $booking_sl_nguoilon ?></td>
                                        <td><?php echo $booking_sl_treem ?></td>
                                        <td><?php echo number_format($booking_tonggia)  ?></td>
                                        <td>
                                            <?php if ($booking_trangthai == 0) {
                                            ?>
                                                <span class="badge bg-info">Chưa xử lý</span>
                                            <?php
                                            } elseif ($booking_trangthai == 1) {
                                            ?>
                                                <span class="badge bg-success">Đã xác nhận</span>

                                            <?php
                                            } elseif ($booking_trangthai == 2) {
                                            ?>
                                                <span class="badge bg-danger">Đã từ chối</span>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($booking_trangthai == 0) {
                                            ?>
                                                <a class="duyet" href="duyet.php?id=<?php echo $booking_id ?>&mail=<?php echo $info_email_kh ?>"><button type="button" class="bi bi-check-circle" style="border:0px;font-size:20px; color:green;background:none" title="xác nhận"></button></a>
                                                <a class="tu_choi" href="tuchoi.php?id=<?php echo $booking_id ?>&mail=<?php echo $info_email_kh ?>"><button type="button" class="bi bi-x-circle" style="border:0px;font-size:20px; color:red;background:none" title="từ chối"></button></a>
                                            <?php

                                            } elseif ($booking_trangthai == 1) {
                                            ?>
                                                <a class="hoantac" href="hoantac.php?id=<?php echo $booking_id ?>"><button type="button" class="bi bi-arrow-return-left" style="border:0px;font-size:20px; color:red;background:none" title="Hoàn tác"></button></a>
                                            <?php

                                            } elseif ($booking_trangthai == 2) {
                                            ?>
                                                <a class="hoantac" href="hoantac.php?id=<?php echo $booking_id ?>"><button type="button" class="bi bi-arrow-return-left" style="border:0px;font-size:20px; color:red;background:none" title="Hoàn tác"></button></a>
                                            <?php
                                            }
                                            ?>
                                        </td>

                                    </tr>
                                <?php
                                }
                                ?>

                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
                <div class="donhang_list sap_toi" style="display: none;">
                    <h5 style="text-align: center;">Đơn hàng sắp tới</h5>
                    <div class="search">
                        <form action="" method="get">
                            <div class="row" style="margin: 0;">
                                <div class="col-md-2">

                                </div>
                                <div class="col-md-8">
                                    <div class="row g-5">
                                        <div class="col-auto">
                                            <label for="">Từ ngày</label>
                                        </div>
                                        <div class="col-auto">
                                            <input type="date" class="form-control" name="from_date" value="<?php if(isset($_GET['from_date'])){echo $_GET['from_date'];}?>">
                                        </div>
                                        <div class="col-auto">
                                            <label for="">Đến ngày</label>
                                        </div>
                                        <div class="col-auto">
                                            <input type="date" class="form-control" name="to_date" value="<?php if(isset($_GET['to_date'])){echo $_GET['to_date'];}?>">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn button_submit" name="search_btn">Tìm kiếm</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">

                                </div>

                            </div>
                        </form>
                    </div>
                    <table class="table" id="next_order">
                        <thead>
                            <tr class="table-success">
                                <th scope="col">STT</th>
                                <th scope="col">Họ KH</th>
                                <th scope="col">Tên KH</th>
                                <th scope="col">SDT</th>
                                <th scope="col">Email</th>
                                <th scope="col">Dịch vụ</th>
                                <th scope="col">Ngày đặt</th>
                                <th scope="col">Ngày sử dụng</th>
                                <th scope="col">Người lớn</th>
                                <th scope="col">Trẻ em</th>
                                <th scope="col">Tổng giá</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                                $from_date = $_GET['from_date'];
                                $to_date = $_GET['to_date'];
                                $sql_search = "SELECT booking.booking_id,booking.chitiet_tour_id,chitiet_tour.chitiet_ten,
                               booking.booking_ngaybook,booking.booking_ngaysudung,booking.booking_sl_nguoilon,booking.booking_sl_treem,
                               booking.booking_tonggia,booking.booking_trangthai,booking.kh_id,booking_khachhang.info_ho_kh,
                               booking_khachhang.info_ten_kh,booking_khachhang.info_sdt_kh,booking_khachhang.info_email_kh
                               FROM ((booking
                                     INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                     INNER JOIN booking_khachhang ON booking_khachhang.kh_id=booking.kh_id)
                                     WHERE booking.tour_id='$tour_id' && booking.booking_ngaysudung > now() && booking.booking_ngaysudung BETWEEN '$from_date' AND '$to_date' ";
                                $result_search = mysqli_query($conn, $sql_search);
                                if (mysqli_num_rows($result_search) > 0) {
                                    while ($search = mysqli_fetch_assoc($result_search)) {
                                        $booking_id = $search['booking_id'];
                                        $chitiet_tour_id = $search['chitiet_tour_id'];
                                        $chitiet_ten = $search['chitiet_ten'];
                                        $booking_ngaybook = $search['booking_ngaybook'];
                                        $booking_ngaysudung = $search['booking_ngaysudung'];
                                        $booking_sl_nguoilon = $search['booking_sl_nguoilon'];
                                        $booking_sl_treem = $search['booking_sl_treem'];
                                        $booking_tonggia = $search['booking_tonggia'];
                                        $booking_trangthai = $search['booking_trangthai'];
                                        $kh_id = $search['kh_id'];
                                        $info_ho_kh = $search['info_ho_kh'];
                                        $info_ten_kh = $search['info_ten_kh'];
                                        $info_sdt_kh = $search['info_sdt_kh'];
                                        $info_email_kh = $search['info_email_kh'];
                            ?>
                                        <tr style="background-color: #fff;">
                                            <td><?php echo $n++ ?></td>
                                            <td><?php echo $info_ho_kh ?></td>
                                            <td><?php echo $info_ten_kh ?></td>
                                            <td><?php echo $info_sdt_kh ?></td>
                                            <td><?php echo $info_email_kh ?></td>
                                            <td><?php echo $chitiet_ten ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($booking_ngaybook)) ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($booking_ngaysudung)) ?></td>
                                            <td><?php echo $booking_sl_nguoilon ?></td>
                                            <td><?php echo $booking_sl_treem ?></td>
                                            <td><?php echo number_format($booking_tonggia)  ?></td>
                                            <td>
                                                <?php if ($booking_trangthai == 0) {
                                                ?>
                                                    <span class="badge bg-info">Chưa xử lý</span>
                                                <?php
                                                } elseif ($booking_trangthai == 1) {
                                                ?>
                                                    <span class="badge bg-success">Đã xác nhận</span>

                                                <?php
                                                } elseif ($booking_trangthai == 2) {
                                                ?>
                                                    <span class="badge bg-danger">Đã từ chối</span>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($booking_trangthai == 0) {
                                                ?>
                                                    <a class="duyet" href="duyet.php?id=<?php echo $booking_id ?>&mail=<?php echo $info_email_kh ?>"><button type="button" class="bi bi-check-circle" style="border:0px;font-size:20px; color:green;background:none" title="xác nhận"></button></a>
                                                    <a class="tu_choi" href="tuchoi.php?id=<?php echo $booking_id ?>&mail=<?php echo $info_email_kh ?>"><button type="button" class="bi bi-x-circle" style="border:0px;font-size:20px; color:red;background:none" title="từ chối"></button></a>
                                                <?php

                                                } elseif ($booking_trangthai == 1) {
                                                ?>
                                                    <a class="hoantac" href="hoantac.php?id=<?php echo $booking_id ?>"><button type="button" class="bi bi-arrow-return-left" style="border:0px;font-size:20px; color:red;background:none" title="Hoàn tác"></button></a>
                                                <?php

                                                } elseif ($booking_trangthai == 2) {
                                                ?>
                                                    <a class="hoantac" href="hoantac.php?id=<?php echo $booking_id ?>"><button type="button" class="bi bi-arrow-return-left" style="border:0px;font-size:20px; color:red;background:none" title="Hoàn tác"></button></a>
                                                <?php
                                                }
                                                ?>
                                            </td>

                                        </tr>
                                    <?php
                                    }
                                } else {
                                    echo "no records find";
                                }
                            } else {
                                $sql_booking = "SELECT booking.booking_id,booking.chitiet_tour_id,chitiet_tour.chitiet_ten,
                                booking.booking_ngaybook,booking.booking_ngaysudung,booking.booking_sl_nguoilon,booking.booking_sl_treem,
                                booking.booking_tonggia,booking.booking_trangthai,booking.kh_id,booking_khachhang.info_ho_kh,
                                booking_khachhang.info_ten_kh,booking_khachhang.info_sdt_kh,booking_khachhang.info_email_kh
                                FROM ((booking
                                      INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                      INNER JOIN booking_khachhang ON booking_khachhang.kh_id=booking.kh_id)
                                      WHERE booking.tour_id='$tour_id' && booking.booking_ngaysudung > now() ";
                                $result_booking = mysqli_query($conn, $sql_booking);
                                $n = 1;
                                if (mysqli_num_rows($result_booking) > 0) {
                                    while ($booking = mysqli_fetch_assoc($result_booking)) {
                                        $booking_id = $booking['booking_id'];
                                        $chitiet_tour_id = $booking['chitiet_tour_id'];
                                        $chitiet_ten = $booking['chitiet_ten'];
                                        $booking_ngaybook = $booking['booking_ngaybook'];
                                        $booking_ngaysudung = $booking['booking_ngaysudung'];
                                        $booking_sl_nguoilon = $booking['booking_sl_nguoilon'];
                                        $booking_sl_treem = $booking['booking_sl_treem'];
                                        $booking_tonggia = $booking['booking_tonggia'];
                                        $booking_trangthai = $booking['booking_trangthai'];
                                        $kh_id = $booking['kh_id'];
                                        $info_ho_kh = $booking['info_ho_kh'];
                                        $info_ten_kh = $booking['info_ten_kh'];
                                        $info_sdt_kh = $booking['info_sdt_kh'];
                                        $info_email_kh = $booking['info_email_kh'];
                                    ?>
                                        <tr style="background-color: #fff;">
                                            <td><?php echo $n++ ?></td>
                                            <td><?php echo $info_ho_kh ?></td>
                                            <td><?php echo $info_ten_kh ?></td>
                                            <td><?php echo $info_sdt_kh ?></td>
                                            <td><?php echo $info_email_kh ?></td>
                                            <td><?php echo $chitiet_ten ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($booking_ngaybook)) ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($booking_ngaysudung)) ?></td>
                                            <td><?php echo $booking_sl_nguoilon ?></td>
                                            <td><?php echo $booking_sl_treem ?></td>
                                            <td><?php echo number_format($booking_tonggia)  ?></td>
                                            <td>
                                                <?php if ($booking_trangthai == 0) {
                                                ?>
                                                    <span class="badge bg-info">Chưa xử lý</span>
                                                <?php
                                                } elseif ($booking_trangthai == 1) {
                                                ?>
                                                    <span class="badge bg-success">Đã xác nhận</span>

                                                <?php
                                                } elseif ($booking_trangthai == 2) {
                                                ?>
                                                    <span class="badge bg-danger">Đã từ chối</span>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($booking_trangthai == 0) {
                                                ?>
                                                    <a class="duyet" href="duyet.php?id=<?php echo $booking_id ?>&mail=<?php echo $info_email_kh ?>"><button type="button" class="bi bi-check-circle" style="border:0px;font-size:20px; color:green;background:none" title="xác nhận"></button></a>
                                                    <a class="tu_choi" href="tuchoi.php?id=<?php echo $booking_id ?>&mail=<?php echo $info_email_kh ?>"><button type="button" class="bi bi-x-circle" style="border:0px;font-size:20px; color:red;background:none" title="từ chối"></button></a>
                                                <?php

                                                } elseif ($booking_trangthai == 1) {
                                                ?>
                                                    <a class="hoantac" href="hoantac.php?id=<?php echo $booking_id ?>"><button type="button" class="bi bi-arrow-return-left" style="border:0px;font-size:20px; color:red;background:none" title="Hoàn tác"></button></a>
                                                <?php

                                                } elseif ($booking_trangthai == 2) {
                                                ?>
                                                    <a class="hoantac" href="hoantac.php?id=<?php echo $booking_id ?>"><button type="button" class="bi bi-arrow-return-left" style="border:0px;font-size:20px; color:red;background:none" title="Hoàn tác"></button></a>
                                                <?php
                                                }
                                                ?>
                                            </td>

                                        </tr>
                                <?php
                                    }
                                }
                                ?>

                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
                <div class="donhang_list da_qua" style="display: none;">
                    <h5 style="text-align: center;">Đơn hàng đã qua</h5>
                    <table class="table" id="old_order">
                        <thead>
                            <tr class="table-success">
                                <th scope="col">STT</th>
                                <th scope="col">Họ KH</th>
                                <th scope="col">Tên KH</th>
                                <th scope="col">SDT</th>
                                <th scope="col">Email</th>
                                <th scope="col">Dịch vụ</th>
                                <th scope="col">Ngày đặt</th>
                                <th scope="col">Ngày sử dụng</th>
                                <th scope="col">Người lớn</th>
                                <th scope="col">Trẻ em</th>
                                <th scope="col">Tổng giá</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_booking = "SELECT booking.booking_id,booking.chitiet_tour_id,chitiet_tour.chitiet_ten,
                        booking.booking_ngaybook,booking.booking_ngaysudung,booking.booking_sl_nguoilon,booking.booking_sl_treem,
                        booking.booking_tonggia,booking.booking_trangthai,booking.kh_id,booking_khachhang.info_ho_kh,
                        booking_khachhang.info_ten_kh,booking_khachhang.info_sdt_kh,booking_khachhang.info_email_kh
                        FROM ((booking
                              INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                              INNER JOIN booking_khachhang ON booking_khachhang.kh_id=booking.kh_id)
                              WHERE booking.tour_id='$tour_id' && DATE(booking.booking_ngaysudung) < DATE(NOW())";
                            $result_booking = mysqli_query($conn, $sql_booking);
                            $n = 1;
                            if (mysqli_num_rows($result_booking) > 0) {
                                while ($booking = mysqli_fetch_assoc($result_booking)) {
                                    $booking_id = $booking['booking_id'];
                                    $chitiet_tour_id = $booking['chitiet_tour_id'];
                                    $chitiet_ten = $booking['chitiet_ten'];
                                    $booking_ngaybook = $booking['booking_ngaybook'];
                                    $booking_ngaysudung = $booking['booking_ngaysudung'];
                                    $booking_sl_nguoilon = $booking['booking_sl_nguoilon'];
                                    $booking_sl_treem = $booking['booking_sl_treem'];
                                    $booking_tonggia = $booking['booking_tonggia'];
                                    $booking_trangthai = $booking['booking_trangthai'];
                                    $kh_id = $booking['kh_id'];
                                    $info_ho_kh = $booking['info_ho_kh'];
                                    $info_ten_kh = $booking['info_ten_kh'];
                                    $info_sdt_kh = $booking['info_sdt_kh'];
                                    $info_email_kh = $booking['info_email_kh'];

                            ?>
                                    <tr style="background-color: #fff;">
                                        <td><?php echo $n++ ?></td>
                                        <td><?php echo $info_ho_kh ?></td>
                                        <td><?php echo $info_ten_kh ?></td>
                                        <td><?php echo $info_sdt_kh ?></td>
                                        <td><?php echo $info_email_kh ?></td>
                                        <td><?php echo $chitiet_ten ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($booking_ngaybook)) ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($booking_ngaysudung)) ?></td>
                                        <td><?php echo $booking_sl_nguoilon ?></td>
                                        <td><?php echo $booking_sl_treem ?></td>
                                        <td><?php echo number_format($booking_tonggia)  ?></td>
                                        <td>
                                            <?php if ($booking_trangthai == 0) {
                                            ?>
                                                <span class="badge bg-info">Chưa xử lý</span>
                                            <?php
                                            } elseif ($booking_trangthai == 1) {
                                            ?>
                                                <span class="badge bg-success">Đã xác nhận</span>

                                            <?php
                                            } elseif ($booking_trangthai == 2) {
                                            ?>
                                                <span class="badge bg-danger">Đã từ chối</span>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($booking_trangthai == 0) {
                                            ?>
                                                <a class="duyet" href="duyet.php?id=<?php echo $booking_id ?>&mail=<?php echo $info_email_kh ?>"><button type="button" class="bi bi-check-circle" style="border:0px;font-size:20px; color:green;background:none" title="xác nhận"></button></a>
                                                <a class="tu_choi" href="tuchoi.php?id=<?php echo $booking_id ?>&mail=<?php echo $info_email_kh ?>"><button type="button" class="bi bi-x-circle" style="border:0px;font-size:20px; color:red;background:none" title="từ chối"></button></a>
                                            <?php

                                            } elseif ($booking_trangthai == 1) {
                                            ?>
                                                <a class="hoantac" href="hoantac.php?id=<?php echo $booking_id ?>"><button type="button" class="bi bi-arrow-return-left" style="border:0px;font-size:20px; color:red;background:none" title="Hoàn tác"></button></a>
                                            <?php

                                            } elseif ($booking_trangthai == 2) {
                                            ?>
                                                <a class="hoantac" href="hoantac.php?id=<?php echo $booking_id ?>"><button type="button" class="bi bi-arrow-return-left" style="border:0px;font-size:20px; color:red;background:none" title="Hoàn tác"></button></a>
                                            <?php
                                            }
                                            ?>
                                        </td>

                                    </tr>
                                <?php
                                }
                                ?>

                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
                <div class="donhang_list tat_ca" style="display: none;">
                    <h5 style="text-align: center;">Tất cả đơn hàng</h5>
                    <table class="table" id="all_order">
                        <thead>
                            <tr class="table-success">
                                <th scope="col">STT</th>
                                <th scope="col">Họ KH</th>
                                <th scope="col">Tên KH</th>
                                <th scope="col">SDT</th>
                                <th scope="col">Email</th>
                                <th scope="col">Dịch vụ</th>
                                <th scope="col">Ngày đặt</th>
                                <th scope="col">Ngày sử dụng</th>
                                <th scope="col">Người lớn</th>
                                <th scope="col">Trẻ em</th>
                                <th scope="col">Tổng giá</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_booking = "SELECT booking.booking_id,booking.chitiet_tour_id,chitiet_tour.chitiet_ten,
                        booking.booking_ngaybook,booking.booking_ngaysudung,booking.booking_sl_nguoilon,booking.booking_sl_treem,
                        booking.booking_tonggia,booking.booking_trangthai,booking.kh_id,booking_khachhang.info_ho_kh,
                        booking_khachhang.info_ten_kh,booking_khachhang.info_sdt_kh,booking_khachhang.info_email_kh
                        FROM ((booking
                              INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                              INNER JOIN booking_khachhang ON booking_khachhang.kh_id=booking.kh_id)
                              WHERE booking.tour_id='$tour_id'";
                            $result_booking = mysqli_query($conn, $sql_booking);
                            $n = 1;
                            if (mysqli_num_rows($result_booking) > 0) {
                                while ($booking = mysqli_fetch_assoc($result_booking)) {
                                    $booking_id = $booking['booking_id'];
                                    $chitiet_tour_id = $booking['chitiet_tour_id'];
                                    $chitiet_ten = $booking['chitiet_ten'];
                                    $booking_ngaybook = $booking['booking_ngaybook'];
                                    $booking_ngaysudung = $booking['booking_ngaysudung'];
                                    $booking_sl_nguoilon = $booking['booking_sl_nguoilon'];
                                    $booking_sl_treem = $booking['booking_sl_treem'];
                                    $booking_tonggia = $booking['booking_tonggia'];
                                    $booking_trangthai = $booking['booking_trangthai'];
                                    $kh_id = $booking['kh_id'];
                                    $info_ho_kh = $booking['info_ho_kh'];
                                    $info_ten_kh = $booking['info_ten_kh'];
                                    $info_sdt_kh = $booking['info_sdt_kh'];
                                    $info_email_kh = $booking['info_email_kh'];

                            ?>
                                    <tr style="background-color: #fff;">
                                        <td><?php echo $n++ ?></td>
                                        <td><?php echo $info_ho_kh ?></td>
                                        <td><?php echo $info_ten_kh ?></td>
                                        <td><?php echo $info_sdt_kh ?></td>
                                        <td><?php echo $info_email_kh ?></td>
                                        <td><?php echo $chitiet_ten ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($booking_ngaybook)) ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($booking_ngaysudung)) ?></td>
                                        <td><?php echo $booking_sl_nguoilon ?></td>
                                        <td><?php echo $booking_sl_treem ?></td>
                                        <td><?php echo number_format($booking_tonggia)  ?></td>
                                        <td>
                                            <?php if ($booking_trangthai == 0) {
                                            ?>
                                                <span class="badge bg-info">Chưa xử lý</span>
                                            <?php
                                            } elseif ($booking_trangthai == 1) {
                                            ?>
                                                <span class="badge bg-success">Đã xác nhận</span>

                                            <?php
                                            } elseif ($booking_trangthai == 2) {
                                            ?>
                                                <span class="badge bg-danger">Đã từ chối</span>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($booking_trangthai == 0) {
                                            ?>
                                                <a class="duyet" href="duyet.php?id=<?php echo $booking_id ?>&mail=<?php echo $info_email_kh ?>"><button type="button" class="bi bi-check-circle" style="border:0px;font-size:20px; color:green;background:none" title="xác nhận"></button></a>
                                                <a class="tu_choi" href="tuchoi.php?id=<?php echo $booking_id ?>&mail=<?php echo $info_email_kh ?>"><button type="button" class="bi bi-x-circle" style="border:0px;font-size:20px; color:red;background:none" title="từ chối"></button></a>
                                            <?php

                                            } elseif ($booking_trangthai == 1) {
                                            ?>
                                                <a class="hoantac" href="hoantac.php?id=<?php echo $booking_id ?>"><button type="button" class="bi bi-arrow-return-left" style="border:0px;font-size:20px; color:red;background:none" title="Hoàn tác"></button></a>
                                            <?php

                                            } elseif ($booking_trangthai == 2) {
                                            ?>
                                                <a class="hoantac" href="hoantac.php?id=<?php echo $booking_id ?>"><button type="button" class="bi bi-arrow-return-left" style="border:0px;font-size:20px; color:red;background:none" title="Hoàn tác"></button></a>
                                            <?php
                                            }
                                            ?>
                                        </td>

                                    </tr>
                                <?php
                                }
                                ?>

                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>





        </div>
        <?php
        include("../templates/footer.html")
        ?>
    </div>

    <!--duyet don hang  -->
    <?php if (isset($_GET['d'])) : ?>
        <div class="duyet" data-flashdata="<?= $_GET['d']; ?>"></div>
    <?php endif; ?>
    <script>
        $('.duyet').on('click', function(e) {
            e.preventDefault();
            var self = $(this);
            console.log(self.data('title'));
            Swal.fire({
                title: 'Bạn có chắc muốn duyệt đơn hàng này?',
                // text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Chắc chắn!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = self.attr('href');
                }
            })

        })
        const flashdata = $('.duyet').data('flashdata')
        if (flashdata) {
            Swal.fire(
                'Đã duyệt!',
                'Đơn hàng đã được duyệt.',
                'success'
            )
        }
    </script>
    <!-- end duyet don hang -->

    <!--tu choi don hang  -->
    <?php if (isset($_GET['t'])) : ?>
        <div class="kk" data-flashdata="<?= $_GET['t']; ?>"></div>
    <?php endif; ?>
    <script>
        $('.tu_choi').on('click', function(e) {
            e.preventDefault();
            var self = $(this);
            console.log(self.data('title'));
            Swal.fire({
                title: 'Bạn có chắc muốn từ chối đơn hàng này?',
                // text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Chắc chắn!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = self.attr('href');
                }
            })

        })
        const tuchoi = $('.kk').data('1')
        if (tuchoi) {
            Swal.fire(
                'Đã từ chối!',
                'Đơn hàng đã bị từ chối.',
                'success'
            )
        }
    </script>
    <!-- end tu choi don hang -->

    <!-- hoan tac  -->
    <script>
        $('.hoantac').on('click', function(e) {
            e.preventDefault();
            var self = $(this);
            console.log(self.data('title'));
            Swal.fire({
                title: 'Bạn muốn cập nhật lại trạng thái đơn hàng này?',
                // text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Chắc chắn!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = self.attr('href');
                }
            })

        })
    </script>
    <!-- end hoan tac -->

    <script src="../js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $('#all_order').DataTable({
            "pageLength": 5,
            "lengthMenu": [5, 10, 20, 30, 50]

        });

        $('#today_order').DataTable({
            "pageLength": 5,
            "lengthMenu": [5, 10, 20, 30, 50]

        });

        $('#next_order').DataTable({
            "pageLength": 5,
            "lengthMenu": [5, 10, 20, 30, 50]

        });

        $('#old_order').DataTable({
            "pageLength": 5,
            "lengthMenu": [5, 10, 20, 30, 50]

        });
    </script>
    <!-- hien thi thong ke ngay hom nay -->
    <script>
        function hienthi_homnay() {
            $(".hom_nay").show();
            $(".sap_toi").hide();
            $(".da_qua").hide();
            $(".tat_ca").hide();
            document.getElementById("homnay_btn").style.backgroundColor = "#22577a";
            document.getElementById("saptoi_btn").style.backgroundColor = "#2d7d90";
            document.getElementById("daqua_btn").style.backgroundColor = "#2d7d90";
            document.getElementById("tatca_btn").style.backgroundColor = "#2d7d90";
        }
    </script>
    <!-- end hien thi thong ke ngay hom nay -->

    <!-- hien thi thong ke sap toi -->
    <script>
        function hienthi_saptoi() {
            $(".hom_nay").hide();
            $(".sap_toi").show();
            $(".da_qua").hide();
            $(".tat_ca").hide();
            document.getElementById("homnay_btn").style.backgroundColor = "#2d7d90";
            document.getElementById("saptoi_btn").style.backgroundColor = "#22577a";
            document.getElementById("daqua_btn").style.backgroundColor = "#2d7d90";
            document.getElementById("tatca_btn").style.backgroundColor = "#2d7d90";
            window.onload = function() {
                $(".sap_toi").show();

            }

        }
    </script>
    <!-- end hien thi thong ke sap toi -->

    <!-- hien thi thong ke da qua -->
    <script>
        function hienthi_daqua() {
            $(".hom_nay").hide();
            $(".sap_toi").hide();
            $(".da_qua").show();
            $(".tat_ca").hide();
            document.getElementById("homnay_btn").style.backgroundColor = "#2d7d90";
            document.getElementById("saptoi_btn").style.backgroundColor = "#2d7d90";
            document.getElementById("daqua_btn").style.backgroundColor = "#22577a";
            document.getElementById("tatca_btn").style.backgroundColor = "#2d7d90";
        }
    </script>
    <!-- end hien thi thong ke da qua -->

    <!-- hien thi thong ke tat ca -->
    <script>
        function hienthi_tatca() {
            $(".hom_nay").hide();
            $(".sap_toi").hide();
            $(".da_qua").hide();
            $(".tat_ca").show();
            document.getElementById("homnay_btn").style.backgroundColor = "#2d7d90";
            document.getElementById("saptoi_btn").style.backgroundColor = "#2d7d90";
            document.getElementById("daqua_btn").style.backgroundColor = "#2d7d90";
            document.getElementById("tatca_btn").style.backgroundColor = "#22577a";
        }
    </script>
    <!-- end hien thi thong ke tat ca -->

</body>

</html>
<?php
if (isset($_POST["update_submit"])) {
    // echo"<script>console.log('clicked')</script>";
    $tour_avt = $_FILES['update_tour_avt']['name'];
    $path = "../image";
    $chitiet_avt_ext = pathinfo($tour_avt, PATHINFO_EXTENSION);
    $filename = time() . '.' . $chitiet_avt_ext;
    $tour_id = $_POST["tour_id"];
    $tour_ten = $_POST["update_tour_ten"];
    $tour_dienthoai = $_POST["update_tour_dienthoai"];
    $loaitour_id = $_POST["update_loaitour_id"];
    $tinh_id = $_POST["update_tinh_id"];
    $huyen_id = $_POST["update_huyen_id"];
    $xa_id = $_POST["update_xa_id"];
    $tour_diachi = $_POST["update_tour_diachi"];

    $sql_update_info = "UPDATE `tour` SET `loaitour_id`='$loaitour_id',`tour_ten`='$tour_ten',
    `tour_dienthoai`='$tour_dienthoai',`tinh_id`='$tinh_id',`huyen_id`='$huyen_id',`xa_id`='$xa_id',
    `tour_diachi`='$tour_diachi',`tour_avt`='$filename' WHERE tour_id='$tour_id'";
    if (mysqli_query($conn, $sql_update_info)) {
        move_uploaded_file($_FILES['update_tour_avt']['tmp_name'], $path . '/' . $filename);
?>

        <div class="flash-data" data-flashdata=1></div>
        <script>
            const flashdata = $('.flash-data').data('flashdata')
            if (flashdata) {
                Swal.fire(
                    'Thành công!',
                    'Đã cập nhật thông tin của bạn.',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        location.href = 'gioithieu.php';
                    }
                })
            }
        </script>
<?php
    } else {
        echo "<script>console.log('not update')</script>";
    }
}
?>