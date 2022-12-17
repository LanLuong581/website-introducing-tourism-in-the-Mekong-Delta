<?php
include('../config/constants.php');
session_start();
if (!isset($_SESSION['acc_account_loaitaikhoan']) || !isset($_SESSION["acc_email"])) {
    header("location:../templates/login.php");
} else {
    if ($_SESSION['acc_account_loaitaikhoan'] != 2) {
        header("location:../templates/login.php");
    }
    $account_email = $_SESSION["acc_email"];
    $sql_account = "SELECT account_id FROM account WHERE account_email='$account_email'";
    $result_account = mysqli_query($conn, $sql_account);
    if (mysqli_num_rows($result_account) > 0) {
        while ($row = mysqli_fetch_assoc($result_account)) {
            $account_id = $row['account_id'];
        }
        $sql_tour_id = "select tour_id from tour where account_id='$account_id'";
        $result_tour_id = mysqli_query($conn, $sql_tour_id);
        if (mysqli_num_rows($result_tour_id) > 0) {
            while ($row_tour = mysqli_fetch_assoc($result_tour_id)) {
                $tour_id = $row_tour['tour_id'];
            }
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
    <link rel="stylesheet" href="vivumekong8.css">
    <script src="../js/check_pw.js"></script>
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../jquery/jquery-3.6.0.min.js"></script>
    <script src="ckfinder/ckfinder.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
    <div class="wapper">
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
                                <a class="nav-link " aria-current="page" href="dh_homnay.php">Đơn Hàng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="thongke.php">Thống kê</a>
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
                                    <li data-bs-toggle="modal" data-bs-target="#doimatkhau"><a class="dropdown-item bi bi-person"> Đổi mật khẩu</a></li>
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
                        <!-- modal nhap mat khau cu -->
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
        <div class="main_content" style="background-color: #f8f9fa">
            <div class="row" style="margin: 0;">
                <div class="col-md-6">
                    <div class="bieudo">
                        <?php
                        // sql so don da xuat
                        $query = $conn->query("SELECT chitiet_tour.chitiet_ten,COUNT(booking.booking_id) as sodon
                        FROM (booking
                              INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                WHERE booking.tour_id='$tour_id' && booking.booking_trangthai='5'
                              GROUP BY booking.chitiet_tour_id
                           ");
                        foreach ($query as $data) {
                            $ten_chitiet[] = $data['chitiet_ten'];
                            $luongdon[] = $data['sodon'];
                        }
                        // sql so don bị khach hang huy
                        $khhuy = $conn->query("SELECT chitiet_tour.chitiet_ten,COUNT(booking.booking_id) as sodon
                        FROM (booking
                              INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                WHERE booking.tour_id='$tour_id' && booking.booking_trangthai='3'
                              GROUP BY booking.chitiet_tour_id
                           ");
                        if (mysqli_fetch_assoc($khhuy) > 0) {
                            foreach ($khhuy as $data_huy) {
                                // $ten_chitiet[] = $data_huy['chitiet_ten'];
                                $luongdonhuy[] = $data_huy['sodon'];
                            }
                        } else {
                            $luongdonhuy[] = [0, 0, 0, 0, 0];
                        }


                        // sql so don doanh nghiep tu choi
                        $tuchoi = $conn->query("SELECT chitiet_tour.chitiet_ten,COUNT(booking.booking_id) as sodon
                        FROM (booking
                              INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                WHERE booking.tour_id='$tour_id' && booking.booking_trangthai='2'
                              GROUP BY booking.chitiet_tour_id
                           ");
                        if (mysqli_fetch_assoc($tuchoi) > 0) {
                            foreach ($tuchoi as $data_tuchoi) {
                                // $ten_chitiet[] = $data_huy['chitiet_ten'];
                                $luongdontuchoi[] = $data_tuchoi['sodon'];
                            }
                        } else {
                            $luongdontuchoi[] = [0, 0, 0, 0, 0];
                        }
                        // end so don doanh nghiep tu choi
                        ?>
                        <h4>Biểu đồ thống kê số đơn hàng của từng dịch vụ</h4>
                        <div style="width:700px">
                            <canvas id="myChart"></canvas>
                        </div>
                        <script>
                            // === include 'setup' then 'config' above ===
                            const labels = <?php echo json_encode($ten_chitiet) ?>;
                            const data = {
                                labels: labels,
                                datasets: [{
                                    label: 'Số đơn đã xuất',
                                    data: <?php echo json_encode($luongdon) ?>,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgb(75, 192, 192)',
                                    borderWidth: 1
                                }, {
                                    label: 'Số đơn bị hủy',
                                    data: <?php echo json_encode($luongdonhuy) ?>,
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderColor: 'rgb(255, 99, 132)',
                                    borderWidth: 1
                                }, {
                                    label: 'Số đơn đã từ chối',
                                    data: <?php echo json_encode($luongdontuchoi) ?>,
                                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                    borderColor: 'rgb(255, 159, 64)',
                                    borderWidth: 1
                                }]
                            };

                            const config = {
                                type: 'bar',
                                data: data,
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                },
                            };
                            var myChart = new Chart(
                                document.getElementById('myChart'),
                                config
                            );
                        </script>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bieudo">
                        <?php
                        // sql so don da xuat
                        $query_thang_xuat = $conn->query("SELECT SUM(booking.booking_sl_nguoilon) as nguoilon,SUM(booking.booking_sl_treem) as treem, month(booking.booking_ngaysudung) as thang
                        FROM (booking
                              INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                WHERE booking.tour_id=$tour_id && booking.booking_trangthai='5'
                              GROUP BY month(booking.booking_ngaysudung)
                           ");
                        foreach ($query_thang_xuat as $data_thang_xuat) {
                            $nguoilon[] = $data_thang_xuat['nguoilon'];
                            $treem[] = $data_thang_xuat['treem'];
                            $thang[] = $data_thang_xuat['thang'];
                        }
                        // sql so don bị khach hang huy

                        ?>
                        <h4>Biểu đồ thống kê lượng khách hàng tháng</h4>
                        <div style="width:600px">
                            <canvas id="thang_chart"></canvas>
                        </div>
                        <script>
                            // === include 'setup' then 'config' above ===
                            const nhan = <?php echo json_encode($thang) ?>;
                            const dulieu = {
                                labels: nhan,
                                datasets: [{
                                    label: 'Khách người lớn',
                                    data: <?php echo json_encode($nguoilon) ?>,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgb(75, 192, 192)',
                                    borderWidth: 1
                                }, {
                                    label: 'Khách trẻ em',
                                    data: <?php echo json_encode($treem) ?>,
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderColor: 'rgb(255, 99, 132)',
                                    borderWidth: 1
                                }]
                            };

                            const bieudo = {
                                type: 'line',
                                data: dulieu,
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                },
                            };
                            var myChart = new Chart(
                                document.getElementById('thang_chart'),
                                bieudo
                            );
                        </script>

                    </div>
                </div>

            </div>
        <br>
        <br>
            <div class="row" style="margin:0">
                <!-- <div class="col-md-1">

                </div> -->
                <div class="col-md-12">
                    <!-- bang thong ke -->
                    <div class="thongke">
                        <form action="">
                            <!-- don da xuat -->
                            <div class="row">
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-10">
                                    <div class="theo_dichvu">
                                        <h4>Thống kê lượng khách và doanh thu đã xuất</h4>

                                        <table class="table" style=" border: 1px solid;text-align:left">
                                            <thead>
                                                <tr class="table-info">
                                                    <th>STT</th>
                                                    <th>Tên dịch vụ</th>
                                                    <th>Giá vé người lớn</th>
                                                    <th>Giá vé trẻ em</th>
                                                    <th>Số lượng người lớn</th>
                                                    <th>Số lượng trẻ em</th>
                                                    <th>Tổng thu</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $n = 1;
                                            $tong_nguoilon = 0;
                                            $tong_treem = 0;
                                            $tongcong = 0;
                                            $sql_chitiet_id = "SELECT DISTINCT booking.chitiet_tour_id,chitiet_tour.chitiet_ten,chitiet_tour.chitiet_gia_nguoilon,chitiet_tour.chitiet_gia_treem
                                        FROM (booking
                                              INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                              WHERE booking.tour_id='$tour_id'  && booking.booking_trangthai='5' ";
                                            $result = mysqli_query($conn, $sql_chitiet_id);
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($chitiet = mysqli_fetch_assoc($result)) {
                                                    $chitiet_tour_id = $chitiet['chitiet_tour_id'];
                                                    $chitiet_ten = $chitiet['chitiet_ten'];
                                                    $chitiet_gia_nguoilon = $chitiet['chitiet_gia_nguoilon'];
                                                    $chitiet_gia_treem = $chitiet['chitiet_gia_treem'];
                                                    $sql_sum = "SELECT SUM(booking.booking_sl_nguoilon) as slnguoilon,SUM(booking.booking_sl_treem) AS sltreem,SUM(booking.booking_tonggia) as tong
                                            FROM (booking
                                                  INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                                  WHERE booking.tour_id='$tour_id' && chitiet_tour.chitiet_tour_id='$chitiet_tour_id' && booking.booking_trangthai='5'";
                                                    $result_sum = mysqli_query($conn, $sql_sum);
                                                    if (mysqli_num_rows($result_sum) > 0) {
                                                        while ($sum = mysqli_fetch_assoc($result_sum)) {
                                                            $slnguoilon = $sum['slnguoilon'];
                                                            $sltreem = $sum['sltreem'];
                                                            $tong = $sum['tong'];
                                                        }
                                                        $tong_nguoilon = $tong_nguoilon + $slnguoilon;
                                                        $tong_treem = $tong_treem + $sltreem;
                                                        $tongcong = $tongcong + $tong;
                                            ?>
                                                        <tbody style="background-color: #fff;">
                                                            <tr>
                                                                <td><?php echo $n++ ?></td>
                                                                <td><?php echo $chitiet_ten ?></td>
                                                                <td><?php echo number_format($chitiet_gia_nguoilon)  ?></td>
                                                                <td><?php echo number_format($chitiet_gia_treem)  ?></td>
                                                                <td><?php echo $slnguoilon ?></td>
                                                                <td><?php echo $sltreem ?></td>
                                                                <td><?php echo number_format($tong) ?></td>
                                                            </tr>

                                                    <?php
                                                    }
                                                }
                                                    ?>
                                                    <tr style="font-weight: 500;">
                                                        <td colspan="4">Tổng cộng</td>
                                                        <td><?php echo $tong_nguoilon ?></td>
                                                        <td><?php echo $tong_treem ?></td>
                                                        <td><?php echo number_format($tongcong) ?></td>
                                                    </tr>
                                                        </tbody>
                                                    <?php
                                                } else {
                                                    ?>
                                                        <tbody>
                                                            <tr style="text-align: center;">
                                                                <td colspan="7">No data available in table</td>
                                                            </tr>
                                                        </tbody>
                                                    <?php
                                                }

                                                    ?>

                                        </table>
                                    </div>

                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>
                            <!-- don da bi huy -->
                            <div class="row" style="margin: 0;">
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-10">
                                    <div class="theo_dichvu">
                                        <h4>Thống kê số lượng khách và doanh thu đã bị hủy</h4>

                                        <table class="table" style=" border: 1px solid;text-align:left">
                                            <thead>
                                                <tr class="table-danger">
                                                    <th>STT</th>
                                                    <th>Tên dịch vụ</th>
                                                    <th>Giá vé người lớn</th>
                                                    <th>Giá vé trẻ em</th>
                                                    <th>Số lượng người lớn</th>
                                                    <th>Số lượng trẻ em</th>
                                                    <th>Tổng thiệt hại</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $n = 1;
                                            $tong_nguoilon = 0;
                                            $tong_treem = 0;
                                            $tongcong = 0;
                                            $sql_chitiet_id = "SELECT DISTINCT booking.chitiet_tour_id,chitiet_tour.chitiet_ten,chitiet_tour.chitiet_gia_nguoilon,chitiet_tour.chitiet_gia_treem
                                        FROM (booking
                                              INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                              WHERE booking.tour_id='$tour_id'  && booking.booking_trangthai='3' ";
                                            $result = mysqli_query($conn, $sql_chitiet_id);
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($chitiet = mysqli_fetch_assoc($result)) {
                                                    $chitiet_tour_id = $chitiet['chitiet_tour_id'];
                                                    $chitiet_ten = $chitiet['chitiet_ten'];
                                                    $chitiet_gia_nguoilon = $chitiet['chitiet_gia_nguoilon'];
                                                    $chitiet_gia_treem = $chitiet['chitiet_gia_treem'];
                                                    $sql_sum = "SELECT SUM(booking.booking_sl_nguoilon) as slnguoilon,SUM(booking.booking_sl_treem) AS sltreem,SUM(booking.booking_tonggia) as tong
                                            FROM (booking
                                                  INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                                  WHERE booking.tour_id='$tour_id' && chitiet_tour.chitiet_tour_id='$chitiet_tour_id' && booking.booking_trangthai='3'";
                                                    $result_sum = mysqli_query($conn, $sql_sum);
                                                    if (mysqli_num_rows($result_sum) > 0) {
                                                        while ($sum = mysqli_fetch_assoc($result_sum)) {
                                                            $slnguoilon = $sum['slnguoilon'];
                                                            $sltreem = $sum['sltreem'];
                                                            $tong = $sum['tong'];
                                                        }
                                                        $tong_nguoilon = $tong_nguoilon + $slnguoilon;
                                                        $tong_treem = $tong_treem + $sltreem;
                                                        $tongcong = $tongcong + $tong;
                                            ?>
                                                        <tbody style="background-color: #fff;">
                                                            <tr>
                                                                <td><?php echo $n++ ?></td>
                                                                <td><?php echo $chitiet_ten ?></td>
                                                                <td><?php echo number_format($chitiet_gia_nguoilon)  ?></td>
                                                                <td><?php echo number_format($chitiet_gia_treem)  ?></td>
                                                                <td><?php echo $slnguoilon ?></td>
                                                                <td><?php echo $sltreem ?></td>
                                                                <td><?php echo number_format($tong) ?></td>
                                                            </tr>

                                                    <?php
                                                    }
                                                }
                                                    ?>
                                                    <tr style="font-weight: 500;">
                                                        <td colspan="4">Tổng cộng</td>
                                                        <td><?php echo $tong_nguoilon ?></td>
                                                        <td><?php echo $tong_treem ?></td>
                                                        <td><?php echo number_format($tongcong) ?></td>
                                                    </tr>
                                                        </tbody>
                                                    <?php
                                                } else {
                                                    ?>
                                                        <tbody>
                                                            <tr style="text-align: center;">
                                                                <td colspan="7">No data available in table</td>
                                                            </tr>
                                                        </tbody>
                                                    <?php
                                                }

                                                    ?>

                                        </table>
                                    </div>

                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>

                            <!-- don da tu choi -->
                            <div class="row">
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-10">
                                    <div class="theo_dichvu">
                                        <h4>Thống kê số lượng khách và doanh thu đã từ chối</h4>

                                        <table class="table" style=" border: 1px solid;text-align:left">
                                            <thead>
                                                <tr class="table-warning">
                                                    <th>STT</th>
                                                    <th>Tên dịch vụ</th>
                                                    <th>Giá vé người lớn</th>
                                                    <th>Giá vé trẻ em</th>
                                                    <th>Số lượng người lớn</th>
                                                    <th>Số lượng trẻ em</th>
                                                    <th>Tổng thiệt hại</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $n = 1;
                                            $tong_nguoilon = 0;
                                            $tong_treem = 0;
                                            $tongcong = 0;
                                            $sql_chitiet_id = "SELECT DISTINCT booking.chitiet_tour_id,chitiet_tour.chitiet_ten,chitiet_tour.chitiet_gia_nguoilon,chitiet_tour.chitiet_gia_treem
                                        FROM (booking
                                              INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                              WHERE booking.tour_id='$tour_id'  && booking.booking_trangthai='2' ";
                                            $result = mysqli_query($conn, $sql_chitiet_id);
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($chitiet = mysqli_fetch_assoc($result)) {
                                                    $chitiet_tour_id = $chitiet['chitiet_tour_id'];
                                                    $chitiet_ten = $chitiet['chitiet_ten'];
                                                    $chitiet_gia_nguoilon = $chitiet['chitiet_gia_nguoilon'];
                                                    $chitiet_gia_treem = $chitiet['chitiet_gia_treem'];
                                                    $sql_sum = "SELECT SUM(booking.booking_sl_nguoilon) as slnguoilon,SUM(booking.booking_sl_treem) AS sltreem,SUM(booking.booking_tonggia) as tong
                                            FROM (booking
                                                  INNER JOIN chitiet_tour ON chitiet_tour.chitiet_tour_id=booking.chitiet_tour_id)
                                                  WHERE booking.tour_id='$tour_id' && chitiet_tour.chitiet_tour_id='$chitiet_tour_id' && booking.booking_trangthai='2'";
                                                    $result_sum = mysqli_query($conn, $sql_sum);
                                                    if (mysqli_num_rows($result_sum) > 0) {
                                                        while ($sum = mysqli_fetch_assoc($result_sum)) {
                                                            $slnguoilon = $sum['slnguoilon'];
                                                            $sltreem = $sum['sltreem'];
                                                            $tong = $sum['tong'];
                                                        }
                                                        $tong_nguoilon = $tong_nguoilon + $slnguoilon;
                                                        $tong_treem = $tong_treem + $sltreem;
                                                        $tongcong = $tongcong + $tong;
                                            ?>
                                                        <tbody style="background-color: #fff;">
                                                            <tr>
                                                                <td><?php echo $n++ ?></td>
                                                                <td><?php echo $chitiet_ten ?></td>
                                                                <td><?php echo number_format($chitiet_gia_nguoilon)  ?></td>
                                                                <td><?php echo number_format($chitiet_gia_treem)  ?></td>
                                                                <td><?php echo $slnguoilon ?></td>
                                                                <td><?php echo $sltreem ?></td>
                                                                <td><?php echo number_format($tong) ?></td>
                                                            </tr>

                                                    <?php
                                                    }
                                                }
                                                    ?>
                                                    <tr style="font-weight: 500;">
                                                        <td colspan="4">Tổng cộng</td>
                                                        <td><?php echo $tong_nguoilon ?></td>
                                                        <td><?php echo $tong_treem ?></td>
                                                        <td><?php echo number_format($tongcong) ?></td>
                                                    </tr>
                                                        </tbody>
                                                    <?php
                                                } else {
                                                    ?>
                                                        <tbody>
                                                            <tr style="text-align: center;">
                                                                <td colspan="7">No data available in table</td>
                                                            </tr>
                                                        </tbody>
                                                    <?php
                                                }

                                                    ?>

                                        </table>
                                    </div>

                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end bang thong ke -->
                </div>
                <!-- <div class="col-md-1">

                </div> -->
            </div>

        </div>
    </div>

    <?php
    include("../templates/footer.html")
    ?>
    </div>
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