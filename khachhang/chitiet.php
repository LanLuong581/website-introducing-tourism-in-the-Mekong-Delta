<?php
include('../config/constants.php');
ob_start();
session_start();
if (isset($_SESSION["acc_email"])) {
    $email_khachhang = $_SESSION["acc_email"];
    $sql_account = "SELECT `account_id`FROM `account` WHERE account_email='$email_khachhang'";
    $result_account = mysqli_query($conn, $sql_account);
    if (mysqli_num_rows($result_account) > 0) {
        while ($account = mysqli_fetch_assoc($result_account)) {
            $account_id = $account['account_id'];
        }
    }
}
$error_booking_ngaysudung = '';
$tour_id = $_GET['tour_id'];
// lay so luong comment
$sql_count_comment = "SELECT COUNT(binhluan_id) as num_comment FROM binhluan  WHERE tour_id='$tour_id'";
$result_count = mysqli_query($conn, $sql_count_comment);
if (mysqli_num_rows($result_count) > 0) {
    while ($number = mysqli_fetch_assoc($result_count)) {
        $count = $number['num_comment'];
    }
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
// end lay so luong comment
// lay so luong phan hoi
$sql_count_phanhoi = "SELECT COUNT(phanhoi_id) as num_phanhoi FROM phanhoi  WHERE tour_id='$tour_id'";
$result_phanhoi = mysqli_query($conn, $sql_count_phanhoi);
if (mysqli_num_rows($result_phanhoi) > 0) {
    while ($phanhoi = mysqli_fetch_assoc($result_phanhoi)) {
        $count_phanhoi = $phanhoi['num_phanhoi'];
    }
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
// end lay so luong phan hoi
$tongcomment = $count + $count_phanhoi;
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
    <script src="../js/bootstrap.js"></script>
    <script src="../jquery/jquery-3.6.0.min.js"></script>
    <script src="../js/check.js"></script>

    <title>ViVuMeKong</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@500&display=swap');
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
    <style>
        .user {
            font-weight: bold;
            color: black;
        }

        .time {
            color: gray;
        }

        .commentcontent {
            color: #000;
        }

        .replies .comment {
            margin-top: 20px;
        }

        .replies {
            margin-left: 20px;

        }

        .input_comment:focus {
            outline: none;
        }

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
    </style>
</head>

<body>
    <div class="wrapper" style="padding: 0;margin:0">
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
                                <a class="nav-link active" aria-current="page" href="index.php">Trang chủ</a>
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
                                <a class="nav-link" aria-current="page" href="qly_dadat.php">Quản Lý Đơn Hàng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="lichsu.php">Lịch Sử Đặt Hàng</a>
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
                                        <li data-bs-toggle="modal" data-bs-target="#info<?php echo $account_id ?>"><a class="dropdown-item bi bi-person"> Thông tin cá nhân</a></li>
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
                        <!-- modal thong tin cá nhân -->
                        <div class="modal fade" id="info<?php echo $account_id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog ">
                                <div class="modal-content bg-modal">
                                    <div class="modal-header" style="background: #2d7d90;color:#fff">
                                        <h5 class="modal-title" id="exampleModalLabel">Thông Tin Cá Nhân</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <?php

                                    $sql = "SELECT `khachhang_id`,`khachhang_ten`, `khachhang_ho`, `khachhang_ngaysinh`, `khachhang_dienthoai`, 
                                    `khachhang_diachi` ,province._name AS tinh_ten, district._name AS huyen_ten , ward._name AS xa_ten
                                    FROM (((`khachhang` 
                                          INNER JOIN province ON province.id=khachhang.tinh_id)
                                          INNER JOIN district ON district.id=khachhang.huyen_id)
                                          INNER JOIN ward ON ward.id=khachhang.xa_id)
                                      WHERE khachhang.account_id='$account_id'";
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $khachhang_id = $row['khachhang_id'];
                                            $khachhang_ten = $row['khachhang_ten'];
                                            $khachhang_ho = $row['khachhang_ho'];
                                            $khachhang_ngaysinh = $row['khachhang_ngaysinh'];
                                            $khachhang_dienthoai = $row['khachhang_dienthoai'];
                                            $khachhang_diachi = $row['khachhang_diachi'];
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
                                                            <span><?php echo $khachhang_ho ?> <?php echo $khachhang_ten ?> </span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <span style="font-weight: 500;">Ngày sinh:</span>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <span><?php echo $khachhang_ngaysinh ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <span style="font-weight: 500;">Số điện thoại:</span>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <span><?php echo $khachhang_dienthoai ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <span style="font-weight: 500;">Địa chỉ:</span>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <span><?php echo $khachhang_diachi ?>,<?php echo $xa_ten ?>,<?php echo $huyen_ten ?>,<?php echo $tinh_ten ?></span>
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
                        <!-- modal thong tin cá nhân -->
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
                                            $sql_khachhang = "SELECT `khachhang_id`,`khachhang_ten`, `khachhang_ho`, `khachhang_ngaysinh`, `khachhang_dienthoai`, 
                                            `khachhang_diachi` ,province._name AS tinh_ten, district._name AS huyen_ten , ward._name AS xa_ten
                                            FROM (((`khachhang` 
                                                  INNER JOIN province ON province.id=khachhang.tinh_id)
                                                  INNER JOIN district ON district.id=khachhang.huyen_id)
                                                  INNER JOIN ward ON ward.id=khachhang.xa_id)
                                              WHERE khachhang.account_id='$account_id'";
                                            $result_khachhang = mysqli_query($conn, $sql_khachhang);
                                            if (mysqli_num_rows($result_khachhang) > 0) {
                                                while ($kh_result = mysqli_fetch_assoc($result_khachhang)) {
                                                    $khachhang_id = $kh_result['khachhang_id'];
                                                    $khachhang_ten = $kh_result['khachhang_ten'];
                                                    $khachhang_ho = $kh_result['khachhang_ho'];
                                                    $khachhang_ngaysinh = $kh_result['khachhang_ngaysinh'];
                                                    $khachhang_dienthoai = $kh_result['khachhang_dienthoai'];
                                                    $khachhang_diachi = $kh_result['khachhang_diachi'];
                                                    $tinh_ten = $kh_result['tinh_ten'];
                                                    $huyen_ten = $kh_result['huyen_ten'];
                                                    $xa_ten = $kh_result['xa_ten'];
                                                }

                                            ?>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="hidden" name="update_khachhang_id" value="<?php echo $khachhang_id ?>">
                                                            <label for="" class="form-label" style="font-weight: 500;">Họ</label>
                                                            <input type="text" class="form-control" id="update_khachhang_ho" name="update_khachhang_ho" value="<?php echo $khachhang_ho ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="" class="form-label" style="font-weight: 500;">Tên</label>
                                                            <input type="text" class="form-control" name="update_khachhang_ten" id="update_khachhang_ten" value="<?php echo $khachhang_ten ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="" class="form-label" style="font-weight: 500;">Số điện thoại</label>
                                                            <input type="text" class="form-control" name="update_khachhang_dienthoai" id="update_khachhang_dienthoai" value="<?php echo $khachhang_dienthoai ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="" class="form-label" style="font-weight: 500;">Ngày sinh</label>
                                                            <input type="date" class="form-control" id="update_khachhang_ngaysinh" name="update_khachhang_ngaysinh" value="<?php echo $khachhang_ngaysinh ?>">
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
                                                                <input type="text" class="form-control" id="update_khachhang_diachi" name="update_khachhang_diachi" value="<?php echo $khachhang_diachi ?>">
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
                        <!-- modal cap nhat thong tin ca nhan -->
                    </div>
                </div>
            </nav>
        </div>
        <div class="main-content" style="padding-top: 0px;">
            <div class="row" style="margin: 0;">
                <div class="col-md-1">
                </div>
                <div class="col-md-10">
                    <div class="gioithieu-noidung" style="margin-left: 0px;margin-right:0px;">
                        <?php
                        $tour_id = $_GET['tour_id'];
                        $sql_gioithieu = "select tour_gioithieu from tour where tour_id='$tour_id'";
                        $result_gioithieu = mysqli_query($conn, $sql_gioithieu);
                        if (mysqli_num_rows($result_gioithieu) > 0) {
                            while ($gioithieu = mysqli_fetch_assoc($result_gioithieu)) {
                                $tour_gioithieu = $gioithieu['tour_gioithieu'];
                            }
                            if ($tour_gioithieu == NULL) {
                                echo "Doanh nghiệp chưa cập nhật giới thiệu";
                            } else {
                        ?>
                                <style>
                                    .noidung>.chitiet {
                                        height: 450px;
                                        overflow: hidden
                                    }

                                    .showcontent>.chitiet {
                                        height: auto;
                                    }
                                </style>
                                <div class="noidung">
                                    <div class="chitiet">
                                        <p><?php echo $tour_gioithieu ?></p>
                                    </div>
                                    <a href="javascript:void(0);" class="btn button_submit readmore-btn" style="text-decoration: none;">Đọc Tiếp</a>
                                </div>

                        <?php
                            }
                        }

                        ?>
                    </div>
                    <div class="dich-vu" style="margin-top:30px;background:#fff">
                        <h4 style="margin-left: 20px;">Danh sách dịch vụ</h4>
                        <?php
                        $tour_id = $_GET['tour_id'];
                        $sql_chitiet_tour = "SELECT * FROM `chitiet_tour` WHERE `tour_id`='$tour_id' && NOT chitiet_trangthai='0'";
                        $result_chitiet = mysqli_query($conn, $sql_chitiet_tour);
                        function currency_format($number, $suffix = ' vnđ')
                        {
                            if (!empty($number)) {
                                return number_format($number, 0, ',', '.') . "{$suffix}";
                            }
                        }
                        if (mysqli_num_rows($result_chitiet) > 0) {
                            while ($chitiet = mysqli_fetch_assoc($result_chitiet)) {
                                $chitiet_tour_id = $chitiet['chitiet_tour_id'];
                                $chitiet_ten = $chitiet['chitiet_ten'];
                                $chitiet_gia_nguoilon = currency_format($chitiet['chitiet_gia_nguoilon']);
                                $chitiet_gia_treem = currency_format($chitiet['chitiet_gia_treem']);
                                $chitiet_avt = $chitiet['chitiet_avt'];
                                $chitiet_gioithieu = $chitiet['chitiet_gioithieu'];
                                $chitiet_trangthai = $chitiet['chitiet_trangthai'];
                        ?>
                                <div class="row content" style="margin-left: 20px;margin-right: 20px;background: #eef4ed;padding:10px">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3 avt">
                                                <!-- hinh dai dien -->
                                                <img src="../image/<?= $chitiet_avt; ?>" alt="<?= $chitiet_avt; ?>" srcset="" width="280px" height="200px" style="border-radius:1px ;">
                                            </div>
                                            <div class="col-md-7" style="padding: 0px 20px;">

                                                <div class="row">
                                                    <!-- ten dich vu -->
                                                    <?php
                                                    if ($chitiet_trangthai == 0) {
                                                    ?>
                                                        <span style="font-size:20px"> <b><?php echo $chitiet_ten ?></b> </span><span style="color:red">(Tạm đóng)</span>

                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span style="font-size:20px"> <b><?php echo $chitiet_ten ?></b> </span>


                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="row">
                                                    <!-- gioi thieu -->
                                                    <span><?php echo $chitiet_gioithieu ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <!-- gia -->
                                                <div class="row">
                                                    <br>
                                                </div>
                                                <div class="row">
                                                    <span style="font-size: 30px;color:green;margin-top:15%"><?php echo $chitiet_gia_nguoilon ?></span>
                                                </div>
                                                <div class="row">
                                                    <?php
                                                    if ($chitiet_trangthai == 0) {
                                                    ?>
                                                        <button style="width:77px;padding:0px 6px ;height:36px;margin-left:50px" type="button" class="btn button_submit" id="dat_mua" name="dat_mua" data-bs-toggle="modal" data-bs-target="#booking<?php echo $chitiet_tour_id;
                                                                                                                                                                                                                                                    echo $tour_id ?>" title="Đặt mua" disabled>Đặt vé</button>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <button style="width:77px;padding:0px 6px ;height:36px;margin-left:50px" type="button" class="btn button_submit" id="dat_mua" name="dat_mua" data-bs-toggle="modal" data-bs-target="#booking<?php echo $chitiet_tour_id;
                                                                                                                                                                                                                                                    echo $tour_id ?>" title="Đặt mua">Đặt vé</button>
                                                    <?php
                                                    }
                                                    ?>


                                                </div>
                                                <!-- Modal booking -->
                                                <div class="modal fade" id="booking<?php echo $chitiet_tour_id;
                                                                                    echo $tour_id ?>" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content bg-modal">
                                                            <form class="main-form" action="" method="POST" enctype="multipart/form-data">
                                                                <div class="modal-header" style="background: #2d7d90;color:#fff">
                                                                    <h5 class="modal-title" id="staticBackdropLabel" style="font-size:30px">Chi tiết đơn hàng</h5>

                                                                </div>
                                                                <?php
                                                                $sql_booking_info = "SELECT chitiet_tour.chitiet_ten,tour.tour_ten,chitiet_tour.chitiet_gia_nguoilon,chitiet_tour.chitiet_gia_treem
                                                                FROM ( chitiet_tour
                                                                      INNER JOIN tour on tour.tour_id=chitiet_tour.tour_id)
                                                                      WHERE chitiet_tour.chitiet_tour_id='$chitiet_tour_id'";
                                                                $result_booking_info = mysqli_query($conn, $sql_booking_info);
                                                                if (mysqli_num_rows($result_booking_info) > 0) {
                                                                    while ($booking = mysqli_fetch_assoc($result_booking_info)) {
                                                                        $chitiet_ten = $booking['chitiet_ten'];
                                                                        $tour_ten = $booking['tour_ten'];
                                                                        $gia_nguoilon = $booking['chitiet_gia_nguoilon'];
                                                                        $gia_treem = $booking['chitiet_gia_treem'];

                                                                ?>
                                                                        <div class="modal-body" onload="tong()">
                                                                            <div class="col-md-12">
                                                                                <div col-md-12>
                                                                                    <!-- <form action="" name="booking_info" method="POST"> -->
                                                                                    <div class="form-group">
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <input type="hidden" value="<?php echo $chitiet_tour_id ?>" name="chitiet_tour_id" />
                                                                                                <input type="hidden" value="<?php echo $tour_id ?>" name="tour_id" />
                                                                                                <input type="hidden" value="<?php echo $gia_nguoilon ?>" name="gia_nguoilon" id="gia_nguoilon" class="gia_nguoilon_class" />
                                                                                                <input type="hidden" value="<?php echo $gia_treem ?>" name="gia_treem" id="gia_treem" class="gia_treem_class" />
                                                                                                <input type="hidden" value="<?php echo date("Y-m-d") ?>" name="booking_ngaybook" id="booking_ngaybook" class="ngaybook" />
                                                                                                <label for="tour_ten" style="font-size: 20px;font-weight:600;text-transform:capitalize;"><?php echo $tour_ten ?></label>
                                                                                                <br>
                                                                                                <label for="chitiet_ten" style="font-size: 18px;"><?php echo $chitiet_ten ?></label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-4" style="width:134px">
                                                                                                <label for="booking_date">Ngày sử dụng: </label>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <input type="date" class="form-control ngaysudung" id="booking_ngaysudung" name="booking_ngaysudung" required>
                                                                                            </div>
                                                                                            <div class="col-md-4">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-5" style="padding-right: 0px;">
                                                                                                <label for="nguoilon">Người lớn (cao từ 140cm)</label>
                                                                                            </div>
                                                                                            <div class="col-md-3" style="padding-right: 0px;">
                                                                                                <label for="chitiet_gia_nguoilon"><?php echo $chitiet_gia_nguoilon ?></label>
                                                                                                <!-- <input type="hidden" value="<?php echo $chitiet_gia ?>" name="chitiet_gia" id="chitiet_gia" /> -->
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <div class="input-group">
                                                                                                    <input type="number" class="form-control sl_nguoilon" id="booking_sl_nguoilon" name="booking_sl_nguoilon" onchange="total();dis_giohang()" min="0" value="0">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <br>
                                                                                        <div class="row">
                                                                                            <div class="col-md-5" style="padding-right: 0px;">
                                                                                                <label for="booking_sl_treem">Trẻ em (cao dưới 140cm)</label>
                                                                                            </div>
                                                                                            <div class="col-md-3" style="padding-right: 0px;">
                                                                                                <label for="chitiet_gia_treem"><?php echo $chitiet_gia_treem ?></label>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <div class="input-group">

                                                                                                    <input type="number" class="form-control sl_treem" id="booking_sl_treem" name="booking_sl_treem" onchange="total();dis_giohang();" min="0" value="0" class="sl_treem">

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <hr>
                                                                                        <div class="row">
                                                                                            <div class="col-md-5">
                                                                                                <label for="booking_tonggia">Tổng cộng: </label>
                                                                                            </div>
                                                                                            <div class="col-md-7">
                                                                                                <input class="form-control tong_gia" type="text" id="booking_tonggia" name="booking_tonggia" value="0" style="font-size: 20px;">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- </form> -->

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" onClick="window.location.reload();" class="btn button_close" data-bs-dismiss="modal" style="width:66px">Đóng</button>
                                                                            <input type="submit" id="add_to_card" name="add_to_card" class="btn button_submit giohang" value="Giỏ hàng" disabled>
                                                                            <!-- <input type="submit" id="book_now" name="book_now" class="btn btn-primary muangay" value="Đặt ngay" disabled> -->
                                                                        </div>


                                                                <?php

                                                                    }
                                                                }
                                                                ?>

                                                            </form>
                                                        </div>

                                                    </div>

                                                </div>
                                                <!-- end modal booking -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>

                        <?php
                            }
                        }
                        ?>
                    </div>

                    <div class="comment_fuction" style="margin-top: 50px;margin-bottom:50px;padding-bottom:50px;background-color:#fff">
                        <div class="row" style="margin-left: 0px;margin-right:0px">
                            <div class="col-md-12" style="padding-top:12px">
                                <h6><?php echo $tongcomment ?> Bình luận</h6>
                                <div class="addcomment">
                                    <div class="row">
                                        <div class="col-md-12" style="padding: 0;">
                                            <div class="writecomment">
                                                <?php
                                                if (isset($_SESSION["acc_email"])) {
                                                ?>
                                                    <form action="" method="post">
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <input class="input_comment" placeholder="Thêm bình luận cho dịch vụ này tại đây" style="width:1038px;margin-left:20px;border:0;border-bottom:1px solid gray" name="add_comment" id="add_comment" rows="2" required></input><br>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button class="btn button_submit" style="float: right;width:92px;margin-right:20px" title="Thêm bình luận" id="submit_commit" name="submit_commit">Bình luận</button>

                                                            </div>
                                                        </div>

                                                    </form>

                                                <?php
                                                } else {
                                                ?>
                                                    <form action="" method="post">
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <input class="input_comment" placeholder="Vui lòng đăng nhập để bình luận" style="width:1038px;margin-left:20px;border:0;border-bottom:1px solid gray" name="add_comment" id="add_comment" rows="2" disabled></input><br>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button class="btn button_submit" style="float: right;width:92px;margin-right:20px" title="Thêm bình luận" id="submit_commit" name="submit_commit" disabled>Bình luận</button>

                                                            </div>
                                                        </div>

                                                    </form>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="seecomments">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php
                                            $sql_all_comment = "SELECT account.account_email,khachhang.khachhang_ten,binhluan.binhluan_noidung,binhluan.binhluan_ngay,binhluan.binhluan_id,binhluan.tour_id
                                                FROM ((binhluan
                                                      INNER JOIN khachhang ON khachhang.khachhang_id=binhluan.khachhang_id)
                                                      INNER JOIN account ON account.account_id=khachhang.account_id)
                                                      WHERE binhluan.tour_id='$tour_id' ORDER BY binhluan_id DESC;";
                                            $result_all_comment = mysqli_query($conn, $sql_all_comment);
                                            if (mysqli_num_rows($result_all_comment) > 0) {
                                                while ($comment_content = mysqli_fetch_assoc($result_all_comment)) {
                                                    $account_email = $comment_content['account_email'];
                                                    $khachhang_ten = $comment_content['khachhang_ten'];
                                                    $noidung = $comment_content['binhluan_noidung'];
                                                    $ngay = $comment_content['binhluan_ngay'];
                                                    $binhluan_id = $comment_content['binhluan_id'];
                                                    $tour_id = $comment_content['tour_id'];

                                            ?>
                                                    <div class="usercomment">
                                                        <div class="comment">
                                                            <div class="user">
                                                                <?php echo $khachhang_ten ?>
                                                                <span class="time">
                                                                    <?php echo date('H:i:s d/m/Y ', strtotime($ngay)) ?>
                                                                </span>
                                                            </div>
                                                            <div class="commentcontent">
                                                                <?php echo $noidung ?>
                                                            </div>

                                                            <div class="reply">
                                                                <?php
                                                                // lay so luong phan hoi
                                                                $sql_count_phanhoi = "SELECT COUNT(phanhoi_id) as num_phanhoi FROM phanhoi  WHERE tour_id='$tour_id' and binhluan_id='$binhluan_id'";
                                                                $result_phanhoi = mysqli_query($conn, $sql_count_phanhoi);
                                                                if (mysqli_num_rows($result_phanhoi) > 0) {
                                                                    while ($sl_phanhoi = mysqli_fetch_assoc($result_phanhoi)) {
                                                                        $sl_phanhoi_bl = $sl_phanhoi['num_phanhoi'];
                                                                    }
                                                                } else {
                                                                    echo "Error deleting record: " . mysqli_error($conn);
                                                                }
                                                                // end lay so luong phan hoi
                                                                if (isset($_SESSION["acc_email"])) {
                                                                ?>
                                                                    <a href="javascript:void(0);" data-binhluanid="<?php echo $binhluan_id ?>" data-tourid="<?php echo $tour_id ?>" onclick="reply(this)" style="text-decoration: none;color:gray">Trả lời</a>

                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <a href="javascript:void(0);" style="text-decoration: none;color:gray">Trả lời</a>

                                                                <?php
                                                                }

                                                                ?>
                                                                <!-- hien thi cac phan hoi cho binh luan nay -->
                                                                <?php
                                                                if ($sl_phanhoi_bl > 0) {
                                                                ?>
                                                                    <span style="text-decoration: none;color:#15616d;font-weight:500"><?php echo $sl_phanhoi_bl ?> phản hồi</span>

                                                                    <?php
                                                                    $sql_phanhoi = "SELECT account.account_email,khachhang.khachhang_ten,phanhoi.phanhoi_nd,phanhoi.phanhoi_ngay
                                                                        FROM((phanhoi
                                                                             INNER JOIN khachhang ON khachhang.khachhang_id=phanhoi.khachhang_id)
                                                                             INNER JOIN account on account.account_id=khachhang.account_id)
                                                                             WHERE phanhoi.binhluan_id='$binhluan_id' ORDER BY phanhoi_id DESC";
                                                                    $result_phanhoi = mysqli_query($conn, $sql_phanhoi);
                                                                    if (mysqli_num_rows($result_phanhoi) > 0) {
                                                                        while ($phanhoi = mysqli_fetch_assoc($result_phanhoi)) {
                                                                            $account_email = $phanhoi['account_email'];
                                                                            $phanhoi_nd = $phanhoi['phanhoi_nd'];
                                                                            $phanhoi_ngay = $phanhoi['phanhoi_ngay'];
                                                                            $khachhang_ten = $phanhoi['khachhang_ten'];

                                                                    ?>

                                                                            <div class="usercomment" style="margin-left: 30px;">
                                                                                <div class="comment">
                                                                                    <div class="user">
                                                                                        <?php echo $khachhang_ten ?>
                                                                                        <span class="time">
                                                                                            <?php echo date('H:i:s d/m/Y ', strtotime($phanhoi_ngay)) ?>
                                                                                        </span>
                                                                                    </div>
                                                                                    <div class="commentcontent">
                                                                                        <?php echo $phanhoi_nd ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </div>


                                                        </div>
                                                    </div>

                                            <?php
                                                }
                                            }

                                            ?>
                                            <!--  -->
                                            <div class="replies">
                                                <div class="row replyrow" style="display:none">
                                                    <div class="col-md-12">
                                                        <form action="" method="post">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <input type="hidden" id="binhluan_id" name="binhluan_id">
                                                                    <input class="input_comment" placeholder="Thêm bình luận cho dịch vụ này tại đây" style="width:1004px;margin-left:40px;border:0;border-bottom:1px solid gray" name="replycomment" id="replycomment" rows="2" required></input><br>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button class="btn button_submit" style="float: right;width:69px;margin-right:20px" title="Trả lời" id="submit_reply" name="submit_reply">Trả lời</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="row display_replis">

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
            <div class="col-md-1">
            </div>
        </div>

    </div>
    <div class="lien_he" style="background:#75b9be;padding-bottom:50px;color:#fff">
        <!-- <h4>Thông tin liên hệ</h4> -->
        <?php
        $sql_tour_info = "SELECT tour.tour_ten,tour.tour_dienthoai,tour.tour_diachi,province._name AS tinh_ten, district._name AS huyen_ten,ward._name AS xa_ten,account_email
                            FROM ((((account 
                                  INNER JOIN tour ON tour.account_id=account.account_id)
                                    INNER JOIN province ON province.id=tour.tinh_id)
                                   INNER JOIN district ON district.id=tour.huyen_id)
                                  INNER JOIN ward ON ward.id=tour.xa_id)
                                  WHERE tour.tour_id='$tour_id' ";
        $result_tour_info = mysqli_query($conn, $sql_tour_info);
        if (mysqli_num_rows($result_tour_info) > 0) {
            while ($row_tour_info = mysqli_fetch_assoc($result_tour_info)) {
                $tour_ten = $row_tour_info['tour_ten'];
                $tour_dienthoai = $row_tour_info['tour_dienthoai'];
                $tour_diachi = $row_tour_info['tour_diachi'];
                $tinh_ten = $row_tour_info['tinh_ten'];
                $huyen_ten = $row_tour_info['huyen_ten'];
                $xa_ten = $row_tour_info['xa_ten'];
                $account_email = $row_tour_info['account_email'];
            }
        ?>
            <div class="row" style="margin: 0;">
                <div class="col-md-2">

                </div>
                <div class="col-md-8" style="text-align: center;">
                    <span style="font-weight: 500;font-size:25px"><?php echo $tour_ten ?></span> <br>
                    <span style="font-weight: 500;">Số điện thoại:</span> <span><?php echo $tour_dienthoai ?></span> <br>
                    <span style="font-weight: 500;">Email: </span> <span><?php echo $account_email ?></span> <br>
                    <span style="font-weight: 500;">Địa chỉ: </span><span><?php echo $tour_diachi ?>, <?php echo $xa_ten ?>, <?php echo $huyen_ten ?>, <?php echo $tinh_ten ?></span> <br>
                </div>
                <div class="col-md-2">

                </div>
            </div>
        <?php
        }
        ?>

    </div>
    <?php
    include("../templates/footer.html")
    ?>
    </div>
    <!-- tính giá theo số lượng -->
    <script>
        var nguoilon = document.getElementsByClassName('sl_nguoilon');
        var treem = document.getElementsByClassName('sl_treem');
        var tong_gia = document.getElementsByClassName('tong_gia');
        var gia_nguoilon = document.getElementsByClassName('gia_nguoilon_class');
        var gia_treem = document.getElementsByClassName('gia_treem_class');
        const formatter = new Intl.NumberFormat('en');

        function total() {
            for (i = 0; i < nguoilon.length; i++) {
                tong_gia[i].value = formatter.format(((nguoilon[i].value) * (gia_nguoilon[i].value)) + ((treem[i].value) * (gia_treem[i].value)));
                // tong_gia[i].value = ((nguoilon[i].value) * (gia_nguoilon[i].value)) + ((treem[i].value) * (gia_treem[i].value));


            }
        }
        total();
    </script>
    <!-- end tính giá theo số lượng -->

    <!-- gioi han ngay duoc book -->
    <script>
        var date = new Date();
        var tdate = date.getDate();
        var month = date.getMonth() + 1;
        if (tdate < 10) {
            tdate = '0' + tdate;
        }
        if (month < 10) {
            month = '0' + month;
        }
        var year = date.getUTCFullYear();
        var mindate = year + "-" + month + "-" + tdate;
        const ngaysudung = document.getElementsByClassName("ngaysudung");
        for (i = 0; i < ngaysudung.length; i++) {
            ngaysudung[i].setAttribute('min', mindate);
        }
    </script>
    <!-- end gioi han ngay duoc book -->
    <!-- disable nut mua hang -->
    <script>
        var nguoilon = document.getElementsByClassName('sl_nguoilon');
        var treem = document.getElementsByClassName('sl_treem');
        const giohang = document.getElementsByClassName("giohang");
        const muangay = document.getElementsByClassName("muangay");

        function dis_giohang() {
            for (i = 0; i < nguoilon.length; i++) {
                if (nguoilon[i].value > 0 || treem[i].value > 0) {
                    giohang[i].disabled = this.checked;
                } else {
                    giohang[i].disabled = !this.checked;
                }
            }
        }
    </script>
    <!-- disable nut mua hang -->

    <!-- readmore-btn -->
    <script>
        $(".readmore-btn").on('click', function() {
            $(this).parent().toggleClass("showcontent");
            if ($(this).parent().hasClass("showcontent")) {
                $(this).text("Thu gọn");
            } else {
                $(this).text("Đọc tiếp");
            }
        });
    </script>
    <!-- end readmore-btn -->
    <!-- reply button -->
    <script>
        function reply(caller) {
            var binhluan_id = $(caller).attr('data-binhluanid');
            var tour_id = $(caller).attr('data-tourid');
            var x = document.getElementById('binhluan_id');
            x.value = binhluan_id;
            $(".replyrow").insertAfter($(caller));
            $(".replyrow").show();
        }
    </script>
    <!-- end reply buttong -->

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
<?php
// them vao gio hang bang cookie
$connect = new PDO("mysql:host=localhost;dbname=dulichdbscl", "root", "");
if (isset($_POST["add_to_card"])) {
    if (isset($_COOKIE["gio_hang"])) {
        $cookie_data = stripcslashes($_COOKIE["gio_hang"]);
        $cart_data = json_decode($cookie_data, true);
    } else {
        $cart_data = array();
    }
    $chitiet_tour_id_list = array_column($cart_data, 'chitiet_tour_id');
    $booking_ngaysudung_list = array_column($cart_data, 'booking_ngaysudung');
    $x = 0;
    if (in_array($_POST["chitiet_tour_id"], $chitiet_tour_id_list)) {
        foreach ($cart_data as $keys => $values) {
            if (($cart_data[$keys]["chitiet_tour_id"] == $_POST["chitiet_tour_id"]) && ($cart_data[$keys]["booking_ngaysudung"] == $_POST["booking_ngaysudung"])) {
                $cart_data[$keys]["booking_sl_nguoilon"] = $cart_data[$keys]["booking_sl_nguoilon"] + $_POST["booking_sl_nguoilon"];
                $cart_data[$keys]["booking_sl_treem"] = $cart_data[$keys]["booking_sl_treem"] + $_POST["booking_sl_treem"];
                // $cart_data[$keys]["booking_tonggia"]=($cart_data[$keys]["booking_sl_nguoilon"]*$_POST["gia_nguoilon"])+($cart_data[$keys]["booking_sl_treem"]*$_POST["gia_treem"]);
                $x = 1;
            }
        }
        if ($x == 0) {
            $item_array = array(
                'tour_id' => $_POST["tour_id"],
                'chitiet_tour_id' => $_POST["chitiet_tour_id"],
                'booking_ngaybook' => $_POST["booking_ngaybook"],
                'booking_ngaysudung' => $_POST["booking_ngaysudung"],
                'gia_nguoilon' => $_POST["gia_nguoilon"],
                'gia_treem' => $_POST["gia_treem"],
                'booking_sl_nguoilon' => $_POST["booking_sl_nguoilon"],
                'booking_sl_treem' => $_POST["booking_sl_treem"],
                'booking_tonggia' => $_POST["booking_tonggia"]

            );
            $cart_data[] = $item_array;
        }
    } else {

        $item_array = array(
            'tour_id' => $_POST["tour_id"],
            'chitiet_tour_id' => $_POST["chitiet_tour_id"],
            'booking_ngaybook' => $_POST["booking_ngaybook"],
            'booking_ngaysudung' => $_POST["booking_ngaysudung"],
            'gia_nguoilon' => $_POST["gia_nguoilon"],
            'gia_treem' => $_POST["gia_treem"],
            'booking_sl_nguoilon' => $_POST["booking_sl_nguoilon"],
            'booking_sl_treem' => $_POST["booking_sl_treem"],
            'booking_tonggia' => $_POST["booking_tonggia"]
        );
        $cart_data[] = $item_array;
    }
    $item_data = json_encode($cart_data);
    echo ($item_data);
    setcookie("gio_hang", $item_data, time() + (86400 * 30));
    header("location:mytour.php?success=1");
    ob_end_flush();
}
// end them vao gio hang bang cookie

// them binh luan
if (isset($_POST["submit_commit"])) {
    $tour_id = $_GET['tour_id'];
    $email = $_SESSION["acc_email"];
    $add_comment = $_POST["add_comment"];
    echo "<script>console.log('click')</script>";
    $sql_account_id = "SELECT `account_id` FROM `account` WHERE account_email='$email'";
    $result_accout_id = mysqli_query($conn, $sql_account_id);
    if (mysqli_num_rows($result_accout_id) > 0) {
        while ($account_id_rows = mysqli_fetch_assoc($result_accout_id)) {
            $account_id = $account_id_rows['account_id'];
        }
        $sql_khachhang_id = "SELECT `khachhang_id` FROM `khachhang` WHERE account_id='$account_id'";
        $result_khachhang_id = mysqli_query($conn, $sql_khachhang_id);
        if (mysqli_num_rows($result_khachhang_id) > 0) {
            while ($khachhang_id_rows = mysqli_fetch_assoc($result_khachhang_id)) {
                $khachhang_id = $khachhang_id_rows['khachhang_id'];
            }
            $sql_binhluan = "INSERT INTO `binhluan`(`tour_id`, `khachhang_id`, `binhluan_noidung`, `binhluan_ngay`)
            VALUES ('$tour_id','$khachhang_id','$add_comment',now())";

            if (mysqli_query($conn, $sql_binhluan)) {
                header("location:chitiet.php?tour_id=$tour_id");
            } else {
                echo "<script>console.log('loi')</script>";
            }
        } else {
            echo "<script>console.log('khong thay khach hang id')</script>";
        }
    } else {
        echo "<script>console.log('khong thay account_id')</script>";
    }
}
// end them binh luan

// them reply
if (isset($_POST["submit_reply"])) {
    $binhluan_id = $_POST["binhluan_id"];
    $replycomment = $_POST["replycomment"];
    $tour_id = $_GET['tour_id'];
    $khachhang_id = $khachhang_id;
    $email = $_SESSION["acc_email"];
    $sql_account_id = "SELECT `account_id` FROM `account` WHERE account_email='$email'";
    $result_accout_id = mysqli_query($conn, $sql_account_id);
    if (mysqli_num_rows($result_accout_id) > 0) {
        while ($account_id_rows = mysqli_fetch_assoc($result_accout_id)) {
            $account_id = $account_id_rows['account_id'];
        }
        $sql_khachhang_id = "SELECT `khachhang_id` FROM `khachhang` WHERE account_id='$account_id'";
        $result_khachhang_id = mysqli_query($conn, $sql_khachhang_id);
        if (mysqli_num_rows($result_khachhang_id) > 0) {
            while ($khachhang_id_rows = mysqli_fetch_assoc($result_khachhang_id)) {
                $khachhang_id = $khachhang_id_rows['khachhang_id'];
            }

            $sql_add_reply = "INSERT INTO `phanhoi`(`binhluan_id`, `phanhoi_nd`, `khachhang_id`, `phanhoi_ngay`, `tour_id`)
     VALUES ('$binhluan_id','$replycomment','$khachhang_id',now(),'$tour_id')";
            if (mysqli_query($conn, $sql_add_reply)) {
                header("location:chitiet.php?tour_id=$tour_id");
            } else {
                echo "<script>console.log('chua them')</script>";
            }
        } else {
            echo "<script>console.log('khong thay khach hang id')</script>";
        }
    } else {
        echo "<script>console.log('khong thay account_id')</script>";
    }
    // $sql_add_reply = "INSERT INTO `phanhoi`(`binhluan_id`, `phanhoi_nd`, `khachhang_id`, `phanhoi_ngay`, `tour_id`)
    //  VALUES ('$binhluan_id','$replycomment','$khachhang_id',now(),'$tour_id')";
    // if (mysqli_query($conn, $sql_add_reply)) {
    //     echo "<script>console.log($khachhang_id)</script>";
    // } else {
    //     echo "<script>console.log('chua them')</script>";
    // }
}
// them reply
// update thong tin ca nhan
if (isset($_POST["update_submit"])) {
    // echo"<script>console.log('clicked')</script>";
    $khachhang_id = $_POST['update_khachhang_id'];
    $khachhang_ho = $_POST['update_khachhang_ho'];
    $khachhang_ten = $_POST['update_khachhang_ten'];
    $khachhang_dienthoai = $_POST['update_khachhang_dienthoai'];
    $khachhang_ngaysinh = $_POST['update_khachhang_ngaysinh'];
    $tinh_id = $_POST['update_tinh_id'];
    $huyen_id = $_POST['update_huyen_id'];
    $xa_id = $_POST['update_xa_id'];
    $khachhang_diachi = $_POST['update_khachhang_diachi'];
    $sql_update_info = "UPDATE `khachhang` SET `khachhang_ten`='$khachhang_ten',`khachhang_ho`='$khachhang_ho',
    `khachhang_ngaysinh`='$khachhang_ngaysinh',`khachhang_dienthoai`='$khachhang_dienthoai',`tinh_id`='$tinh_id',
    `huyen_id`='$huyen_id',`xa_id`='$xa_id',`khachhang_diachi`='$khachhang_diachi' 
    WHERE khachhang_id='$khachhang_id'";
    if (mysqli_query($conn, $sql_update_info)) {
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
                        location.href = 'chitiet.php?tour_id=<?php echo $tour_id ?>';
                    }
                })
            }
        </script>
<?php
    } else {
        echo "<script>console.log('error')</script>";
    }
}
?>