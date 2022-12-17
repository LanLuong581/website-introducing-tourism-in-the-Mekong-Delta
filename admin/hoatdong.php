<?php
include('../config/constants.php');
session_start();
if (!isset($_SESSION['acc_account_loaitaikhoan'])) {
    header("location:../templates/login.php");
} else {
    if ($_SESSION['acc_account_loaitaikhoan'] != 1) {
        header("location:../templates/login.php");
    }
}
if (isset($_SESSION["acc_email"])) {
    $email_admin = $_SESSION["acc_email"];
    $sql_account = "SELECT `account_id`FROM `account` WHERE account_email='$email_admin'";
    $result_account = mysqli_query($conn, $sql_account);
    if (mysqli_num_rows($result_account) > 0) {
        while ($account = mysqli_fetch_assoc($result_account)) {
            $account_id = $account['account_id'];
        }
    }
}

$tour_id = $_GET['tour_id'];
$sql_ten = "select tour_ten from tour where tour_id='$tour_id'";
$result = mysqli_query($conn, $sql_ten);
if ($result) {
    while ($ten = mysqli_fetch_assoc($result)) {
        $tour_ten = $ten['tour_ten'];
    }
}
if (isset($_GET['from_date'])) {
    $from_date = $_GET['from_date'];
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
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script src="../js/bootstrap.js"></script>
    <link rel="stylesheet" href="admin.css">
    <script src="../jquery/jquery-3.6.0.min.js"></script>
    <script src="ckfinder/ckfinder.js"></script>
    <link rel="stylesheet" href="../css/jquery.dataTables.min.css">
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

        .swal2-confirm {
            width: 135px;
        }

        .swal2-cancel {
            width: 85px;
        }

        .tour_link>a:hover {
            color: red;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".tinh").change(function() {
                var tinh_id = $(this).val();
                $.ajax({
                    url: "../vivumekong/tinh_huyen_xa.php",
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
                    url: "../vivumekong/tinh_huyen_xa.php",
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
                                <a class="nav-link active" aria-current="page" href="doanhnghiep.php">Doanh Nghiệp</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="khachhang.php">Khách Hàng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="dichvu.php">Dịch vụ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="blog.php">Blog</a>
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
                                    <li data-bs-toggle="modal" data-bs-target="#info<?php echo $account_id ?>"><a class="dropdown-item bi bi-person"> Thông tin cá nhân</a></li>
                                    <li><a class="dropdown-item bi bi-box-arrow-right" href="../templates/logout.php"> Đăng Xuất</a></li>

                                </ul>
                            </li>

                        </ul>
                        <!-- modal thong tin cá nhân -->
                        <div class="modal fade" id="info<?php echo $account_id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog ">
                                <div class="modal-content bg-modal">
                                    <div class="modal-header" style="background: #2d7d90;color:#fff">
                                        <h5 class="modal-title" id="exampleModalLabel">Thông Tin Cá Nhân</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <?php

                                    $sql = "SELECT admin.admin_id,admin.admin_ho,admin.admin_ten,admin.admin_ngaysinh,admin.admin_dienthoai,
                                    admin.admin_diachi,ward._name AS xa_ten,district._name AS huyen_ten, province._name AS tinh_ten
                                    FROM (((admin 
                                          INNER JOIN province ON province.id=admin.tinh_id)
                                          INNER JOIN district ON district.id=admin.huyen_id)
                                          INNER JOIN ward ON ward.id=admin.xa_id)
                                          WHERE account_id='$account_id'";
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $admin_id = $row['admin_id'];
                                            $admin_ho = $row['admin_ho'];
                                            $admin_ten = $row['admin_ten'];
                                            $admin_ngaysinh = $row['admin_ngaysinh'];
                                            $admin_dienthoai = $row['admin_dienthoai'];
                                            $admin_diachi = $row['admin_diachi'];
                                            $tinh_ten = $row['tinh_ten'];
                                            $huyen_ten = $row['huyen_ten'];
                                            $xa_ten = $row['xa_ten'];

                                    ?>
                                            <div class="modal-body">
                                                <form action="">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <span style="font-weight: 500;">Họ Tên:</span>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <span><?php echo $admin_ho ?> <?php echo $admin_ten ?> </span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <span style="font-weight: 500;">Ngày sinh:</span>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <span><?php echo $admin_ngaysinh ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <span style="font-weight: 500;">Số điện thoại:</span>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <span><?php echo $admin_dienthoai ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <span style="font-weight: 500;">Địa chỉ:</span>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <span><?php echo $admin_diachi ?>, <?php echo $xa_ten ?>, <?php echo $huyen_ten ?>, <?php echo $tinh_ten ?></span>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn button_close" data-bs-dismiss="modal">Đóng</button>
                                                <button class="btn button_submit" data-bs-target="#update<?php echo $account_id ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Cập nhật</button>
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
                        <!-- end modal thong tin cá nhân -->
                        <!-- modal cap nhat thong tin ca nhan -->
                        <div class="modal fade" id="update<?php echo $account_id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="modal-header" style="background: #2d7d90;color:#fff">
                                            <h5 class="modal-title" id="exampleModalLabel" style="font-size:30px">Cập nhật thông tin</h5>
                                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            $sql_admin = "SELECT admin.admin_id,admin.admin_ho,admin.admin_ten,admin.admin_ngaysinh,admin.admin_dienthoai,
                                            admin.admin_diachi,ward._name AS xa_ten,district._name AS huyen_ten, province._name AS tinh_ten
                                            FROM (((admin 
                                                  INNER JOIN province ON province.id=admin.tinh_id)
                                                  INNER JOIN district ON district.id=admin.huyen_id)
                                                  INNER JOIN ward ON ward.id=admin.xa_id)
                                                  WHERE account_id='$account_id'";
                                            $result_admin = mysqli_query($conn, $sql_admin);
                                            if (mysqli_num_rows($result_admin) > 0) {
                                                while ($ad_result = mysqli_fetch_assoc($result_admin)) {
                                                    $admin_id = $ad_result['admin_id'];
                                                    $admin_ho = $ad_result['admin_ho'];
                                                    $admin_ten = $ad_result['admin_ten'];
                                                    $admin_ngaysinh = $ad_result['admin_ngaysinh'];
                                                    $admin_dienthoai = $ad_result['admin_dienthoai'];
                                                    $admin_diachi = $ad_result['admin_diachi'];
                                                    $tinh_ten = $ad_result['tinh_ten'];
                                                    $huyen_ten = $ad_result['huyen_ten'];
                                                    $xa_ten = $ad_result['xa_ten'];
                                                }

                                            ?>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="hidden" name="update_admin_id" value="<?php echo $admin_id ?>">
                                                            <label for="" class="form-label" style="font-weight: 500;">Họ</label>
                                                            <input type="text" class="form-control" id="update_admin_ho" name="update_admin_ho" value="<?php echo $admin_ho ?>" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="" class="form-label" style="font-weight: 500;">Tên</label>
                                                            <input type="text" class="form-control" name="update_admin_ten" id="update_admin_ten" value="<?php echo $admin_ten ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="" class="form-label" style="font-weight: 500;">Số điện thoại</label>
                                                            <input type="text" class="form-control" name="update_admin_dienthoai" id="update_admin_dienthoai" value="<?php echo $admin_dienthoai ?>" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="" class="form-label" style="font-weight: 500;">Ngày sinh</label>
                                                            <input type="date" class="form-control" id="update_admin_ngaysinh" name="update_admin_ngaysinh" value="<?php echo $admin_ngaysinh ?>">
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
                                                                <input type="text" class="form-control" style="border:none" id="update_admin_diachi" name="update_admin_diachi" value="<?php echo $admin_diachi ?>" required>
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
                        <!--end modal cap nhat thong tin ca nhan -->
                    </div>
                </div>
            </nav>
        </div>
        <div class="main-content" style="background-color: #f8f9fa;">
            <div class="col-md-12">
                <div class="row" style="margin:0">
                    <div class="col-md-12" style="padding:0">
                        <div class="row" style="margin:0">
                            <h4 style="text-align: center;">Tình hình hoạt động của doanh nghiệp <br><?php echo $tour_ten ?></h4>

                            <!-- tim theo ngay -->
                            <div class="search">
                                <form action="hoatdong.php">
                                    <div class="row" style="margin: 0;">
                                        <div class="col-md-2">

                                        </div>
                                        <div class="col-md-8">
                                            <div class="row g-5">
                                                <div class="col-auto">
                                                    <label for="">Từ ngày</label>
                                                </div>
                                                <div class="col-auto">
                                                    <input type="hidden" name="tour_id" id="tour_id" value="<?php echo $tour_id ?>">
                                                    <input type="date" class="form-control" name="from_date" value="<?php if (isset($_GET['from_date'])) {
                                                                                                                        echo $_GET['from_date'];
                                                                                                                    } ?>">
                                                </div>
                                                <div class="col-auto">
                                                    <label for="">Đến ngày</label>
                                                </div>
                                                <div class="col-auto">
                                                    <input type="date" class="form-control" name="to_date" value="<?php if (isset($_GET['to_date'])) {
                                                                                                                        echo $_GET['to_date'];
                                                                                                                    } ?>">
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
                            <!-- end tim theo ngay -->
                            <?php

                            ?>
                            <table class="table " id="dichvu">
                                <thead>
                                    <tr class="table-success">
                                        <th>#</th>
                                        <th>Tên dịch vụ</th>
                                        <th>Họ</th>
                                        <th>Tên</th>
                                        <th>Điện thoại</th>
                                        <th>Email</th>
                                        <th>Người lớn</th>
                                        <th>Trẻ em</th>
                                        <th>Ngày đặt</th>
                                        <th>Ngày sử dụng</th>
                                        <th>Giá</th>
                                        <th>Trạng Thái</th>

                                    </tr>
                                </thead>
                                <tbody style="background-color: #fff;">
                                    <?php
                                    if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                                        $from_date = $_GET['from_date'];
                                        $to_date = $_GET['to_date'];
                                        $sn = 1;
                                        $sql = "SELECT booking.booking_id,booking.chitiet_tour_id,chitiet_tour.chitiet_ten,
                                            booking.booking_ngaybook,booking.booking_ngaysudung,booking.booking_sl_nguoilon,booking.booking_sl_treem,
                                            booking.booking_tonggia,booking.booking_trangthai,booking.kh_id,booking_khachhang.info_ho_kh,
                                            booking_khachhang.info_ten_kh,booking_khachhang.info_sdt_kh,booking_khachhang.info_email_kh
                                           
                                            FROM ((booking
                                                  INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                                  INNER JOIN booking_khachhang ON booking_khachhang.kh_id=booking.kh_id)
                                                  WHERE booking.tour_id='$tour_id' && NOT booking.booking_trangthai ='4' && booking.booking_ngaysudung BETWEEN '$from_date' AND '$to_date'";
                                        $result = mysqli_query($conn, $sql);


                                        if (mysqli_num_rows($result) > 0) {
                                            $tong_nguoilon = 0;
                                            $tong_treem = 0;
                                            $tong_thu = 0;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                                <tr>
                                                    <td style="width:3%"><?php echo $sn++ ?></td>
                                                    <td style="width:15%"><?php echo $row['chitiet_ten'] ?></td>
                                                    <td><?php echo $row['info_ho_kh'] ?></td>
                                                    <td><?php echo $row['info_ten_kh'] ?></td>
                                                    <td><?php echo $row['info_sdt_kh'] ?></td>
                                                    <td><?php echo $row['info_email_kh'] ?></td>
                                                    <td><?php echo $row['booking_sl_nguoilon'] ?></td>
                                                    <td><?php echo $row['booking_sl_treem'] ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($row['booking_ngaybook']))  ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($row['booking_ngaysudung'])) ?></td>
                                                    <td><?php echo number_format($row['booking_tonggia'])  ?></td>
                                                    <td>
                                                        <?php if ($row['booking_trangthai'] == 0) : ?>
                                                            <span class="badge bg-warning">Chưa xử lý</span>
                                                        <?php elseif ($row['booking_trangthai'] == 1) : ?>
                                                            <span class="badge bg-success">Đã xác nhận</span>
                                                        <?php elseif ($row['booking_trangthai'] == 2) : ?>
                                                            <span class="badge bg-danger">Đã từ chối</span>
                                                        <?php elseif ($row['booking_trangthai'] == 3) : ?>
                                                            <span class="badge bg-danger">Bị hủy</span>
                                                        <?php elseif ($row['booking_trangthai'] == 5) : ?>
                                                            <span class="badge bg-secondary">Đã xuất</span>

                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php
                                                $tong_nguoilon = $tong_nguoilon + $row['booking_sl_nguoilon'];
                                                $tong_treem = $tong_treem + $row['booking_sl_treem'];
                                                $tong_thu = $tong_thu + $row['booking_tonggia'];
                                            }
                                            ?>
                                            <tr>
                                                <th style="width:7%">Tổng cộng</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th> <?php echo $tong_nguoilon ?></th>
                                                <th><?php echo $tong_treem ?></th>
                                                <th></th>
                                                <th></th>
                                                <th><?php echo number_format($tong_thu)  ?></th>
                                                <th></th>
                                            </tr>


                                            <?php
                                        } else {
                                            echo "Chưa có dữ liệu";
                                        }
                                    } else {
                                        $sn = 1;
                                        $sql = "SELECT booking.booking_id,booking.chitiet_tour_id,chitiet_tour.chitiet_ten,
                                        booking.booking_ngaybook,booking.booking_ngaysudung,booking.booking_sl_nguoilon,booking.booking_sl_treem,
                                        booking.booking_tonggia,booking.booking_trangthai,booking.kh_id,booking_khachhang.info_ho_kh,
                                        booking_khachhang.info_ten_kh,booking_khachhang.info_sdt_kh,booking_khachhang.info_email_kh
                                       
                                        FROM ((booking
                                              INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                              INNER JOIN booking_khachhang ON booking_khachhang.kh_id=booking.kh_id)
                                              WHERE booking.tour_id='$tour_id' && NOT booking.booking_trangthai ='4' ";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            $tong_nguoilon = 0;
                                            $tong_treem = 0;
                                            $tong_thu = 0;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                <tr>
                                                    <td style="width:3%"><?php echo $sn++ ?></td>
                                                    <td style="width:15%"><?php echo $row['chitiet_ten'] ?></td>
                                                    <td><?php echo $row['info_ho_kh'] ?></td>
                                                    <td><?php echo $row['info_ten_kh'] ?></td>
                                                    <td><?php echo $row['info_sdt_kh'] ?></td>
                                                    <td><?php echo $row['info_email_kh'] ?></td>
                                                    <td><?php echo $row['booking_sl_nguoilon'] ?></td>
                                                    <td><?php echo $row['booking_sl_treem'] ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($row['booking_ngaybook']))  ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($row['booking_ngaysudung'])) ?></td>
                                                    <td><?php echo number_format($row['booking_tonggia'])  ?></td>
                                                    <td>
                                                        <?php if ($row['booking_trangthai'] == 0) : ?>
                                                            <span class="badge bg-info">Chưa xử lý</span>
                                                        <?php elseif ($row['booking_trangthai'] == 1) : ?>
                                                            <span class="badge bg-success">Đã xác nhận</span>
                                                        <?php elseif ($row['booking_trangthai'] == 2) : ?>
                                                            <span class="badge bg-warning">Đã từ chối</span>
                                                        <?php elseif ($row['booking_trangthai'] == 3) : ?>
                                                            <span class="badge bg-danger">Bị hủy</span>
                                                        <?php elseif ($row['booking_trangthai'] == 5) : ?>
                                                            <span class="badge bg-secondary">Đã xuất</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php
                                                $tong_nguoilon = $tong_nguoilon + $row['booking_sl_nguoilon'];
                                                $tong_treem = $tong_treem + $row['booking_sl_treem'];
                                                $tong_thu = $tong_thu + $row['booking_tonggia'];
                                            }
                                            ?>
                                            <th style="width:7%">Tổng cộng</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th> <?php echo $tong_nguoilon ?></th>
                                            <th><?php echo $tong_treem ?></th>
                                            <th></th>
                                            <th></th>
                                            <th><?php echo number_format($tong_thu)  ?></th>
                                            <th></th>
                                    <?php
                                        } else {
                                            echo "Chưa có dữ liệu";
                                        }
                                    }
                                    ?>
                                </tbody>

                            </table>

                            <!-- thong ke -->
                            <h4 style="text-align: center;">Thống kê</h4>
                            <div class="row" style="margin: 0;">
                                <div class="col-md-6">
                                    <h5 style="text-align: center;">Đơn chưa duyệt</h5>
                                    <table class="table" style="border: 1px solid black;" id="chuaduyet">
                                        <thead>
                                            <tr class="table-info">
                                                <th>#</th>
                                                <th>Dịch Vụ</th>
                                                <th>Tổng người lớn</th>
                                                <th>Tổng trẻ em</th>
                                                <th>Tổng giá</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $n = 1;
                                            $nguoilon_chuaduyet = 0;
                                            $treem_chuaduyet = 0;
                                            $gia_chuaduyet = 0;
                                            $sql_chuaduyet = "SELECT DISTINCT booking.chitiet_tour_id,chitiet_tour.chitiet_ten FROM
                                        (booking 
                                         INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                         WHERE booking.tour_id='$tour_id' && booking.booking_trangthai='0'";
                                            $result_chuaduyet = mysqli_query($conn, $sql_chuaduyet);
                                            if ($result_chuaduyet) {
                                                while ($chitiet = mysqli_fetch_assoc($result_chuaduyet)) {
                                                    $chitiet_tour_id = $chitiet['chitiet_tour_id'];
                                                    $chitiet_ten = $chitiet['chitiet_ten'];
                                                    $sql_thongke = "SELECT SUM(booking_sl_nguoilon) AS sum_nguoilon, SUM(booking_sl_treem) AS sum_treem, 
                                        SUM(booking_tonggia) as sum_tongiga FROM booking WHERE tour_id='$tour_id' && chitiet_tour_id='$chitiet_tour_id' && booking.booking_trangthai='0'";
                                                    $result_thongke = mysqli_query($conn, $sql_thongke);
                                                    if ($result_thongke) {
                                                        while ($thongke = mysqli_fetch_assoc($result_thongke)) {
                                                            $sum_nguoilon = $thongke['sum_nguoilon'];
                                                            $sum_treem = $thongke['sum_treem'];
                                                            $sum_tongia = $thongke['sum_tongiga'];
                                                            $nguoilon_chuaduyet = $nguoilon_chuaduyet + $sum_nguoilon;
                                                            $treem_chuaduyet = $treem_chuaduyet + $sum_treem;
                                                            $gia_chuaduyet = $gia_chuaduyet + $sum_tongia;
                                                        }
                                                    }
                                            ?>
                                                    <tr>
                                                        <td style="width:2%"><?php echo $n++ ?></td>
                                                        <td><?php echo $chitiet_ten ?></td>
                                                        <td><?php echo $sum_nguoilon ?></td>
                                                        <td><?php echo $sum_treem ?></td>
                                                        <td><?php echo number_format($sum_tongia) ?></td>
                                                    </tr>
                                                <?php

                                                }
                                                ?>
                                                <tr>
                                                    <th>Tổng cộng</th>
                                                    <th></th>
                                                    <th><?php echo $nguoilon_chuaduyet ?></th>
                                                    <th><?php echo $treem_chuaduyet ?></th>
                                                    <th><?php echo number_format($gia_chuaduyet) ?></th>

                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                </div>

                                <div class="col-md-6">
                                    <h5 style="text-align: center;">Đơn đã xác nhận</h5>
                                    <table class="table" style="border: 1px solid black;" id="daduyet">
                                        <thead>
                                            <tr class="table-success">
                                                <th>#</th>
                                                <th>Dịch Vụ</th>
                                                <th>Tổng người lớn</th>
                                                <th>Tổng trẻ em</th>
                                                <th>Tổng giá</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $n = 1;
                                            $nguoilon_daduyet = 0;
                                            $treem_daduyet = 0;
                                            $gia_daduyet = 0;
                                            $sql_chuaduyet = "SELECT DISTINCT booking.chitiet_tour_id,chitiet_tour.chitiet_ten FROM
                                        (booking 
                                         INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                         WHERE booking.tour_id='$tour_id' && booking.booking_trangthai='1'";
                                            $result_chuaduyet = mysqli_query($conn, $sql_chuaduyet);
                                            if ($result_chuaduyet) {
                                                while ($chitiet = mysqli_fetch_assoc($result_chuaduyet)) {
                                                    $chitiet_tour_id = $chitiet['chitiet_tour_id'];
                                                    $chitiet_ten = $chitiet['chitiet_ten'];
                                                    $sql_thongke = "SELECT SUM(booking_sl_nguoilon) AS sum_nguoilon, SUM(booking_sl_treem) AS sum_treem, 
                                        SUM(booking_tonggia) as sum_tongia FROM booking WHERE tour_id='$tour_id' && chitiet_tour_id='$chitiet_tour_id' && booking.booking_trangthai='1'";
                                                    $result_thongke = mysqli_query($conn, $sql_thongke);
                                                    if ($result_thongke) {
                                                        while ($thongke = mysqli_fetch_assoc($result_thongke)) {
                                                            $sum_nguoilon = $thongke['sum_nguoilon'];
                                                            $sum_treem = $thongke['sum_treem'];
                                                            $sum_tongia = $thongke['sum_tongia'];
                                                            $nguoilon_daduyet = $nguoilon_daduyet + $sum_nguoilon;
                                                            $treem_daduyet = $treem_daduyet + $sum_treem;
                                                            $gia_daduyet = $gia_daduyet + $sum_tongia;
                                                        }
                                                    }
                                            ?>
                                                    <tr>
                                                        <td style="width:2%"><?php echo $n++ ?></td>
                                                        <td style="width:40%"><?php echo $chitiet_ten ?></td>
                                                        <td><?php echo $sum_nguoilon ?></td>
                                                        <td><?php echo $sum_treem ?></td>
                                                        <td><?php echo number_format($sum_tongia) ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <tr>
                                                    <th>Tổng cộng</th>
                                                    <th></th>
                                                    <th><?php echo $nguoilon_daduyet ?></th>
                                                    <th><?php echo $treem_daduyet ?></th>
                                                    <th><?php echo number_format($gia_daduyet) ?></th>

                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row" style="margin: 0;">
                                <div class="col-md-6">
                                    <h5 style="text-align: center;">Đơn khách hàng hủy</h5>
                                    <table class="table" style="border: 1px solid black;" id="khhuy">
                                        <thead>
                                            <tr class="table-danger">
                                                <th>#</th>
                                                <th>Dịch Vụ</th>
                                                <th>Tổng người lớn</th>
                                                <th>Tổng trẻ em</th>
                                                <th>Tổng giá</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $n = 1;
                                            $nguoilon_chuaduyet = 0;
                                            $treem_chuaduyet = 0;
                                            $gia_chuaduyet = 0;
                                            $sql_chuaduyet = "SELECT DISTINCT booking.chitiet_tour_id,chitiet_tour.chitiet_ten FROM
                                        (booking 
                                         INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                         WHERE booking.tour_id='$tour_id' && booking.booking_trangthai='3'";
                                            $result_chuaduyet = mysqli_query($conn, $sql_chuaduyet);
                                            if ($result_chuaduyet) {
                                                while ($chitiet = mysqli_fetch_assoc($result_chuaduyet)) {
                                                    $chitiet_tour_id = $chitiet['chitiet_tour_id'];
                                                    $chitiet_ten = $chitiet['chitiet_ten'];
                                                    $sql_thongke = "SELECT SUM(booking_sl_nguoilon) AS sum_nguoilon, SUM(booking_sl_treem) AS sum_treem, 
                                        SUM(booking_tonggia) as sum_tongiga FROM booking WHERE tour_id='$tour_id' && chitiet_tour_id='$chitiet_tour_id' && booking.booking_trangthai='3'";
                                                    $result_thongke = mysqli_query($conn, $sql_thongke);
                                                    if ($result_thongke) {
                                                        while ($thongke = mysqli_fetch_assoc($result_thongke)) {
                                                            $sum_nguoilon = $thongke['sum_nguoilon'];
                                                            $sum_treem = $thongke['sum_treem'];
                                                            $sum_tongia = $thongke['sum_tongiga'];
                                                            $nguoilon_chuaduyet = $nguoilon_chuaduyet + $sum_nguoilon;
                                                            $treem_chuaduyet = $treem_chuaduyet + $sum_treem;
                                                            $gia_chuaduyet = $gia_chuaduyet + $sum_tongia;
                                                        }
                                                    }
                                            ?>
                                                    <tr>
                                                        <td style="width:2%"><?php echo $n++ ?></td>
                                                        <td style="width:40%"><?php echo $chitiet_ten ?></td>
                                                        <td><?php echo $sum_nguoilon ?></td>
                                                        <td><?php echo $sum_treem ?></td>
                                                        <td><?php echo number_format($sum_tongia) ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <tr>
                                                    <th>Tổng cộng</th>
                                                    <th></th>
                                                    <th><?php echo $nguoilon_chuaduyet ?></th>
                                                    <th><?php echo $treem_chuaduyet ?></th>
                                                    <th><?php echo number_format($gia_chuaduyet) ?></th>

                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <h5 style="text-align: center;">Đơn từ chối</h5>
                                    <table class="table" style="border: 1px solid black;" id="tuchoi">
                                        <thead>
                                            <tr class="table-warning">
                                                <th>#</th>
                                                <th>Dịch Vụ</th>
                                                <th>Tổng người lớn</th>
                                                <th>Tổng trẻ em</th>
                                                <th>Tổng giá</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $n = 1;
                                            $nguoilon_chuaduyet = 0;
                                            $treem_chuaduyet = 0;
                                            $gia_chuaduyet = 0;
                                            $sql_chuaduyet = "SELECT DISTINCT booking.chitiet_tour_id,chitiet_tour.chitiet_ten FROM
                                        (booking 
                                         INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                         WHERE booking.tour_id='$tour_id' && booking.booking_trangthai='2'";
                                            $result_chuaduyet = mysqli_query($conn, $sql_chuaduyet);
                                            if ($result_chuaduyet) {
                                                while ($chitiet = mysqli_fetch_assoc($result_chuaduyet)) {
                                                    $chitiet_tour_id = $chitiet['chitiet_tour_id'];
                                                    $chitiet_ten = $chitiet['chitiet_ten'];
                                                    $sql_thongke = "SELECT SUM(booking_sl_nguoilon) AS sum_nguoilon, SUM(booking_sl_treem) AS sum_treem, 
                                        SUM(booking_tonggia) as sum_tongiga FROM booking WHERE tour_id='$tour_id' && chitiet_tour_id='$chitiet_tour_id' && booking.booking_trangthai='2'";
                                                    $result_thongke = mysqli_query($conn, $sql_thongke);
                                                    if ($result_thongke) {
                                                        while ($thongke = mysqli_fetch_assoc($result_thongke)) {
                                                            $sum_nguoilon = $thongke['sum_nguoilon'];
                                                            $sum_treem = $thongke['sum_treem'];
                                                            $sum_tongia = $thongke['sum_tongiga'];
                                                            $nguoilon_chuaduyet = $nguoilon_chuaduyet + $sum_nguoilon;
                                                            $treem_chuaduyet = $treem_chuaduyet + $sum_treem;
                                                            $gia_chuaduyet = $gia_chuaduyet + $sum_tongia;
                                                        }
                                                    }
                                            ?>
                                                    <tr>
                                                        <td style="width:2%"><?php echo $n++ ?></td>
                                                        <td style="width:40%"><?php echo $chitiet_ten ?></td>
                                                        <td><?php echo $sum_nguoilon ?></td>
                                                        <td><?php echo $sum_treem ?></td>
                                                        <td><?php echo number_format($sum_tongia) ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <tr>
                                                    <th>Tổng cộng</th>
                                                    <th></th>
                                                    <th><?php echo $nguoilon_chuaduyet ?></th>
                                                    <th><?php echo $treem_chuaduyet ?></th>
                                                    <th><?php echo number_format($gia_chuaduyet) ?></th>

                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- don hang da xuat -->
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 style="text-align: center;">Đơn hàng đã xuất</h5>
                                    <table class="table" style="border: 1px solid black;" id="daxuat">
                                        <thead>
                                            <tr class="table-secondary">
                                                <th>#</th>
                                                <th>Dịch Vụ</th>
                                                <th>Tổng người lớn</th>
                                                <th>Tổng trẻ em</th>
                                                <th>Tổng giá</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $n = 1;
                                            $nguoilon_daxuat = 0;
                                            $treem_daxuat = 0;
                                            $gia_daxuat = 0;
                                            $sql_daxuat = "SELECT DISTINCT booking.chitiet_tour_id,chitiet_tour.chitiet_ten FROM
                                        (booking 
                                         INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                         WHERE booking.tour_id='$tour_id' && booking.booking_trangthai='3'";
                                            $result_chuaduyet = mysqli_query($conn, $sql_chuaduyet);
                                            if ($result_chuaduyet) {
                                                while ($chitiet = mysqli_fetch_assoc($result_chuaduyet)) {
                                                    $chitiet_tour_id = $chitiet['chitiet_tour_id'];
                                                    $chitiet_ten = $chitiet['chitiet_ten'];
                                                    $sql_thongke = "SELECT SUM(booking_sl_nguoilon) AS sum_nguoilon, SUM(booking_sl_treem) AS sum_treem, 
                                        SUM(booking_tonggia) as sum_tongiga FROM booking WHERE tour_id='$tour_id' && chitiet_tour_id='$chitiet_tour_id' && booking.booking_trangthai='5'";
                                                    $result_thongke = mysqli_query($conn, $sql_thongke);
                                                    if ($result_thongke) {
                                                        while ($thongke = mysqli_fetch_assoc($result_thongke)) {
                                                            $sum_nguoilon = $thongke['sum_nguoilon'];
                                                            $sum_treem = $thongke['sum_treem'];
                                                            $sum_tongia = $thongke['sum_tongiga'];
                                                            $nguoilon_daxuat = $nguoilon_daxuat + $sum_nguoilon;
                                                            $treem_daxuat = $treem_daxuat + $sum_treem;
                                                            $gia_daxuat = $gia_daxuat + $sum_tongia;
                                                        }
                                                    }
                                            ?>
                                                    <tr>
                                                        <td style="width:2%"><?php echo $n++ ?></td>
                                                        <td style="width:40%"><?php echo $chitiet_ten ?></td>
                                                        <td><?php echo $sum_nguoilon ?></td>
                                                        <td><?php echo $sum_treem ?></td>
                                                        <td><?php echo number_format($sum_tongia) ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <tr>
                                                    <th>Tổng cộng</th>
                                                    <th></th>
                                                    <th><?php echo $nguoilon_daxuat ?></th>
                                                    <th><?php echo $treem_daxuat ?></th>
                                                    <th><?php echo number_format($gia_daxuat) ?></th>

                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end thong ke -->
                        </div>
                    </div>
                    <!-- <div class="col-md-1">

                        </div> -->
                </div>
            </div>
        </div>
        <!-- footer -->
        <?php
        include("../templates/footer.html")
        ?>
        <!-- end footer -->
    </div>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $('#dichvu').DataTable({
            "pageLength": 5,
            "lengthMenu": [5, 10, 20, 30, 50]

        });
        $('#chuaduyet').DataTable({
            "pageLength": 3,
            "lengthMenu": [3, 6, 9, 12, 15]

        });
        $('#daduyet').DataTable({
            "pageLength": 3,
            "lengthMenu": [3, 6, 9, 12, 15]

        });
        $('#khhuy').DataTable({
            "pageLength": 3,
            "lengthMenu": [3, 6, 9, 12, 15]

        });
        $('#tuchoi').DataTable({
            "pageLength": 3,
            "lengthMenu": [3, 6, 9, 12, 15]

        });
    </script>
</body>

</html>