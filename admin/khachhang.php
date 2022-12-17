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
                                <a class="nav-link " aria-current="page" href="doanhnghiep.php">Doanh Nghiệp</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="khachhang.php">Khách Hàng</a>
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
                    <div class="row">
                        <!-- <div class="col-md-1">

                        </div> -->
                        <div class="col-md-12" style="padding: 0;">
                            <div class="row">
                                <h4 style="text-align: center;"><b>Danh sách khách hàng</b> </h4>
                                <?php
                                // $student_id = $_SESSION["acc_student_id"];
                                $sn = 1;
                                $sql = "SELECT khachhang_id,khachhang_ho,khachhang_ten,khachhang_ngaysinh,khachhang_dienthoai,
                                khachhang_diachi,province._name AS tinh_ten,district._name AS huyen_ten,ward._name AS xa_ten,
                                account.account_email,account.khachhang_trangthai,account.account_id
                                FROM ((((khachhang
                                      INNER JOIN province ON province.id=khachhang.tinh_id)
                                      INNER JOIN district ON district.id=khachhang.huyen_id)
                                      INNER JOIN ward ON ward.id=khachhang.xa_id)
                                      INNER JOIN account ON account.account_id=khachhang.account_id) ORDER BY khachhang.khachhang_ten ASC";
                                $result = mysqli_query($conn, $sql);
                                ?>
                                <table class="table" id="khachhang">
                                    <thead>
                                        <tr class="table-success">
                                            <th>#</th>
                                            <th>ID</th>
                                            <th>Họ KH</th>
                                            <th>Tên KH</th>
                                            <th>Ngày Sinh</th>
                                            <th>Địa Chỉ</th>
                                            <th>Xã</th>
                                            <th>Huyện</th>
                                            <th>Tỉnh</th>
                                            <th>Điện Thoại</th>
                                            <th>Email</th>
                                            <th>Trạng Thái</th>
                                            <th>Tác Vụ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $account_id=$row['account_id'];
                                                $khachhang_id=$row['khachhang_id'];
                                                $khachhang_ho=$row['khachhang_ho'];
                                                $khachhang_ten=$row['khachhang_ten'];
                                                $khachhang_ngaysinh=$row['khachhang_ngaysinh'];
                                                $khachhang_dienthoai=$row['khachhang_dienthoai'];
                                                $khachhang_diachi=$row['khachhang_diachi'];
                                                $tinh_ten=$row['tinh_ten'];
                                                $huyen_ten=$row['huyen_ten'];
                                                $xa_ten=$row['xa_ten'];
                                                $account_email=$row['account_email'];
                                                $khachhang_trangthai=$row['khachhang_trangthai'];

                                        ?>
                                                <tr>
                                                    <td><?php echo $sn++ ?></td>
                                                    <td><?php echo $khachhang_id?></td>
                                                    <td><?php echo $khachhang_ho?></td>
                                                    <td><?php echo $khachhang_ten?></td>
                                                    <td><?php echo $khachhang_ngaysinh?></td>
                                                    <td><?php echo $khachhang_diachi?></td>
                                                    <td><?php echo $xa_ten?></td>
                                                    <td><?php echo $huyen_ten?></td>
                                                    <td><?php echo $tinh_ten?></td>
                                                    <td><?php echo $khachhang_dienthoai?></td>
                                                    <td><?php echo $account_email?></td>
                                                    
                                                    <td>
                                                        <?php if ($khachhang_trangthai == 1) : ?>
                                                            <span class="badge bg-success">Đang mở</span>
                                                        <?php elseif ($khachhang_trangthai == 0) : ?>
                                                            <span class="badge bg-warning">Tạm đóng</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="del_edit">
                                                        <a class="xoa" href="xoa_khachhang.php?account_id=<?php echo $account_id ?>"><button type="button" class="bi bi-trash" style="border:0px;font-size:20px; color:red" title="Xóa tài khoản"></button></a>
                                                        <?php if ($khachhang_trangthai == 0) : ?>
                                                            <a class="mo" href="motk_khachhang.php?account_id=<?php echo $account_id ?>"><button type="button" class="bi bi-person-check" style="border:0px;font-size:20px; color:green" title="Mở tài khoản"></button></a>
                                                        <?php elseif ($khachhang_trangthai == 1) : ?>
                                                            <a class="dong" href="dongtk_khachhang.php?account_id=<?php echo $account_id ?>"><button type="button" class="bi bi-person-x" style="border:0px;font-size:20px; color:green" title="Đóng tài khoản"></button></a>

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
                        </div>
                        <!-- <div class="col-md-1">

                        </div> -->
                    </div>
                </div>

            </form>

        </div>
              <!-- footer -->
              <?php
        include("../templates/footer.html")
        ?>
        <!-- end footer -->
    </div>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $('#khachhang').DataTable({
            "pageLength": 5,
            "lengthMenu": [5, 10, 20, 30, 50]

        });
    </script>
</body>

</html>
<?php if (isset($_GET['a'])) : ?>
    <div class="da-duyet" data-flashdata="<?= $_GET['a'] ?>"></div>
<?php endif; ?>

<!--dong tai khoan-->
<script>
    $('.dong').on('click', function(e) {
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
    <?php if (isset($_GET['b'])) : ?>
    <div class="da-dong" data-flashdata="<?= $_GET['b'] ?>"></div>
    <?php endif; ?>
    const dong = $('.da-dong').data('dong')
    if (dong) {
        Swal.fire(
            'Đã đóng!',
            'Tài khoản đã đóng.',
            'success'
        )
    }
</script>
<!-- end dong tai khoan-->
<!--xoa-->
<script>
    $('.xoa').on('click', function(e) {
        e.preventDefault();
        var self = $(this);
        console.log(self.data('title'));
        Swal.fire({
            title: 'Bạn có chắc muốn xóa tài khách hàng này?',
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
    const xoa = $('.flash-data').data('xoa')
    if (xoa) {
        Swal.fire(
            'Đã duyệt!',
            'Doanh nghiệp đã được duyệt.',
            'success'
        )
    }
</script>


<!-- mở tài khoản -->
<script>
    $('.mo').on('click', function(e) {
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
    <?php if (isset($_GET['a'])) : ?>
    <div class="da-mo" data-flashdata="<?= $_GET['a'] ?>"></div>
    <?php endif; ?>

    const mo = $('.da-mo').data('mo')
    if (mo) {
        Swal.fire(
            'Đã mở!',
            'Tài khoản đã được mở.',
            'success'
        )
    }
</script>
<!-- end mở tải khoản-->
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
                        location.href = 'khachhang.php';
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