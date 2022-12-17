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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <form action="">
                <div class="col-md-12">
                    <div class="row" style="margin:0;padding-top:20px ">
                        <div class="col-md-2">

                        </div>
                        <div class="col-md-8" style="padding:0;">
                            <div class="row" style="margin: 0; padding-top:10px">
                                <br>

                                <h4 style="text-align: center;"> <b> Biểu đồ thống kê lượng đơn hàng của doanh nghiệp</b></h4>
                                <?php
                                $query = $conn->query("SELECT tour.tour_ten, COUNT(booking.booking_id) AS tongdon
                                FROM (booking
                                      INNER JOIN tour ON tour.tour_id=booking.tour_id)
                                      WHERE NOT booking.booking_trangthai='5'
                                      GROUP by tour.tour_id");
                                foreach ($query as $data) {
                                    $tentour[] = $data['tour_ten'];
                                    $tongdon[] = $data['tongdon'];
                                }
                                // tong don tu choi
                                $query_tuchoi = $conn->query("SELECT tour.tour_ten, COUNT(booking.booking_id) AS tongdon
                                FROM (booking
                                      INNER JOIN tour ON tour.tour_id=booking.tour_id)
                                      WHERE NOT booking.booking_trangthai='2'
                                      GROUP by tour.tour_id");
                                foreach ($query_tuchoi as $data_tuchoi) {
                                    // $tentour[] = $data_tuchoi['tour_ten'];
                                    $tongdon_tuchoi[] = $data_tuchoi['tongdon'];
                                }
                                // tong don khach hang huy
                                $query_khhuy = $conn->query("SELECT tour.tour_ten, COUNT(booking.booking_id) AS tongdon
                                        FROM (booking
                                              INNER JOIN tour ON tour.tour_id=booking.tour_id)
                                              WHERE NOT booking.booking_trangthai='3'
                                              GROUP by tour.tour_id");
                                foreach ($query_khhuy as $data_khhuy) {
                                    // $tentour[] = $data_tuchoi['tour_ten'];
                                    $tongdon_khhuy[] = $data_khhuy['tongdon'];
                                }
                                ?>
                                <div style="width: 900px;">
                                    <canvas id="myChart"></canvas>
                                </div>
                                <script>
                                    const labels = <?php echo json_encode($tentour) ?>;
                                    const data = {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Tổng số đơn hàng đã xuất',
                                            data: <?php echo json_encode($tongdon) ?>,
                                            backgroundColor: [
                                                'rgba(75, 192, 192, 0.2)',

                                            ],
                                            borderColor: [

                                                'rgb(75, 192, 192)',

                                            ],
                                            borderWidth: 1
                                        }, {
                                            label: 'Tổng số đơn đã từ chối',
                                            data: <?php echo json_encode($tongdon_tuchoi) ?>,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.2)',

                                            ],
                                            borderColor: [

                                                'rgb(255, 99, 132)',

                                            ],
                                            borderWidth: 1
                                        }, {
                                            label: 'Tổng số đơn khách hàng hủy',
                                            data: <?php echo json_encode($tongdon_khhuy) ?>,
                                            backgroundColor: [

                                                'rgba(255, 159, 64, 0.2)',
                                            ],
                                            borderColor: [

                                                'rgb(255, 159, 64)',
                                            ],
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

                                    // === include 'setup' then 'config' above ===

                                    var myChart = new Chart(
                                        document.getElementById('myChart'),
                                        config
                                    );
                                </script>


                            </div>
                        </div>

                        <br>
                        <br>
                        <br>
                        <br>

                        <div class="col-md-2"></div>
                        <br>

                        <div class="row" style="margin:0;padding-top:50px">
                            <br>
                            <h4 style="text-align: center;"><b>Danh sách doanh nghiệp</b> </h4>
                            <?php
                            // $student_id = $_SESSION["acc_student_id"];
                            $sn = 1;
                            $sql = "SELECT tour.tour_id,tour.account_id,tour.tour_ten,loai_tour.loaitour_ten,tour_dienthoai,account.account_email
                                ,province._name as province_name,district._name as district_name,ward._name as ward_name,tour.tour_diachi,tour.tour_ngaytao,account.daily_trangthai
                                FROM ((((( tour
                                INNER JOIN loai_tour ON loai_tour.loaitour_id=tour.loaitour_id)
                                INNER JOIN province ON province.id=tour.tinh_id)
                                INNER JOIN account ON account.account_id=tour.account_id)
                                INNER JOIN district ON district.id=tour.huyen_id)
                                INNER JOIN ward ON ward.id=tour.xa_id) ORDER BY tour.tour_id DESC";

                            $result = mysqli_query($conn, $sql);
                            ?>
                            <table class="table " id="doanhnghiep">
                                <thead>
                                    <tr class="table-success">
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>Tên Doanh Nghiệp</th>
                                        <th>Loại Hình</th>
                                        <th>Điện Thoại</th>
                                        <th>Email</th>
                                        <th>Tỉnh</th>
                                        <th>Huyện</th>
                                        <th>Xã</th>
                                        <th>Địa Chỉ</th>
                                        <th>Ngày Tạo</th>
                                        <th>Trạng Thái</th>
                                        <th>Tác Vụ</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color: #fff;">
                                    <?php
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                <td><?php echo $sn++ ?></td>
                                                <td><?php echo $row['tour_id'] ?></td>
                                                <td><a href="hoatdong.php?tour_id=<?php echo $row['tour_id'] ?>" style="text-decoration: none;color:#22577a;font-weight:600"><?php echo $row['tour_ten'] ?></a></td>
                                                <td><?php echo $row['loaitour_ten'] ?></td>
                                                <td><?php echo $row['tour_dienthoai'] ?></td>
                                                <td><?php echo $row['account_email'] ?></td>
                                                <td><?php echo $row['province_name'] ?></td>
                                                <td><?php echo $row['district_name'] ?></td>
                                                <td><?php echo $row['ward_name'] ?></td>
                                                <td><?php echo $row['tour_diachi'] ?></td>
                                                <!-- <td><?php echo $row['tour_ngaytao'] ?></td> -->
                                                <td><?php echo date('d/m/Y', strtotime( $row['tour_ngaytao'])) ?></td>
                                                <td>
                                                    <?php if ($row['daily_trangthai'] == 0) : ?>
                                                        <span class="badge bg-warning">Chưa duyệt</span>
                                                    <?php elseif ($row['daily_trangthai'] == 1) : ?>
                                                        <span class="badge bg-success">Đã duyệt</span>
                                                    <?php elseif ($row['daily_trangthai'] == 2) : ?>
                                                        <span class="badge bg-danger">Từ chối</span>
                                                    <?php elseif ($row['daily_trangthai'] == 3) : ?>
                                                        <span class="badge bg-danger">Tạm đóng</span>
                                                    <?php endif; ?>
                                                </td>

                                                <td class="del_edit">
                                                    <?php if ($row['daily_trangthai'] == 0) : ?>
                                                        <a class="duyet" href="duyet_doanhnghiep.php?account_id=<?php echo $row['account_id'] ?>"><button type="button" class="bi bi-check-circle" style="border:0px;font-size:20px; color:green" title="Duyệt"></button></a>
                                                        <a class="tu_choi" href="tuchoi.php?account_id=<?php echo $row['account_id'] ?>"><button type="button" class="bi bi-x-circle" style="border:0px;font-size:20px; color:red" title="Từ chối"></button></a>
                                                    <?php elseif ($row['daily_trangthai'] == 1) : ?>
                                                        <a class="dong_tk" href="dongtaikhoan.php?account_id=<?php echo $row['account_id'] ?>"><button type="button" class="bi bi-person-x" style="border:0px;font-size:20px; color:green" title="Đóng tài khoản"></button></a>
                                                        <a class="xoa" href="xoa_doanhnghiep.php?account_id=<?php echo $row['account_id'] ?>"><button type="button" class="bi bi-trash" style="border:0px;font-size:20px; color:red" title="Xóa tài khoản"></button></a>

                                                    <?php elseif ($row['daily_trangthai'] == 2) : ?>
                                                        <a class="duyet" href="duyet_doanhnghiep.php?account_id=<?php echo $row['account_id'] ?>"><button type="button" class="bi bi-check-circle" style="border:0px;font-size:20px; color:green" title="Duyệt"></button></a>
                                                        <a class="xoa" href="xoa_doanhnghiep.php?account_id=<?php echo $row['account_id'] ?>"><button type="button" class="bi bi-trash" style="border:0px;font-size:20px; color:red" title="Xóa tài khoản"></button></a>

                                                    <?php elseif ($row['daily_trangthai'] == 3) : ?>
                                                        <a class="mo_tk" href="motaikhoan.php?account_id=<?php echo $row['account_id'] ?>"><button type="button" class="bi bi-arrow-return-left" style="border:0px;font-size:20px; color:green" title="Mở tài khoản"></button></a>
                                                        <a class="xoa" href="xoa_doanhnghiep.php?account_id=<?php echo $row['account_id'] ?>"><button type="button" class="bi bi-trash" style="border:0px;font-size:20px; color:red" title="Xóa tài khoản"></button></a>

                                                    <?php endif; ?>

                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "Chưa có dữ liệu";
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                        <!-- <div class="col-md-1">

                        </div> -->
                    </div>
                </div>

            </form>
            <div class="row">
                <div class="col-md-6">
                    <h5>Danh sách loại hình doanh nghiệp</h5>
                    <form action="" method="post">
                        <div class="row g-2">
                            <div class="col-auto">
                                <input type="text" id="loaitour_ten" name="loaitour_ten" class="form-control">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-success" name="add_loaitour">Thêm</button>
                            </div>
                        </div>

                    </form>
                    <?php
                    $sql_loaihinh = "select * from loai_tour";
                    $result_loaitour = mysqli_query($conn, $sql_loaihinh);
                    ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên loại hình doanh nghiệp</th>
                                <th>Trạng thái</th>
                                <th>Tác vụ</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            $n = 0;
                            if (mysqli_num_rows($result_loaitour) > 0) {
                                while ($loaitour = mysqli_fetch_assoc($result_loaitour)) {
                                    $loaitour_id = $loaitour['loaitour_id'];
                                    $loaitour_ten = $loaitour['loaitour_ten'];
                                    $loaitour_trangthai = $loaitour['loaitour_trangthai'];
                            ?>

                                    <tr>
                                        <td><?php echo $n++ ?></td>
                                        <td><?php echo $loaitour_ten ?></td>
                                        <td><?php if ($loaitour_trangthai == 1) {
                                            ?> <span class="badge bg-success">Hoạt động</span>
                                            <?php
                                            } else {
                                            ?>
                                                <span class="badge bg-danger">Tạm đóng</span>

                                            <?php
                                            } ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit_loaitour<?php echo $loaitour_id ?>">
                                                Sửa
                                            </button>
                                            <?php if ($loaitour_trangthai == 0) : ?>
                                                <a class="mo_loaitour" href="mo_loaitour.php?loaitour_id=<?php echo $loaitour_id ?>"><button type="button" class="btn btn-success">Mở</button></a>
                                            <?php elseif ($loaitour_trangthai == 1) : ?>
                                                <a class="dong_loaitour" href="dong_loaitour.php?loaitour_id=<?php echo $loaitour_id ?>"><button type="button" class="btn btn-danger">Đóng</button></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="edit_loaitour<?php echo $loaitour_id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="" method="post">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Sửa loại hình doanh nghiệp</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <?php
                                                    $sql_sua = "SELECT `loaitour_ten` FROM `loai_tour` WHERE loaitour_id='$loaitour_id'";
                                                    $result_sua = mysqli_query($conn, $sql_sua);
                                                    if (mysqli_num_rows($result_sua) > 0) {
                                                        while ($sua = mysqli_fetch_assoc($result_sua)) {
                                                            $loaitour_ten_sua = $sua['loaitour_ten'];
                                                        }
                                                    }
                                                    ?>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="loaitour_id_sua" value="<?php echo $loaitour_id ?>">
                                                        <input type="text" name="loaitour_ten_sua" class="form-control" value="<?php echo $loaitour_ten_sua ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                        <button type="submit" class="btn button_submit" name="edit_loaitour">Lưu</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- end modal -->

                            <?php
                                }
                            }

                            ?>
                        </tbody>
                    </table>
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
        $('#doanhnghiep').DataTable({
            "pageLength": 5,
            "lengthMenu": [5, 10, 20, 30, 50]

        });
    </script>
</body>
<?php if (isset($_GET['a'])) : ?>
    <div class="da-duyet" data-flashdata="<?= $_GET['a'] ?>"></div>
<?php endif; ?>

<!--duyet-->
<script>
    $('.duyet').on('click', function(e) {
        e.preventDefault();
        var self = $(this);
        console.log(self.data('title'));
        Swal.fire({
            title: 'Bạn có chắc muốn duyệt doanh nghiệp này?',
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
    const duyet = $('.da-duyet').data('duyet')
    if (duyet) {
        Swal.fire(
            'Đã duyệt!',
            'Doanh nghiệp đã được duyệt.',
            'success'
        )
    }
</script>
<!-- end duyet-->

</html>
<!--xoa-->

<script>
    $('.xoa').on('click', function(e) {
        e.preventDefault();
        var self = $(this);
        console.log(self.data('title'));
        Swal.fire({
            title: 'Bạn có chắc muốn xóa doanh nghiệp này?',
            text: "Mọi thông tin liên quan đến doanh nghiệp cũng sẽ bị xóa",
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
    const xoa = $('.flash-data').data('xoa')
    if (xoa) {
        Swal.fire(
            'Đã duyệt!',
            'Doanh nghiệp đã được xóa.',
            'success'
        )
    }
</script>


<!-- tu choi don -->
<script>
    $('.tu_choi').on('click', function(e) {
        e.preventDefault();
        var self = $(this);
        console.log(self.data('title'));
        Swal.fire({
            title: 'Bạn có chắc muốn từ chối doanh nghiệp này?',
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
    const tuchoi = $('.flash-data').data('tuchoi')
    if (tuchoi) {
        Swal.fire(
            'Đã từ chối!',
            'doanh nghiệp này này đã bị từ chối.',
            'success'
        )
    }
</script>
<!-- end tu choi don -->

<!-- đóng tài khoản -->
<script>
    $('.dong_tk').on('click', function(e) {
        e.preventDefault();
        var self = $(this);
        console.log(self.data('title'));
        Swal.fire({
            title: 'Bạn có chắc muốn đóng tài khoản này?',
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
    const dong_tk = $('.dong_tk').data('dong_tk')
    if (dong_tk) {
        Swal.fire(
            'Đã đóng!',
            'tài khoản doanh nghiệp này đã bị đóng.',
            'success'
        )
    }
</script>
<!-- đóng tài khoản -->

<!-- đóng tài khoản -->
<script>
    $('.mo_tk').on('click', function(e) {
        e.preventDefault();
        var self = $(this);
        console.log(self.data('title'));
        Swal.fire({
            title: 'Bạn có chắc muốn mở tài khoản này?',
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
    const mo_tk = $('.mo_tk').data('mo_tk')
    if (mo_tk) {
        Swal.fire(
            'Đã mở!',
            'tài khoản doanh nghiệp này đã được mở.',
            'success'
        )
    }
</script>
<!-- đóng tài khoản -->
<!-- đóng loại tài khoản -->
<script>
    $('.dong_loaitour').on('click', function(e) {
        e.preventDefault();
        var self = $(this);
        console.log(self.data('title'));
        Swal.fire({
            title: 'Bạn có chắc muốn đóng loại hình này này?',
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
    const dong_loaitour = $('.dong_loaitour').data('dong_loaitour')
    if (dong_loaitour) {
        Swal.fire(
            'Đã đóng!',
            'loại hình này đã được mở.',
            'success'
        )
    }
</script>
<!-- end đóng loại tài khoản -->
<!-- mở loại tài khoản -->
<script>
    $('.mo_loaitour').on('click', function(e) {
        e.preventDefault();
        var self = $(this);
        console.log(self.data('title'));
        Swal.fire({
            title: 'Bạn có chắc muốn mở loại hình này này?',
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
    const mo_loaitour = $('.mo_loaitour').data('dong_lmo_loaitouroaitour')
    if (mo_loaitour) {
        Swal.fire(
            'Đã đóng!',
            'loại hình này đã được mở.',
            'success'
        )
    }
</script>
<!-- end mở loại tài khoản -->
<!-- cập nhật thông tin cá nhân admin -->
<?php
if (isset($_POST["update_submit"])) {
    // echo"<script>console.log('clicked')</script>";
    $admin_id = $_POST['update_admin_id'];
    $admin_ho = $_POST['update_admin_ho'];
    $admin_ten = $_POST['update_admin_ten'];
    $admin_dienthoai = $_POST['update_admin_dienthoai'];
    $admin_ngaysinh = $_POST['update_admin_ngaysinh'];
    $tinh_id = $_POST['update_tinh_id'];
    $huyen_id = $_POST['update_huyen_id'];
    $xa_id = $_POST['update_xa_id'];
    $admin_diachi = $_POST['update_admin_diachi'];
    $sql_update_info = "UPDATE `admin` SET `admin_ten`='$admin_ten',`admin_ho`='$admin_ho',`admin_diachi`='$admin_diachi',
    `admin_ngaysinh`='$admin_ngaysinh',`admin_dienthoai`='$admin_dienthoai',`tinh_id`='$tinh_id',`huyen_id`='$huyen_id',`xa_id`='$xa_id' 
    WHERE admin_id='$admin_id'";
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
                        location.href = 'doanhnghiep.php';
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
<!-- end cập nhật thông tin cá nhân admin -->
<!-- them loaitour -->
<?php
if (isset($_POST['add_loaitour'])) {
    $tenloaitour = $_POST['loaitour_ten'];
    $sql_addloaitour = "INSERT INTO `loai_tour`(`loaitour_ten`, `loaitour_trangthai`) VALUES ('$tenloaitour','1')";
    if (mysqli_query($conn, $sql_addloaitour)) {
?>

        <div class="flash-data" data-flashdata=1></div>
        <script>
            const flashdata = $('.flash-data').data('flashdata')
            if (flashdata) {
                Swal.fire(
                    'Thành công!',
                    'Thêm loại hình doanh nghiệp thành công.',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        location.href = 'doanhnghiep.php';
                    }
                })
            }
        </script>
<?php
    } else { {
            echo "<script>console.log('error')</script>";
        }
    }
}
?>
<!-- end them loai tour -->
<!-- sua loaitour -->
<?php
if (isset($_POST['edit_loaitour'])) {
    $loaitour_ten_sua = $_POST['loaitour_ten_sua'];
    $loaitour_id_sua = $_POST['loaitour_id_sua'];
    $sql_edit = "UPDATE `loai_tour` SET`loaitour_ten`='$loaitour_ten_sua' WHERE loaitour_id='$loaitour_id_sua'";
    if (mysqli_query($conn, $sql_edit)) {
?>

        <div class="flash-data" data-flashdata=1></div>
        <script>
            const flashdata = $('.flash-data').data('flashdata')
            if (flashdata) {
                Swal.fire(
                    'Thành công!',
                    'Đã cập nhật tên loại hình doanh nghiệp.',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        location.href = 'doanhnghiep.php';
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
<!-- end sua loai tour -->