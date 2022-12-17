<?php
include('../config/constants.php');
require('../templates/send_mail.php');
ob_start();
session_start();

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

if (isset($_GET['tour_id'])) {
    $tour_id = $_GET["tour_id"];
    $chitiet_tour_id = $_GET["chitiet_tour_id"];
    $sl_nguoilon = $_GET["sl_nguoilon"];
    $sl_treem = $_GET["sl_treem"];
    $gia_nguoilon = $_GET["gia_nguoilon"];
    $gia_treem = $_GET["gia_treem"];
    $ngaybook = $_GET["ngaybook"];
    $ngaysudung = $_GET["ngaysudung"];
    $tonggia = (($_GET["sl_nguoilon"] * $_GET["gia_nguoilon"]) + ($_GET["sl_treem"] * $_GET["gia_treem"]));
    debug_to_console("da get");
    if (isset($_COOKIE["gio_hang"])) {
        $cookie_data = stripcslashes($_COOKIE["gio_hang"]);
        $cart_data = json_decode($cookie_data, true);
    } else {
        $cart_data = array();
    }

    $chitiet_tour_id_list = array_column($cart_data, 'chitiet_tour_id');
    $booking_ngaysudung_list = array_column($cart_data, 'booking_ngaysudung');
    $x = 0;
    if (in_array($chitiet_tour_id, $chitiet_tour_id_list)) {
        foreach ($cart_data as $keys => $values) {
            if (($cart_data[$keys]["chitiet_tour_id"] ==  $chitiet_tour_id) && ($cart_data[$keys]["booking_ngaysudung"] == $ngaysudung)) {
                $cart_data[$keys]["booking_sl_nguoilon"] = $sl_nguoilon;
                $cart_data[$keys]["booking_sl_treem"] = $sl_treem;
                $cart_data[$keys]["booking_tonggia"] = number_format($tonggia);
                $x = 1;
                debug_to_console("khong the thay doi");
            }
        }
    } else {

        $item_array = array(
            'tour_id' => $tour_id,
            'chitiet_tour_id' => $chitiet_tour_id,
            'booking_ngaybook' => $ngaybook,
            'booking_ngaysudung' => $ngaysudung,
            'gia_nguoilon' => $gia_nguoilon,
            'gia_treem' => $gia_treem,
            'booking_sl_nguoilon' => $sl_nguoilon,
            'booking_sl_treem' => $sl_treem,
            'booking_tonggia' => $tonggia
        );
        $cart_data[] = $item_array;
    }
    $item_data = json_encode($cart_data);
    setcookie("gio_hang", $item_data, time() + (86400 * 30));
    header("location:mytour.php?success=1");
    // ob_end_flush();
} else {
    debug_to_console("chua get");
}
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

// function bo dau tieng viet
function vn_to_str($str)
{

    $unicode = array(

        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',

        'd' => 'đ',

        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',

        'i' => 'í|ì|ỉ|ĩ|ị',

        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',

        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',

        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',

        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

        'D' => 'Đ',

        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',

        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',

    );

    foreach ($unicode as $nonUnicode => $uni) {

        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }
    // $str = str_replace(' ', '_', $str);

    return $str;
}
// end function bo dau tieng viet
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
    <script script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../jquery/jquery-3.6.0.min.js"></script>
    <script src="ckfinder/ckfinder.js"></script>
    <script src="../js/check_new.js"></script>
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
                                    <li><a class="dropdown-item" href="blog.php?loaiblog=<?php echo "4"?>">Khác</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="../templates/kdl_register.php">Hợp Tác</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="mytour.php">Giỏ Hàng</a>
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
                                                            <input type="text" class="form-control" id="update_khachhang_ho" name="update_khachhang_ho" value="<?php echo $khachhang_ho ?>" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="" class="form-label" style="font-weight: 500;">Tên</label>
                                                            <input type="text" class="form-control" name="update_khachhang_ten" id="update_khachhang_ten" value="<?php echo $khachhang_ten ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="" class="form-label" style="font-weight: 500;">Số điện thoại</label>
                                                            <input type="text" class="form-control" name="update_khachhang_dienthoai" id="update_khachhang_dienthoai" value="<?php echo $khachhang_dienthoai ?>" required>
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
                                                                <input type="text" class="form-control" id="update_khachhang_diachi" name="update_khachhang_diachi" value="<?php echo $khachhang_diachi ?>" required>
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
        <div class="main_content" style="text-align:center;background-color: #f8f9fa;">
            <form action="" class="book_list" method="POST" style="margin-bottom: 0;">
                <div class="row" style="margin: 0;padding-top:50px">
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-10">
                        <div class="row" style="margin: 0;">
                            <?php
                            if (!isset($_COOKIE["gio_hang"]) && isset($_GET['send_mail'])) {
                            ?>
                                <div class="row">
                                    <div class="col-md-2">

                                    </div>
                                    <div class="col-md-8">
                                        <div class="empty-cart" style="background-color: #fff;height:200px;margin-bottom:10%;padding-top:20px;padding-bottom:20px">
                                            <h4 style="margin-bottom:30px">Cảm ơn quý khách đã sử dụng dịch vụ của chúng tôi</h4>
                                            <h5>Thông tin đặt hàng đã được gửi về email</h5>
                                            <hr style="height:0.5px;margin:0px 50px">
                                            <a class="btn button_submit" href="index.php" role="button" style="margin-top:30px;width:178px">Quay lại trang chủ</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                </div>
                                <?php
                            }
                            if (isset($_COOKIE["gio_hang"])) {
                                // $count dung de lay vi tri cua product-cart
                                $count = 0;
                                $cookie_data = stripslashes($_COOKIE["gio_hang"]);
                                $cart_data = json_decode($cookie_data, true);
                                if (strlen($_COOKIE["gio_hang"]) < 3) {
                                    // hien form khong co gi trong gio hang
                                ?>
                                    <div class="row">
                                        <div class="col-md-2">

                                        </div>
                                        <div class="col-md-8">
                                            <div class="empty-cart" style="background-color: #fff;height:200px;margin-bottom:10%;padding-top:20px;padding-bottom:20px">
                                                <h4 style="margin-bottom:30px">Bạn chưa chọn sản phẩm nào trong giỏ hàng</h4>
                                                <hr style="height:0.5px;margin:0px 50px">
                                                <a class="btn button_submit" href="index.php" role="button" style="margin-top:30px;width:178px">Quay lại trang chủ</a>
                                            </div>
                                        </div>
                                        <div class="col-md-2">

                                        </div>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="col-lg-8" style="background-color:#fff;padding:10px 20px">
                                        <h5 style="text-align: left;">Thông tin dịch vụ</h5>
                                        <?php
                                        foreach ($cart_data as $keys => $values) {
                                            $tour_id = $values["tour_id"];
                                            $chitiet_tour_id = $values["chitiet_tour_id"];
                                            $chitiet_gia_nguoilon = $values["gia_nguoilon"];
                                            $chitiet_gia_treem = $values["gia_treem"];
                                            $booking_sl_nguoilon = $values["booking_sl_nguoilon"];
                                            $booking_sl_treem = $values["booking_sl_treem"];
                                            $booking_ngaybook = $values["booking_ngaybook"];
                                            $booking_ngaysudung = $values["booking_ngaysudung"];
                                            $booking_tonggia = $values["booking_tonggia"];

                                            $sql_product = "SELECT tour.tour_ten,chitiet_tour.chitiet_avt,chitiet_tour.chitiet_ten
                                from(chitiet_tour
                                     INNER JOIN tour on tour.tour_id=chitiet_tour.tour_id) WHERE chitiet_tour_id = '$chitiet_tour_id' ";
                                            $result_product = mysqli_query($conn, $sql_product);
                                            if (mysqli_num_rows($result_product) > 0) {
                                                while ($product = mysqli_fetch_assoc($result_product)) {
                                                    $tour_ten = $product['tour_ten'];
                                                    $chitiet_avt = $product['chitiet_avt'];
                                                    $chitiet_ten = $product['chitiet_ten'];
                                                }
                                        ?>

                                                <div class="product-cart">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="hinhanh">
                                                                <!-- dung de cap nhat cookie -->
                                                                <input type="hidden" class="tour_id_update" id="tour_id_update" name="tour_id_update" value="<?php echo $tour_id ?>">
                                                                <input type="hidden" class="chitiet_tour_id_update" id="chitiet_tour_id_update" name="chitiet_tour_id_update" value="<?php echo $chitiet_tour_id ?>">
                                                                <input type="hidden" class="chitiet_gia_nguoilon_update" id="chitiet_gia_nguoilon" name="chitiet_gia_nguoilon" value="<?php echo $chitiet_gia_nguoilon ?>">
                                                                <input type="hidden" class="chitiet_gia_treem_update" id="chitiet_gia_treem" name="chitiet_gia_treem" value="<?php echo $chitiet_gia_treem ?>">
                                                                <input type="hidden" class="booking_sl_nguoilon" id="booking_sl_nguoilon" name="booking_sl_nguoilon" value="<?php echo $booking_sl_nguoilon ?>">
                                                                <input type="hidden" class="booking_sl_treem" id="booking_sl_treem" name="booking_sl_treem" value="<?php echo $booking_sl_treem ?>">
                                                                <input type="hidden" class="booking_ngaybook" id="booking_ngaybook" name="booking_ngaybook" value="<?php echo $booking_ngaybook ?>">
                                                                <input type="hidden" class="booking_ngaysudung" id="booking_ngaysudung" name="booking_ngaysudung" value="<?php echo $booking_ngaysudung ?>">
                                                                <input type="hidden" class="booking_tonggia" id="booking_tonggia" name="booking_tonggia" value="<?php echo $booking_tonggia ?>">
                                                                <!-- end cap nhat cookie -->
                                                                <input type="hidden" class="gia_nguoilon" id="gia_nguoilon" name="gia_nguoilon" value="<?php echo $chitiet_gia_nguoilon ?>">
                                                                <input type="hidden" class="gia_treem" id="gia_treem" name="gia_treem" value="<?php echo $chitiet_gia_treem ?>">

                                                                <img src="../image/<?= $chitiet_avt; ?>" alt="<?= $chitiet_avt; ?>" srcset="" width="200px" height="150px" style="border-radius:3px ;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="thongtin" style="text-align: left;">
                                                                <div class="row">
                                                                    <div class="col-md-8 ten_dicvu">
                                                                        <span style="font-size: 20px;font-weight:500;text-transform: capitalize"><?php echo $tour_ten ?></span>
                                                                        <br>
                                                                        <span style="font-weight: 500; font-size:16px"><?php echo $chitiet_ten ?></span>
                                                                    </div>
                                                                    <div class="col-md-4 gia">
                                                                        <span style="font-size: 20px;" class="tong_gia" id="tong_gia"><?php echo $booking_tonggia  ?> VND</span>
                                                                        <!-- <input type="text" style="border: none; font-size:20px;width:154px" class="tong_gia" id="tong_gia" name="tong_gia" value="<?php echo $booking_tonggia ?> VND"> -->
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <span>Ngày đặt:</span> <br>
                                                                        <span>Ngày sử dụng:</span>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <span><?php echo date('d/m/Y', strtotime($booking_ngaybook)) ?></span> <br>
                                                                        <span><?php echo date('d/m/Y', strtotime($booking_ngaysudung)) ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr style="height: 0.5px;">
                                                            <div class="soluong">
                                                                <div class="row">
                                                                    <div class="col-md-8" style="text-align: left;">
                                                                        <div class="soluong-text">
                                                                            <span>Người lớn (cao từ 140cm)</span><br>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="soluong-chose">
                                                                            <input type="number" class="form-control nguoilon" id="sl_nguoilon" name="sl_nguoilon" onmouseover="min_soluong()" onchange="new_tong();update(<?php echo $count ?>);soluong();tongcong()" value="<?php echo $booking_sl_nguoilon ?>"> <br>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-8" style="text-align: left;">
                                                                        <div class="soluong-text">
                                                                            <span>Trẻ em (cao dưới 140cm)</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="soluong-chose">
                                                                            <input type="number" class="form-control treem" id="sl_treem" name="sl_treem" onmouseover="min_soluong()" onchange="new_tong();update(<?php echo $count ?>);soluong();tongcong()" value="<?php echo $booking_sl_treem ?>"> <br>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="xoa" style="text-align: left;">
                                                                <a href="mytour.php?acction=delete&chitiet_tour_id=<?php echo $chitiet_tour_id ?>&booking_ngaysudung=<?php echo $values["booking_ngaysudung"] ?>" style="text-decoration: none;"><span class="text-danger">Xóa</span></a>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <hr style="height:0.5px">
                                            <?php

                                            }
                                            ?>
                                            <input type="hidden" class="count" id="count" name="count" value="<?php echo $count ?>">
                                        <?php
                                            $count = $count + 1;
                                        }

                                        ?>

                                    </div>
                                    <div class="col-lg-4" style="width:393px;margin-left:20px">
                                        <?php
                                        if (isset($_COOKIE["gio_hang"])) {
                                        ?>
                                            <div class="thanhtoan" style="background-color: #fff; padding:10px 20px">
                                                <div class="thanhtoan-title">
                                                    <span style="font-size: 20px;font-weight:500">Thông Tin Thanh Toán</span>
                                                </div>
                                                <hr>
                                                <div class="thanhtoan-body">
                                                    <div class="thongtin-sanpham" style="text-align: left;">
                                                        <?php
                                                        if (isset($_COOKIE["gio_hang"])) {
                                                            $cookie_data = stripslashes($_COOKIE["gio_hang"]);
                                                            $cart_data = json_decode($cookie_data, true);
                                                            foreach ($cart_data as $keys => $values) {
                                                                $tour_id = $values["tour_id"];
                                                                $chitiet_tour_id = $values["chitiet_tour_id"];
                                                                $chitiet_gia_nguoilon = $values["gia_nguoilon"];
                                                                $chitiet_gia_treem = $values["gia_treem"];
                                                                $booking_sl_nguoilon = $values["booking_sl_nguoilon"];
                                                                $booking_sl_treem = $values["booking_sl_treem"];
                                                                $booking_ngaybook = $values["booking_ngaybook"];
                                                                $booking_ngaysudung = $values["booking_ngaysudung"];

                                                                $sql_product = "SELECT tour.tour_ten,chitiet_tour.chitiet_avt,chitiet_tour.chitiet_ten
                                        from(chitiet_tour
                                             INNER JOIN tour on tour.tour_id=chitiet_tour.tour_id) WHERE chitiet_tour_id = '$chitiet_tour_id' ";
                                                                $result_product = mysqli_query($conn, $sql_product);
                                                                if (mysqli_num_rows($result_product) > 0) {
                                                                    while ($product = mysqli_fetch_assoc($result_product)) {
                                                                        $tour_ten = $product['tour_ten'];
                                                                        $chitiet_ten = $product['chitiet_ten'];
                                                                    }
                                                                }

                                                        ?>
                                                                <div class="ds-sanpham">
                                                                    <span style="text-transform: capitalize;font-weight: 500;"><?php echo $tour_ten ?></span> <br>
                                                                    <span><?php echo $chitiet_ten ?></span> <br>
                                                                    <div class="ngay">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <span>Ngày sử dụng:</span>
                                                                            </div>
                                                                            <div class="col-md-6" style="text-align: right;">
                                                                                <span><?php echo date('d/m/Y', strtotime($booking_ngaysudung)) ?></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="soluong">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <span>Người lớn:</span>
                                                                            </div>
                                                                            <div class="col-md-3" style="text-align: right;">
                                                                                <!-- <span class="thanhtoan_sl_nguoilon" id="thanhtoan_nguoilon"><?php echo $booking_sl_nguoilon ?></span> -->
                                                                                <input type="number" style="border: none;margin-left:40px;width:100px" class="thanhtoan_sl_nguoilon" id="thanhtoan_sl_nguoilon" name="thanhtoan_sl_nguoilon" value="<?php echo $booking_sl_nguoilon ?>">
                                                                            </div>
                                                                            <div class="col-md-5" style="text-align: right;">
                                                                                <?php
                                                                                $thanhtoan_tong_nguoilon = $booking_sl_nguoilon * $chitiet_gia_nguoilon;
                                                                                ?>
                                                                                <span class="thanhtoan_tong_nguoilon" id="thanhtoan_tong_nguoilon"><?php echo number_format($thanhtoan_tong_nguoilon) ?> VND</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <span>Trẻ em:</span>
                                                                            </div>
                                                                            <div class="col-md-3" style="text-align: right;">
                                                                                <!-- <span class="thanhtoan_sl_treem" id="thanhtoan_treem"><?php echo $booking_sl_treem ?></span> -->
                                                                                <input type="number" style="border: none;margin-left:40px;width:100px" class="thanhtoan_sl_treem" id="thanhtoan_sl_treem" name="thanhtoan_sl_treem" value="<?php echo $booking_sl_treem ?>">

                                                                            </div>
                                                                            <div class="col-md-5" style="text-align: right;">
                                                                                <?php
                                                                                $thanhtoan_tong_treem = $booking_sl_treem * $chitiet_gia_treem;
                                                                                ?>
                                                                                <span class="thanhtoan_tong_treem" id="thanhtoan_tong_treem"><?php echo number_format($thanhtoan_tong_treem) ?> VND</span>
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
                                                    <hr>
                                                    <div class="thanhtien">
                                                        <div class="row">
                                                            <div class="col-md-6" style="text-align: left;">
                                                                <span style="font-size: 20px;">Tổng tiền:</span>
                                                            </div>
                                                            <div class="col-md-6" style="text-align: right;">

                                                                <span style="font-size: 20px;" class="thanhtoan_tong" id="thanhtoan_tong"></span>
                                                                <!-- <input type="text" style="border: none;width:100px" class="thanhtoan_tong" id="thanhtoan_tong" value=""> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                    </div>
                                <?php
                                }
                            } elseif (!isset($_COOKIE["gio_hang"]) && !isset($_GET["send_mail"])) {
                                ?>
                                <div class="row">
                                    <div class="col-md-2">

                                    </div>
                                    <div class="col-md-8">
                                        <div class="empty-cart" style="background-color: #fff;height:200px;margin-bottom:10%;padding-top:20px;padding-bottom:20px">
                                            <h4 style="margin-bottom:30px">Bạn chưa chọn sản phẩm nào trong giỏ hàng</h4>
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

                        <!-- neu co cookie thi tao form nhap thong tin nguoi dat -->
                        <?php
                        if (!isset($_COOKIE["gio_hang"]) || strlen($_COOKIE["gio_hang"]) < 3) {
                        } else {
                            if (isset($_SESSION["acc_email"])) {
                                $sql = "SELECT `khachhang_id`,`khachhang_ten`, `khachhang_ho`,`khachhang_dienthoai`
                                FROM `khachhang`  WHERE khachhang.account_id='$account_id'";
                                $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                    // output data of each row
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $khachhang_id = $row['khachhang_id'];
                                        $khachhang_ten = $row['khachhang_ten'];
                                        $khachhang_ho = $row['khachhang_ho'];
                                        $khachhang_dienthoai = $row['khachhang_dienthoai'];
                                    }
                        ?>
                                    <div class="row" style="margin: 0;">
                                        <div class="col-lg-8 khachhang-info" style="background-color:#fff;margin:30px 0px;padding:10px 20px">
                                            <h5 style="text-align:left">Thông tin khách hàng</h5>
                                            <form action="" method="post">
                                                <div class="row">
                                                    <div class="col-md-6" style="text-align: left;">
                                                        <span style="color: red;">*</span><label for="">Họ (không dấu)</label>
                                                        <input type="text" class=" form-control info_ho_kh" id="info_ho_kh" name="info_ho_kh" oninput="validate_info()" value="<?php echo vn_to_str($khachhang_ho) ?>" required>
                                                        <span class="error_ho_kh" id="error_ho_kh" style="color:red"></span>
                                                    </div>
                                                    <div class="col-md-6" style="text-align: left;">
                                                        <span style="color: red;">*</span><label for="">Tên đệm và tên (không dấu)</label>
                                                        <input type="text" class="form-control info_ten_kh" id="info_ten_kh" name="info_ten_kh" oninput="validate_info()" value="<?php echo vn_to_str($khachhang_ten) ?>" required>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6" style="text-align: left;">
                                                        <span style="color: red;">*</span><label for="">Số điện thoại</label>
                                                        <input type="text" class="form-control info_sdt_kh" id="info_sdt_kh" name="info_sdt_kh" oninput="validate_info()" value="<?php echo $khachhang_dienthoai ?>" required>
                                                    </div>
                                                    <div class="col-md-6" style="text-align: left;">
                                                        <span style="color: red;">*</span><label for="">Email</label>
                                                        <input type="email" class="form-control info_email_kh" id="info_email_kh" name="info_email_kh" oninput="validate_info()" value="<?php echo $_SESSION["acc_email"] ?>" required>
                                                    </div>
                                                </div>
                                                <br>
                                                <button type="submit" class="btn button_submit" name="dat_hang" id="dat_hang" onclick="return validate_info()">Đồng ý</button>
                                            </form>
                                        </div>
                                        <div class="col-lg-4">

                                        </div>
                                    </div>
                                <?php
                                }
                            } else {
                                ?>
                                <div class="row" style="margin: 0;">
                                    <div class="col-lg-8 khachhang-info" style="background-color:#fff;margin:30px 0px;padding:10px 20px">
                                        <h5 style="text-align:left">Thông tin khách hàng</h5>
                                        <form action="" method="post">
                                            <div class="row">
                                                <div class="col-md-6" style="text-align: left;">
                                                    <span style="color: red;">*</span><label for="">Họ (không dấu)</label>
                                                    <input type="text" class=" form-control info_ho_kh" id="info_ho_kh" name="info_ho_kh" oninput="validate_info()" placeholder="VD: Nguyen" required>
                                                    <span class="error_ho_kh" id="error_ho_kh" style="color:red"></span>
                                                </div>
                                                <div class="col-md-6" style="text-align: left;">
                                                    <span style="color: red;">*</span><label for="">Tên đệm và tên (không dấu)</label>
                                                    <input type="text" class="form-control info_ten_kh" id="info_ten_kh" name="info_ten_kh" oninput="validate_info()" placeholder="VD: Van A" required>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6" style="text-align: left;">
                                                    <span style="color: red;">*</span><label for="">Số điện thoại</label>
                                                    <input type="text" class="form-control info_sdt_kh" id="info_sdt_kh" name="info_sdt_kh" oninput="validate_info()" placeholder="VD: 0963258741" required>
                                                </div>
                                                <div class="col-md-6" style="text-align: left;">
                                                    <span style="color: red;">*</span><label for="">Email</label>
                                                    <input type="email" class="form-control info_email_kh" id="info_email_kh" name="info_email_kh" oninput="validate_info()" placeholder="VD: vananguyen@gmail.com" required>
                                                </div>
                                            </div>
                                            <br>
                                            <button type="submit" class="btn button_submit" name="dat_hang" id="dat_hang" onclick="return validate_info()">Đồng ý</button>
                                        </form>
                                    </div>
                                    <div class="col-lg-4">

                                    </div>
                                </div>
                            <?php
                            }
                            ?>



                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-md-1">

                    </div>
                </div>



            </form>

        </div>
        <?php
        include("../templates/footer.html")
        ?>
    </div>

    <!-- tinh tong tien item -->
    <script>
        var nguoilon = document.getElementsByClassName('nguoilon');
        var treem = document.getElementsByClassName('treem');
        var gia_nguoilon = document.getElementsByClassName('gia_nguoilon');
        var gia_treem = document.getElementsByClassName('gia_treem');
        var tong_gia = document.getElementsByClassName('tong_gia');
        var thanhtoan_tong_nguoilon = document.getElementsByClassName('thanhtoan_tong_nguoilon');
        var thanhtoan_tong_treem = document.getElementsByClassName('thanhtoan_tong_treem');
        var thanhtoan_tong_text = document.getElementsByClassName('thanhtoan_tong');
        const formatter = new Intl.NumberFormat('en');
        var gia = '';
        var thanhtoan_nguoilon = '';
        var thanhtoan_treem = '';

        function new_tong() {
            for (i = 0; i < nguoilon.length; i++) {
                gia = formatter.format((nguoilon[i].value * gia_nguoilon[i].value) + (treem[i].value * gia_treem[i].value));
                tong_gia[i].textContent = gia + (" VND");
                thanhtoan_nguoilon = formatter.format(nguoilon[i].value * gia_nguoilon[i].value);
                thanhtoan_tong_nguoilon[i].textContent = thanhtoan_nguoilon + (" VND");
                thanhtoan_treem = formatter.format(treem[i].value * gia_treem[i].value);
                thanhtoan_tong_treem[i].textContent = thanhtoan_treem + (" VND");
                // thanhtoan_tong = formatter.format(thanhtoan_tong + ((nguoilon[i].value * gia_nguoilon[i].value) + (treem[i].value * gia_treem[i].value)));
                // thanhtoan_tong_text.textContent = thanhtoan_tong + (" VND");

            }
        }

        // thay doi so luong tai thanh toan
        var thanhtoan_sl_nguoilon = document.getElementsByClassName('thanhtoan_sl_nguoilon');
        var thanhtoan_sl_treem = document.getElementsByClassName('thanhtoan_sl_treem');

        function soluong() {
            for (i = 0; i < thanhtoan_sl_nguoilon.length; i++) {
                thanhtoan_sl_nguoilon[i].value = nguoilon[i].value;
                thanhtoan_sl_treem[i].value = treem[i].value;
            }
        }

        // tinh tong tien tat ca san pham
        var thanhtoan_tong = document.getElementById('thanhtoan_tong');
        var temp = 0;
        var tong = 0;
        for (i = 0; i < thanhtoan_sl_nguoilon.length; i++) {
            temp = (nguoilon[i].value * gia_nguoilon[i].value) + (treem[i].value * gia_treem[i].value);
            tong = tong + temp;
        }
        thanhtoan_tong.textContent = formatter.format(tong) + (" VND");

        // tinh lai tong khi thay doi so luong
        function tongcong() {
            var thanhtoan_tong = document.getElementById('thanhtoan_tong');
            var temp = 0;
            var tong = 0;
            for (i = 0; i < thanhtoan_sl_nguoilon.length; i++) {
                temp = (nguoilon[i].value * gia_nguoilon[i].value) + (treem[i].value * gia_treem[i].value);
                tong = tong + temp;
            }
            thanhtoan_tong.textContent = formatter.format(tong) + (" VND");


        }
    </script>

    <!-- update gia tri trong cookie -->
    <script>
        var tour_id_update = document.getElementsByClassName('tour_id_update');
        var chitiet_tour_id_update = document.getElementsByClassName('chitiet_tour_id_update');
        var nguoilon = document.getElementsByClassName('nguoilon');
        var treem = document.getElementsByClassName('treem');
        var chitiet_gia_nguoilon_update = document.getElementsByClassName('chitiet_gia_nguoilon_update');
        var chitiet_gia_treem_update = document.getElementsByClassName('chitiet_gia_treem_update');

        var booking_ngaybook = document.getElementsByClassName('booking_ngaybook');
        var booking_ngaysudung = document.getElementsByClassName('booking_ngaysudung');
        var tong_gia = document.getElementsByClassName('tong_gia');


        function update(count) {
            console.log(count);
            let url = "http://localhost/DULICHDBSCL/khachhang/mytour.php";
            window.location.href = url + "?tour_id=" + tour_id_update[count].value + "&chitiet_tour_id=" + chitiet_tour_id_update[count].value + "&sl_nguoilon=" + nguoilon[count].value +
                "&sl_treem=" + treem[count].value + "&gia_nguoilon=" + chitiet_gia_nguoilon_update[count].value + "&gia_treem=" + chitiet_gia_treem_update[count].value +
                "&ngaybook=" + booking_ngaybook[count].value + "&ngaysudung=" + booking_ngaysudung[count].value + "&tonggia=" + tong_gia[count].textContent;
        }
    </script>
    <!-- checker -->
    <script>
        function validate_info() {
            flag = true;
            var x = document.getElementById('info_sdt_kh').value;
            if (x == "" || !/^[0-9]+$/.test(x)) {
                document.getElementById('info_sdt_kh').style.borderColor = "red";
                flag = false;
            } else {
                document.getElementById('info_sdt_kh').style.borderColor = "green";
            }
            var y = document.getElementById('info_ho_kh').value;
            if (y == "" || !/^[a-zA-Z]+$/.test(y)) {
                document.getElementById('info_ho_kh').style.borderColor = "red";
                flag = false;
            } else {
                document.getElementById('info_ho_kh').style.borderColor = "green";
            }
            var z = document.getElementById('info_ten_kh').value;
            if (z == "" || !/^[a-zA-Z\s]+$/.test(z)) {
                document.getElementById('info_ten_kh').style.borderColor = "red";
                flag = false;
            } else {
                document.getElementById('info_ten_kh').style.borderColor = "green";
            }
            var e = document.getElementById('info_email_kh').value;
            if (e == "" || !/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(e)) {
                document.getElementById('info_email_kh').style.borderColor = "red";
                flag = false;
            } else {
                document.getElementById('info_email_kh').style.borderColor = "green";
            }
            return flag;
        }
    </script>
    <!-- end checker -->

    <!-- chat bot -->
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

  fpt_ai_livechat_script.onload = function () {
      fpt_ai_render_chatbox(objPreDefineLiveChat, __baseUrl, 'livechat.fpt.ai:443');
  }
</script>
    <!-- end chatbot -->

</body>

</html>
<?php
if (isset($_GET["acction"])) {
    if ($_GET["acction"] == "delete") {
        $cookie_data = stripslashes($_COOKIE['gio_hang']);
        $cart_data = json_decode($cookie_data, true);
        foreach ($cart_data as $keys => $values) {
            if (($cart_data[$keys]['chitiet_tour_id'] == $_GET["chitiet_tour_id"]) && ($cart_data[$keys]['booking_ngaysudung'] == $_GET["booking_ngaysudung"])) {
                unset($cart_data[$keys]);
                $item_data = json_encode($cart_data);
                setcookie("gio_hang", $item_data, time() + (86400 * 30));
                header("location:mytour.php?xoa=1");
                ob_end_flush();
                echo "<script>alert('da xoa dich vu nay')</script>";
            }
        }
    }
}

if (isset($_POST["dat_hang"])) {
    $info_ho_kh = $_POST['info_ho_kh'];
    $info_ten_kh = $_POST['info_ten_kh'];
    $info_email_kh = $_POST['info_email_kh'];
    $info_sdt_kh = $_POST['info_sdt_kh'];
    $thanhtoan_sl_nguoilon = $_POST["thanhtoan_sl_nguoilon"];
    $thanhtoan_sl_treem = $_POST["thanhtoan_sl_treem"];
    // insert in to booking_khachhang
    $sql_info_khachhang = "INSERT INTO `booking_khachhang`(`info_ho_kh`, `info_ten_kh`, `info_email_kh`, `info_sdt_kh`) 
    VALUES ('$info_ho_kh','$info_ten_kh','$info_email_kh','$info_sdt_kh')";
    if (mysqli_query($conn, $sql_info_khachhang)) {
        $sql_kh_id = "SELECT max(kh_id) as kh_id FROM booking_khachhang";
        $result_kh_id = mysqli_query($conn, $sql_kh_id);
        if (mysqli_num_rows($result_kh_id) > 0) {
            while ($row_id = mysqli_fetch_assoc($result_kh_id)) {
                $kh_id = $row_id['kh_id'];
            }
            if (isset($_COOKIE["gio_hang"])) {
                $cookie_data = stripslashes($_COOKIE["gio_hang"]);
                $cart_data = json_decode($cookie_data, true);
                $flag = 0;
                foreach ($cart_data as $keys => $values) {
                    $tour_id = $values["tour_id"];
                    $chitiet_tour_id = $values["chitiet_tour_id"];
                    $chitiet_gia_nguoilon = $values["gia_nguoilon"];
                    $chitiet_gia_treem = $values["gia_treem"];
                    $booking_sl_nguoilon = $values["booking_sl_nguoilon"];
                    $booking_sl_treem = $values["booking_sl_treem"];
                    $booking_ngaybook = $values["booking_ngaybook"];
                    $booking_ngaysudung = $values["booking_ngaysudung"];
                    $tong = ($booking_sl_nguoilon * $chitiet_gia_nguoilon) + ($booking_sl_treem * $chitiet_gia_treem);
                    $sql_insert_booking = "INSERT INTO `booking`(`tour_id`, `chitiet_tour_id`, `booking_ngaybook`, `booking_ngaysudung`, 
                        `booking_sl_nguoilon`, `booking_sl_treem`, `booking_tonggia`, `booking_trangthai`, `kh_id`,`xoa`)
                         VALUES ('$tour_id','$chitiet_tour_id','$booking_ngaybook','$booking_ngaysudung','$booking_sl_nguoilon',
                         '$booking_sl_treem','$tong','0','$kh_id','0')";
                    if (mysqli_query($conn, $sql_insert_booking)) {
                        $flag = 1;
                    } else {
                        echo "Error deleting record: " . mysqli_error($conn);
                        $flag = 0;
                    }

                    if ($flag == 1) {
                        debug_to_console("da xoa cookie");
                        setcookie("gio_hang", "", time() + (86400 * 30));
                        header("location:mytour.php?dathang=1");
                        $noidung = "<p>Xin chào quý khách " . $info_ten_kh . "</p>";
                        $noidung .= "<p>ViVuMekong cảm ơn quý khách đã đặt dịch vụ du lịch tại ViVuMekong</p>";
                        $noidung .= "<h3>Thông tin đơn hàng</h3>";
                        $sql_ten_tour = "SELECT tour.tour_ten,chitiet_tour.chitiet_ten,booking.booking_ngaybook,booking.booking_ngaysudung,
                            booking.booking_sl_nguoilon,booking.booking_sl_treem,booking.booking_tonggia,account.account_email,tour.tour_dienthoai
                            FROM(((booking
                                 INNER JOIN tour ON tour.tour_id=booking.tour_id)
                                 INNER JOIN account ON account.account_id=tour.account_id)
                                 INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)  WHERE booking.kh_id=$kh_id";
                        $result = mysqli_query($conn, $sql_ten_tour);
                        if (mysqli_num_rows($result) > 0) {
                            $noidung .= "<!DOCTYPE html>
                            <html>
                            <head>
                            <style>
                            table, td, th {
                              border: 1px solid black;
                            }
                            
                            table {
                              border-collapse: collapse;
                              width: 100%;
                            }
                            
                            th {
                              height: 70px;
                            }
                            </style>
                            </head>
                            <table>
                            <thead>
                                <tr>
                                    <th>Tên khu du lịch</th>
                                    <th>Tên dịch vụ</th>
                                    <th>Ngày đặt</th>
                                    <th>Ngày sử dụng</th>
                                    <th>Người lớn</th>
                                    <th>Trẻ em</th>
                                    <th>Tổng giá</th>
                                    <th>Liên hệ</th>

                                </tr>
                                </thead>
                                <tbody> 
                                ";
                            while ($chitiet = mysqli_fetch_assoc($result)) {
                                $mail_ten_tour = $chitiet['tour_ten'];
                                $mail_account_email = $chitiet['account_email'];
                                $mail_tour_dienthoai = $chitiet['tour_dienthoai'];
                                $mail_chitiet_ten = $chitiet['chitiet_ten'];
                                $mail_ngaybook = $chitiet['booking_ngaybook'];
                                $mail_ngaysudung = $chitiet['booking_ngaysudung'];
                                $mail_sl_nguoilon = $chitiet['booking_sl_nguoilon'];
                                $mail_sl_treem = $chitiet['booking_sl_treem'];
                                $mail_tonggia = $chitiet['booking_tonggia'];
                                $noidung .= "<tr><td>" . $mail_ten_tour . "</td>
                                    <td>" . $mail_chitiet_ten . "</td>
                                    <td>" . date('d/m/Y', strtotime($mail_ngaybook)) . "</td>
                                    <td>" . date('d/m/Y', strtotime($mail_ngaysudung)) . "</td>
                                    <td>" . $mail_sl_nguoilon . "</td>
                                    <td>" . $mail_sl_treem . "</td>
                                    <td>" . number_format($mail_tonggia) . "</td>
                                    <td>" . $mail_tour_dienthoai ."</td>
                                    </tr>";
                            }
                            $noidung .= "
                                
                                </tbody>
                            </table>
                        </body>
                        </html>
                            ";
                            $noidung .= "Vui lòng theo dõi trạng thái đơn hàng tại hệ thống, xin chân thành cảm ơn";
                        } else {
                            debug_to_console("error");
                        }
                    } else {
                        debug_to_console("chua xoa cookie");
                    }
                }
                $tieude = "<ViVuMekong>Cảm ơn quý khách đã sử dụng dịch vụ";
                $maildathang = $info_email_kh;
                $mail = new Mailer();
                $mail->dathangmail($tieude, $noidung, $maildathang);
            }
        }
    }
    // end insert into 
    // tim mail cua tour_id de gui mail thong bao
    $sql_mail_tour = "SELECT DISTINCT account.account_email
                        FROM ((booking
                              INNER JOIN tour ON tour.tour_id=booking.tour_id)
                              INNER JOIN account ON account.account_id=tour.account_id)
                              WHERE booking.kh_id='$kh_id'";
    $result_mail = mysqli_query($conn, $sql_mail_tour);
    if (mysqli_num_rows($result_mail) > 0) {
        while ($mail = mysqli_fetch_assoc($result_mail)) {
            $account_email = $mail['account_email'];
            // $title = "đơn hàng mới";
            // $content = "khu du lịch của bạn có đơn hàng mới";
            // $sendmail = new Mailer();
            // $sendmail->dathangmail($title, $content, $account_email);
            $sql_mail_content = "SELECT booking.chitiet_tour_id,chitiet_tour.chitiet_ten,booking.booking_ngaybook,booking.booking_ngaysudung,
            booking.booking_sl_nguoilon,booking.booking_sl_treem,booking.booking_tonggia
            FROM (((booking
                  INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                  INNER JOIN tour ON tour.tour_id=booking.tour_id)
                  INNER JOIN account ON account.account_id=tour.account_id)
                  WHERE booking.kh_id='$kh_id' && account.account_email='$account_email'";
            $result_mail_content = mysqli_query($conn, $sql_mail_content);
            if (mysqli_num_rows($result_mail_content) > 0) {
                $content = "<p>Xin chào quý đối tác</p>";
                $content .= "<p>Khu du lịch của bạn có đơn hàng mới</p>";
                $content .= "<h3>Thông tin đơn hàng</h3>";
                $content .= "<!DOCTYPE html>
                            <html>
                            <head>
                            <style>
                            table, td, th {
                              border: 1px solid black;
                            }
                            
                            table {
                              border-collapse: collapse;
                              width: 100%;
                            }
                            
                            th {
                              height: 70px;
                            }
                            </style>
                            </head>
                            <table>
                            <thead>
                                <tr>
                                    <th>STT</th>  
                                    <th>Tên Dịch vụ </th>                                   
                                    <th>Ngày đặt</th>
                                    <th>Ngày sử dụng</th>
                                    <th>Người lớn</th>
                                    <th>Trẻ em</th>
                                    <th>Tổng giá</th>
                                </tr>
                                </thead>
                                <tbody> 
                                ";
                $n = 1;
                while ($mail_content = mysqli_fetch_assoc($result_mail_content)) {
                    $chitiet_tour_id = $mail_content['chitiet_tour_id'];
                    $chitiet_ten = $mail_content['chitiet_ten'];
                    $booking_ngaybook = $mail_content['booking_ngaybook'];
                    $booking_ngaysudung = $mail_content['booking_ngaysudung'];
                    $booking_sl_nguoilon = $mail_content['booking_sl_nguoilon'];
                    $booking_sl_treem = $mail_content['booking_sl_treem'];
                    $booking_tonggia = $mail_content['booking_tonggia'];

                    $content .= "<tr>
                                      <td>" . $n . "</td>
                                    <td>" . $chitiet_ten . "</td>
                                    <td>" . date('d/m/Y', strtotime($booking_ngaybook)) . "</td>
                                    <td>" . date('d/m/Y', strtotime($booking_ngaysudung)) . "</td>
                                    <td>" . $booking_sl_nguoilon . "</td>
                                    <td>" . $booking_sl_treem . "</td>
                                    <td>" . number_format($booking_tonggia) . "</td>
                                    </tr>";
                    $n = $n + 1;
                }
                $content .= "
                                
                                </tbody>
                            </table>
                        </body>
                        </html>
                            ";
                $content .= "Vui lòng đăng nhập hệ thống để tiến hành xử lý đơn hàng tại http://localhost/DULICHDBSCL/templates/login.php";
                $content .= "<br>ViVuMekong xin chân thành cảm ơn";
                $title = "<ViVuMekong>Đơn hàng mới";
                $sendmail = new Mailer();
                $sendmail->dathangmail($title, $content, $account_email);
            } else {
                debug_to_console("khong tim thay thong tin");
            }
        }
    }
    debug_to_console("khong tim thay mail cua tour_id");
    // tim mail cua tour_id de gui mail thong bao
}
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
                        location.href = 'mytour.php';
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