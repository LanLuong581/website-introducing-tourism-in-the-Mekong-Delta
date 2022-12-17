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
                                <a class="nav-link active" aria-current="page" href="dichvu.php">Dịch Vụ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="dh_homnay.php">Đơn Hàng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="thongke.php">Thống Kê</a>
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
                                    <li data-bs-toggle="modal" data-bs-target="#doimatkhau"><a class="dropdown-item bi bi-lock-fill"> Đổi mật khẩu</a></li>
                                    <li data-bs-toggle="modal" data-bs-target="#hdsd"><a class="dropdown-item bi bi-journal-text"> Hướng dẫn</a></li>
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
                         <!-- modal huong dan su dung -->
                         <div class="modal fade" id="hdsd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header" style="background: #2d7d90;color:#fff">
                                        <h5 class="modal-title" id="exampleModalLabel">Hướng dẫn sử dụng</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h4>Chào mừng bạn trở thành đối tác của ViVuMekong</h4>
                                        <h5>Sau đây là các hướng dẫn để bạn sử dụng tài khoản doanh nghiệp một cách tối ưu nhất</h5>
                                        <p><b>Giới thiệu: </b> Đây là mục đầu tiên bạn bắt buộc phải điền để doanh nghiệp của bạn có thể xuất hiện trên website. Một phần giới thiệu sinh động 
                                    và ấn tượng sẽ tăng phần thu hút khách hàng sử dụng các dịch vụ tại KDL của bạn. <br> - Phần giới thiệu cần bao gồm tiêu đề (thông thường là tên doanh nghiệp)
                                     và nội dung (giới thiệu các nét đặc sắc của KDL kèm hình ảnh minh họa) <br>
                                    - Chiều rộng của hình ảnh minh họa nên nhỏ hơn 1240px để đảm bảo khung nhìn được tốt nhất <br>
                                - Bạn hoàn toàn có thể cập nhật nội dung của phần giới thiệu bất kỳ lúc nào</p>
                                <p><b>Dịch vụ:</b> Đây là mục thứ 2 bạn bắt buộc phải thêm <br>
                            - Khi nhấn nút "Thêm Dịch Vụ" một form điền sẽ hiện ra, tại đây bạn bắt đầu điền đầy đủ các thông tin theo yêu cầu và ấn xác nhận "Thêm Dịch Vụ" <br>
                        - Khi đã thêm, bạn có thể sửa thông tin về dịch vụ đó hoặc đóng dịch vụ <br> 
                    - Khi dịch vụ ở trạng thái đóng, người dùng không thể nhìn thấy dịch vụ đó của bạn <br>
                - Để mở lại dịch vụ, bạn chỉ cần nhấn vào nút "Mở"</p>
                <p><b>Đơn hàng:</b> Tại đây bạn có thể xem tất cả các đơn hàng theo từng mục riêng biệt <br>
            - Đơn hàng đã duyệt: Mục này sẽ bao gồm 3 mục nhỏ gồm "Đơn Hàng Hôm Nay" chứa các đơn hàng đã được duyệt và có ngày sử dụng là ngày hiện tại, "Doanh Thu Hôm Nay" là tổng hợp doanh thu 
        của các đơn hàng đã được xuất trong hôm nay, "Đơn Hàng Sắp Tới" chứa các đơn hàng đã được duyệt và có ngày sử dụng từ ngày mai <br>
    - Đơn hàng đã xuất: Mục này chứa danh sách các đơn hàng đã được xuất <br>
- Đơn hàng chưa xử lý: Chứa danh sách các đơn hàng mới đang chờ được xử lý, bạn có thể "Duyệt" hoặc "Từ Chối" đơn đặt dịch vụ <br>
- Đơn hàng đã từ chối: Chứa danh sách các đơn hàng đã bị từ chối <br>
- Đơn hàng bị hủy: Chứa danh sách các đơn hàng mà khách hàng sau khi đặt đã hủy <br>
Tất cả đơn hàng: Chứa danh sách đơn hàng ở tất cả các trạng thái, bạn có thể tìm các đơn bị sót tại đây</p>
<p><b>Thống kê:</b> Đây là nơi bạn có thể xem doanh thu tăng trưởng của doanh nghiệp <br>
- Biểu đồ thống kê số đơn hàng của từng dịch vụ: Bạn có thể xem và so sánh giữa lượng đơn đã xuất, đã từ chối và bị hủy của từng dịch vụ nhằm đưa ra chiến lược phù hợp <br>
- Biểu đồ thống kê lượng khách hàng tháng: Khách hàng bao gồm người lớn và trẻ em, bạn có thể so sánh số lượng theo tháng từ đó đưa ra dịch vụ đặc biệt cho từng đối tượng khách hàng <br>
- Ngoài ra, bạn có thể xem lượng khách và doanh thu cũng như thiệt hại của từng dịch vụ. <br>
</p>
<p><b>Tài khoản:</b> Bạn có thể xem thông tin về doanh nghiệp mình và cập nhật chúng, bên cạnh đó là chức năng đổi mật khẩu và đăng xuất</p>
<p>Trên đây là toàn bộ hướng dẫn để sử dụng website "ViVuMekong", nếu còn bất kỳ vấn đề nào thắc mắc, bạn vui lòng liên hệ trực tiếp quản trị viên theo số điện thoại cuối trang để được giải đáp <br>
"ViVuMeKong" chúc quý đối tác ngày càng phát triển và thịnh vượng <br>
Xin chân thành cảm ơn quý đối tác đã tin tưởng và hợp tác.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal huong dan su dung -->
                    </div>
                </div>
            </nav>
        </div>
        <div class="main-content">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row" style="margin: 0;">
                <div class="col-md-1">

                </div>
                <div class="col-md-10" style="background-color:#fff;margin-top:50px">
                <div class="dichvu" style="margin: 0;">
                <!-- <form action="" method="POST"> -->
                <!-- <div class="col-md-12"> -->
                <div class="row content" style="margin: 0;">
                    <div class="col-md-12">
                        <div class="col-md-1">

                        </div>
                        <div class="col-md-10">
                            <div class="them-btn">
                                <button type="button" class="btn button_submit" style="width:136px" data-bs-toggle="modal" data-bs-target="#them_dichvu">Thêm Dịch Vụ</button>
                            </div>
                        </div>
                        <!-- Modal them dich vu -->
                        <div class="modal fade" id="them_dichvu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content bg-modal">
                                    <div class="modal-header" style="background: #2d7d90;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="font-size:30px;color:#fff">Thêm dịch vụ</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="main-form" action="" method="POST" enctype="multipart/form-data">
                                            <div class="col-md-12">
                                                <div col-md-12>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="chitiet_ten" class="form-label required">Tên dịch vụ</label>
                                                                <input class="form-control" type="text" name="chitiet_ten" id="chitiet_ten" required>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="chitiet_avt" class="form-label required">Ảnh đại diện</label>
                                                                <input class="form-control" type="file" name="chitiet_avt" id="chitiet_avt" required>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="chitiet_gioithieu" class="form-label required">Giới thiệu</label>
                                                                <textarea required class="form-control" name="chitiet_gioithieu" id="chitiet_gioithieu" rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col md 6">
                                                                <label for="chitiet_gia_nguoilon" class="form-label required">Giá người lớn</label>
                                                                <input class="form-control" type="number" name="chitiet_gia_nguoilon" id="chitiet_gia_nguoilon" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                            <label for="chitiet_gia_treem" class="form-label required">Giá trẻ em</label>
                                                                <input class="form-control" type="number" name="chitiet_gia_treem" id="chitiet_gia_treem" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" name="chitiet_them" id="chitiet_them" class="btn button_submit" style="width: 120px;" value="Thêm dịch vụ">
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">

                        </div>
                    </div>

                </div>
                <br>
                <?php
                $sql_chitiet_tour = "SELECT * FROM `chitiet_tour` WHERE `tour_id`='$tour_id'";
                $result_chitiet = mysqli_query($conn, $sql_chitiet_tour);
                function currency_format($number, $suffix = ' VND')
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
                        <div class="row content" style="margin:0px;background: #eef4ed;padding:10px">
                            <div class="col-md-12">
                                <div class="row" style="margin:0">
                                    <div class="col-md-3 avt">
                                        <!-- hinh dai dien -->
                                        <img src="../image/<?= $chitiet_avt; ?>" alt="<?= $chitiet_avt; ?>" srcset="" width="300px" height="200px" style="border-radius:3px ;">
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
                                            <span style="font-size: 25px;color:green;"><?php echo $chitiet_gia_nguoilon ?></span>
                                            
                                        </div>
                                        <div class="row" style="display: inline;padding-left:20px">
                                            <button type="button" class="btn button_submit" data-bs-toggle="modal" data-bs-target="#edit<?php echo $chitiet_tour_id ?>" title="Cập nhật dịch vụ" style="width: 66px;">Sửa</button>
                                            <?php
                                            if ($chitiet_trangthai == 1) {
                                            ?>

                                                <a class="close" href="close_dv.php?chitiet_tour_id=<?php echo $chitiet_tour_id ?>" ><button type="button" class="btn button_submit" style="width: 66px;background-color:#df2935;">Đóng</button></a>

                                            <?php
                                            } else {
                                            ?>
                                                <a class="open" href="open_dv.php?chitiet_tour_id=<?php echo $chitiet_tour_id ?>"><button type="button" class="btn button_submit" style="width: 66px;background-color:#ffa62b;">Mở</button></a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <!-- Modal update dich vu -->
                                        <div class="modal fade" id="edit<?php echo $chitiet_tour_id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content bg-modal">
                                                    <form class="main-form" action="" method="POST" enctype="multipart/form-data" id="updateForm">
                                                        <div class="modal-header" style="background: #2d7d90;color:#fff">
                                                            <h5 class="modal-title" id="exampleModalLabel" style="font-size:30px">Cập nhật dịch vụ</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col-md-12">
                                                                <div col-md-12>
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <div class="col-md-12" style="text-align: center;">
                                                                                <input type="hidden" value="<?php echo $chitiet_tour_id ?>" name="chitiet_tour_id" />
                                                                                <label for="chitiet_avt" class="form-label required"></label>
                                                                                <img src="../image/<?= $chitiet_avt; ?>" alt="<?= $chitiet_avt; ?>" srcset="" width="300px" height="200px" style="border-radius:3px ;">
                                                                                <input type="hidden" name="pre_chitiet_avt" value="<?php echo $chitiet_avt; ?>" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <label for="chitiet_avt" class="form-label required">Chọn ảnh mới</label>
                                                                                <input class="form-control" type="file" name="chitiet_avt" id="chitiet_avt" value="<?php echo $chitiet_avt ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <label for="chitiet_ten" class="form-label required">Tên dịch vụ</label>
                                                                                <input class="form-control" type="text" name="chitiet_ten" id="chitiet_ten" required value="<?php echo $chitiet_ten ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <label for="chitiet_gioithieu" class="form-label required">Giới thiệu</label>
                                                                                <textarea required class="form-control here" name="chitiet_gioithieu" id="chitiet_gioithieu" rows="3"><?php echo $chitiet_gioithieu ?></textarea>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <?php
                                                                            $chitiet_gia_nguoilon = $chitiet['chitiet_gia_nguoilon'];
                                                                            $chitiet_gia_treem = $chitiet['chitiet_gia_treem'];

                                                                            ?>
                                                                            <div class="col md 6">
                                                                                <label for="chitiet_gia_nguoilon" class="form-label required">Giá người lớn</label>
                                                                                <input class="form-control" type="number" name="chitiet_gia_nguoilon" id="chitiet_gia_nguoilon" required value="<?php echo $chitiet_gia_nguoilon ?>">
                                                                            </div>
                                                                            <div class="col md 6">
                                                                                <label for="chitiet_gia_treem" class="form-label required">Giá trẻ em</label>
                                                                                <input class="form-control" type="number" name="chitiet_gia_treem" id="chitiet_gia_treem" required value="<?php echo $chitiet_gia_treem ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="submit" id="update" name="update" class="btn button_submit" value="Cập nhật">
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- end modal update dich vu -->
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
                </div>
                <div class="col-md-1">

                </div>
            </div>
            </form>
         
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


if (isset($_POST["chitiet_them"])) {
    $chitiet_ten = $_POST['chitiet_ten'];
    $chitiet_avt = $_FILES['chitiet_avt']['name'];
    $path = "../image";
    $chitiet_avt_ext = pathinfo($chitiet_avt, PATHINFO_EXTENSION);
    $filename = time() . '.' . $chitiet_avt_ext;
    $chitiet_gioithieu = $_POST['chitiet_gioithieu'];
    $chitiet_gia_nguoilon = $_POST['chitiet_gia_nguoilon'];
    $chitiet_gia_treem = $_POST['chitiet_gia_treem'];
    $sql_them_chitiet = "INSERT INTO `chitiet_tour`(`tour_id`, `chitiet_ten`, `chitiet_gia_nguoilon`,`chitiet_gia_treem`, `chitiet_trangthai`, `chitiet_avt`, `chitiet_gioithieu`) 
    VALUES ('$tour_id','$chitiet_ten','$chitiet_gia_nguoilon','$chitiet_gia_treem','1','$filename','$chitiet_gioithieu')";
    if (mysqli_query($conn, $sql_them_chitiet)) {
        move_uploaded_file($_FILES['chitiet_avt']['tmp_name'], $path . '/' . $filename);
?>

        <div class="flash-data" data-flashdata=1></div>
        <script>
            const flashdata = $('.flash-data').data('flashdata')
            if (flashdata) {
                Swal.fire(
                    'Thành công!',
                    'Đã thêm dịch vụ của bạn.',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        location.href = 'dichvu.php';
                    }
                })
            }
        </script>
    <?php
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

if (isset($_POST["update"])) {
    $chitiet_tour_id = $_POST['chitiet_tour_id'];
    $chitiet_ten = $_POST['chitiet_ten'];
    $chitiet_avt = $_FILES['chitiet_avt']['name'];
    $path = "../image";
    $chitiet_avt_ext = pathinfo($chitiet_avt, PATHINFO_EXTENSION);
    $filename = time() . '.' . $chitiet_avt_ext;
    $chitiet_gioithieu = $_POST['chitiet_gioithieu'];
    $chitiet_gia_nguoilon = $_POST['chitiet_gia_nguoilon'];
    $chitiet_gia_treem = $_POST['chitiet_gia_treem'];
    $sql_them_chitiet = "UPDATE `chitiet_tour` SET `chitiet_ten`='$chitiet_ten',`chitiet_gia_nguoilon`='$chitiet_gia_nguoilon',`chitiet_gia_treem`='$chitiet_gia_treem',
    `chitiet_avt`='$filename',`chitiet_gioithieu`='$chitiet_gioithieu'
     WHERE `chitiet_tour_id`='$chitiet_tour_id'";
    if (mysqli_query($conn, $sql_them_chitiet)) {
        move_uploaded_file($_FILES['chitiet_avt']['tmp_name'], $path . '/' . $filename);
        // echo "<script>alert('them chi tiet tour thanh cong')</script>";
    ?>

        <div class="flash-data" data-flashdata=1></div>
        <script>
            const flashdata = $('.flash-data').data('flashdata')
            if (flashdata) {
                Swal.fire(
                    'Thành công!',
                    'Đã cập nhật dịch vụ của bạn.',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        location.href = 'dichvu.php';
                    }
                })
            }
        </script>
<?php
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}


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
<script>
    $('.close').on('click', function(e) {
        e.preventDefault();
        var self = $(this);
        console.log(self.data('title'));
        Swal.fire({
            title: 'Bạn có chắc muốn đóng dịch vụ này?',
            text: "Khách hàng sẽ không thể thấy cũng như đặt dịch vụ này",
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
    <?php if (isset($_GET['a'])) : ?>
        <div class="close" close-data="<?= $_GET['a']; ?>"></div>
    <?php endif; ?>
    
    const close = $('.close').data('close')
    if (close-data) {
        Swal.fire(
            'Đã xóa!',
            'Thông tin đã được xóa.',
            'success'
        )
    }
</script>
<script>
    $('.open').on('click', function(e) {
        e.preventDefault();
        var self = $(this);
        console.log(self.data('title'));
        Swal.fire({
            title: 'Bạn có chắc muốn mở dịch vụ này?',
            text: "Khách hàng có thể thấy và đặt vé cho dịch vụ này",
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
    <?php if (isset($_GET['b'])) : ?>
        <div class="open" open-data="<?= $_GET['b']; ?>"></div>
    <?php endif; ?>
    
    const open = $('.open').data('open')
    if (open-data) {
        Swal.fire(
            'Đã xóa!',
            'Thông tin đã được xóa.',
            'success'
        )
    }
</script>
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
<!-- ThanhLan1998@ -->