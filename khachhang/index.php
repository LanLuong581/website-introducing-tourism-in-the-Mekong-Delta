<?php
include('../config/constants.php');
session_start();
ob_start();
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
    <script src="../js/check_pw.js"></script>
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
        .search-btn {
            background-color: #2d7d90;
            color: #fff
        }

        .search-btn:hover {
            background-color: #22577a;
            color: #fff;
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
                                <a class="nav-link active" aria-current="page" href="index.php">Trang chủ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="vuichoi.php">Vui Chơi</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="vuontraicay.php">Vườn Trái Cây</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="thamquan.php">Tham Quan</a>
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
                                        <li data-bs-toggle="modal" data-bs-target="#doimatkhau"><a class="dropdown-item bi bi-person"> Đổi mật khẩu</a></li>
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
                                                                <input class="form-control" type="text" class="form-control" id="update_khachhang_diachi" name="update_khachhang_diachi" value="<?php echo $khachhang_diachi ?>" required>
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
                        <!-- modal nhap mat khau cu -->
                        <div class="modal fade" id="doimatkhau" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog ">
                                <form action="" method="post" id="submit">
                                    <div class="modal-content bg-modal">
                                        <div class="modal-header" style="background: #2d7d90;color:#fff">
                                            <h5 class="modal-title" id="exampleModalLabel">Đổi mật khẩu tài khoản</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <p><span style="color:red">(*) </span>Nhập mật khẩu cũ</p>
                                                <input type="password" class="form-control" id="old_pass" name="old_pass" required>
                                                <p style="display: none;color:red" id="error1" class="error1">Vui lòng điền mật khẩu cũ</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn button_close" data-bs-dismiss="modal">Đóng</button>
                                            <button type="button" class="btn button_submit" id="xacnhan_submit" onclick="return check()">
                                                Tiếp tục
                                            </button>
                                        </div>
                                    </div>
                                    <!-- data-bs-toggle="modal" data-bs-target="#xacnhan" -->
                                </form>
                            </div>
                        </div>
                        <!--end modal nhap mat khau cu -->
                        <!-- modal nhap mat khau moi -->
                        <div class="modal fade" id="xacnhan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog ">
                                <form action="" method="post">
                                    <div class="modal-content bg-modal">
                                        <div class="modal-header" style="background: #2d7d90;color:#fff">
                                            <h5 class="modal-title" id="exampleModalLabel">Đổi mật khẩu tài khoản</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">

                                                <input type="hidden" id="old" name="old">
                                                <p><span style="color:red">(*) </span>Nhập mật khẩu mới</p>
                                                <input type="password" class="form-control" id="new_pass" name="new_pass">
                                                <p style="color:red" id="error2"></p>

                                            </div>
                                            <div class="row">
                                                <p><span style="color:red">(*) </span>Nhập mật khẩu mới</p>
                                                <input type="password" class="form-control" id="repass" name="repass">
                                                <p style="color:red" id="error3"></p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn button_close" data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn button_submit" id="change_submit" name="change_submit" onclick="return check_newpass()">Xác nhận</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!-- modal nhap mat khau moi -->
                    </div>
                </div>
            </nav>
        </div>
        <div class="main-content" style="background-color: #f8f9fa;">
            <!-- hinh avatar-tim kiem -->
            <div class="phandau">
                <div class="timkiem" style="padding-top: 150px;padding-left:300px;padding-right:300px">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-10">
                                <select class="form-select" aria-label="Default select example" name="tinh" required>
                                    <option selected style="color:gray" value="" disabled>Lựa chọn tỉnh bạn muốn đến</option>
                                    <option value="8">Long An</option>
                                    <option value="12">Cần Thơ</option>
                                    <option value="16">Kiên Giang</option>
                                    <option value="26">Tiền Giang</option>
                                    <option value="30">An Giang</option>
                                    <option value="37">Bến Tre</option>
                                    <option value="39">Cà Mau</option>
                                    <option value="40">Vĩnh Long</option>
                                    <option value="47">Đồng Tháp</option>
                                    <option value="48">Sóc Trăng</option>
                                    <option value="52">Trà Vinh</option>
                                    <option value="53">Hậu Giang</option>
                                    <option value="55">Bạc Liêu</option>

                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-light search-btn" style="width: 95px;font-weight:600;border:none" id="search_submit" name="search_submit">Tìm kiếm</button>
                            </div>
                        </div>

                    </form>
                    <br>
                    <div class="timkiem_noi">
                        <!-- test -->
                        <div class="row">
                            <div class="col-md-1">
                                <button class="talk bbi bi-mic-fill" style="width:45px;height:45px;color:#fff;background-color:#22577a"></button>
                            </div>
                            <div class="col-md-11">
                                <form action="" method="post">
                                    <div class="row g-2">
                                        <div class="col-md-10">
                                            <input type="text" class="content form-control" id="content" name="content" placeholder="Nói tên khu du lịch" style="background: none;border-top: none;border-right:none;border-left:none;color:#fff;border-radius:0;font-size:20px">

                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" id="voice_submit" name="voice_submit" class="bi bi-search" style="width: 95px;height:45px;font-weight:600;border:none;background-color:#22577a;color:#fff" title="Tìm bằng giọng nói"></button>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- <h3 class="content"></h3> -->
                        <!-- end test -->
                    </div>

                </div>
            </div>

        </div>
        <div class="product">
            <div class="form">
                <div class="row" style="margin:0">
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-10" style="padding-bottom: 50px;">
                        <h5 style="padding-top: 20px;">Tất cả khu du lịch</h5>
                        <div class="product_list">
                            <div class="grid" style="grid-template-columns: repeat(4, 1fr);margin-top:20px;margin-left:40px;margin-right:40px;padding-left:0px">
                                <?php
                                function currency_format($number, $suffix = ' vnđ')
                                {
                                    if (!empty($number)) {
                                        return number_format($number, 0, ',', '.') . "{$suffix}";
                                    }
                                }
                                $sql_tour = "SELECT DISTINCT  tour.tour_id, tour.tour_ten,tour.tour_avt,tour.tour_dienthoai,province._name as tinh_ten,district._name as huyen_ten,
                ward._name as xa_ten,tour.tour_diachi,account_email,tour.tour_trangthai,loai_tour.loaitour_ten
                FROM (((((( chitiet_tour
                      INNER JOIN tour ON tour.tour_id=chitiet_tour.tour_id)
                      INNER JOIN province ON province.id=tour.tinh_id)
                      INNER JOIN district ON district.id=tour.huyen_id)
                      INNER JOIN ward ON ward.id=tour.xa_id)
                      INNER JOIN loai_tour ON loai_tour.loaitour_id=tour.loaitour_id)
                      INNER JOIN account ON account.account_id=tour.account_id)
                      WHERE account.daily_trangthai='1' && tour.tour_gioithieu != 'NULL' ORDER BY tour.tour_id ASC";
                                $result_tour = mysqli_query($conn, $sql_tour);
                                if (mysqli_num_rows($result_tour) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_tour)) {
                                        $tour_id = $row['tour_id'];
                                ?>
                                        <article>
                                            <img src="../image/<?php echo $row['tour_avt'] ?>" alt="" width="400px" height="200px">
                                            <div class="text" style="padding: 10px;">
                                                <h4 style="text-align: center;"><?php echo ucwords($row['tour_ten']) ?></h4>
                                                <p style="text-align: left;">Địa chỉ: <?php echo $row['huyen_ten'] ?>,<?php echo $row['tinh_ten'] ?></p>
                                                <p style="text-align: left;">Loại hình: <?php echo $row['loaitour_ten'] ?></p>
                                                <?php

                                                $sql_gia = "SELECT MIN(chitiet_gia_nguoilon) as min_gia
                                FROM chitiet_tour WHERE `tour_id`='$tour_id'";
                                                $result_gia = mysqli_query($conn, $sql_gia);
                                                if (mysqli_num_rows($result_gia) > 0) {
                                                    while ($gia_tour = mysqli_fetch_assoc($result_gia)) {
                                                        $min_gia = currency_format($gia_tour['min_gia']);
                                                    }
                                                ?>
                                                    <!-- <h6>Giá chỉ từ: <?php echo $min_gia ?></h6> -->
                                                    <p style="font-size: 30px;color:green;font-weight:600"><?php echo $min_gia ?></p>
                                                <?php

                                                }
                                                ?>
                                                <a href="chitiet.php?tour_id=<?php echo $tour_id; ?>"><button>Tiếp</button></a>

                                            </div>
                                        </article>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">

                    </div>
                </div>
            </div>

        </div>
        <!-- hinh avatar-tim kiem -->

    </div>
    <?php
    include("../templates/footer.html")
    ?>
    </div>

    <script src="../js/search_voice.js"></script>
    <!-- chatbot fpt -->
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
    <!-- chatbot fpt -->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#xacnhan_submit").click(function() {
                var old_pass = $("#old_pass").val();
                var str = old_pass;
                $("#old").val(str);
            });
        });
    </script>
</body>

</html>
<?php
if (isset($_POST["voice_submit"])) {
    $giatrisearch = $_POST["content"];
    if (!empty($giatrisearch)) {
        header("location:voice_result.php?giatrisearch=$giatrisearch");
        ob_end_flush();
        exit();
    } else {
?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Vui lòng nói tên khu du lịch nào đó!'
            })
        </script>
<?php
    }
}
?>
<?php
if (isset($_POST["search_submit"])) {
    $tinh = $_POST["tinh"];
    // echo "<script>console.log($tinh)</script>";
    header("location:tour_search.php?tinh=$tinh");
    ob_end_flush();
    exit();
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
                        location.href = 'index.php';
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
<?php
if (isset($_POST["change_submit"])) {
    $old = md5($_POST['old']);
    $new_pass = md5($_POST['new_pass']);
    $repass = $_POST['repass'];
    $sql_pass = "SELECT`account_password` FROM `account` WHERE account_id='$account_id'";
    $result_pass = mysqli_query($conn, $sql_pass);
    if (mysqli_num_rows($result_pass) > 0) {
        while ($row_pass = mysqli_fetch_assoc($result_pass)) {
            $account_password = $row_pass['account_password'];
        }
        if ($account_password == $old) {
            $sql_change = "UPDATE `account` SET `account_password`='$new_pass' WHERE account_id='$account_id'";
            if (mysqli_query($conn, $sql_change)) {
?>
                <div class="flash-data" data-flashdata=1></div>
                <script>
                    const flashdata = $('.flash-data').data('flashdata')
                    if (flashdata) {
                        Swal.fire(
                            'Thành công!',
                            'Vui lòng tiến hành đăng nhập lại.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                location.href = '../templates/login.php';
                            }
                        })
                    }
                </script>
            <?php
            }
        } else {
            ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Mật khẩu không đúng',
                    text: 'Vui lòng kiểm tra và thử lại!',
                })
            </script>
<?php
        }
    }
}
?>