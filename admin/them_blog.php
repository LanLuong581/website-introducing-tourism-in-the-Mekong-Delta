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
                                <a class="nav-link " aria-current="page" href="doanhnghiep.php">Doanh Nghiệp</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="khachhang.php">Khách Hàng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="dichvu.php">Dịch vụ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="blog.php">Blog</a>
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
                                    <li data-bs-toggle="modal" data-bs-target="#ModalThongTin"><a class="dropdown-item bi bi-person"> Thông tin cá nhân</a></li>
                                    <!-- Button trigger modal -->

                                    <li><a class="dropdown-item bi bi-box-arrow-right" href="../templates/logout.php"> Đăng Xuất</a></li>

                                </ul>
                            </li>

                        </ul>

                    </div>
                </div>
            </nav>
        </div>
        <div class="main_content" style="background-color: #f8f9fa;min-height:50vh">
            <div class="row" style="margin:0">
                <div class="col-md-2">

                </div>
                <div class="col-md-8" style="background-color: #fff;margin-top:30px;margin-bottom:30px">
                    <?php
                    $sql_loaiblog = "SELECT * FROM loai_blog;";
                    $result_loaiblog = mysqli_query($conn, $sql_loaiblog);
                    $loaiblog_list = [];
                    while ($row = mysqli_fetch_array($result_loaiblog, MYSQLI_ASSOC)) {
                        $loaiblog_list[] = [
                            'loaiblog_id' => $row['id'],
                            'loaiblog_ten' => $row['loaiblog_ten'],
                        ];
                    }

                    ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <h5 style="text-align: center;">Thêm bài viết</h5>

                        <div class="row" style="margin:0">
                            <label for="loaiblog_id" class="form-label " style="font-weight: 500;padding:0">Chủ đề bài viết</label>
                            <select name="loaiblog_id" id="loaiblog_id" class="form-select" required>
                                <?php foreach ($loaiblog_list as $loaiblog_ls) : ?>
                                    <option value="<?= $loaiblog_ls['loaiblog_id'] ?>"><?= $loaiblog_ls['loaiblog_ten'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="loaiblog_id" class="form-label " style="font-weight: 500;">Hình đại diện cho bài viết</label>
                            </div>
                            <div class="col-md-7">
                                <input type="file" id="blog_avt" name="blog_avt" required>
                            </div>
                        </div>
                        <br>
                        <div class="row" style="margin:0">
                            <label for="" class="form-label" style="font-weight: 500;padding:0">Tiêu đề bài viết</label>
                            <input type="text" class="form-control" id="blog_tieude" name="blog_tieude" maxlength="60" required>
                        </div> <br>
                        <div class="row" style="margin:0">
                            <div class="col-md-12" style="padding:0">
                                <label for="" class="form-label" style="font-weight: 500;">Nội dung bài viết</label>
                                <textarea class="form-control" id="blog_noidung" name="blog_noidung" rows="5" required></textarea>
                            </div>

                        </div>
                        <br>
                        <div style="float: right;">
                            <input class="btn button_submit" type="submit" value="Đăng ngay" id="up_now" name="up_now">
                            <input class="btn button_submit" type="submit" value="Lưu bài" id="save" name="save">

                        </div>

                    </form>
                </div>
                <div class="col-md-2">

                </div>
            </div>

        </div>
        <div class="footer">
            <?php include("../templates/footer.html") ?>
        </div>
    </div>
    <script>
        CKEDITOR.replace('blog_noidung', {
            filebrowserBrowseUrl: '../vivumekong/ckfinder/ckfinder.html',
            filebrowserUploadUrl: '../vivumekong/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
        });
    </script>
</body>

</html>
<?php
if (isset($_POST['up_now'])) {
    $loaiblog_id = $_POST['loaiblog_id'];
    $blog_tieude = $_POST['blog_tieude'];
    $blog_noidung = $_POST['blog_noidung'];
    $blog_avt = $_FILES['blog_avt']['name'];
    $path = "../image";
    $blog_avt_ext = pathinfo($blog_avt, PATHINFO_EXTENSION);
    $filename = time() . '.' . $blog_avt_ext;
    $sql_dangblog = "INSERT INTO `blog`(`blog_avt`,`loaiblog_id`, `blog_tieude`, `blog_noidung`, `blog_status`) 
    VALUES ('$filename','$loaiblog_id','$blog_tieude','$blog_noidung','1')";
    if (mysqli_query($conn, $sql_dangblog)) {
        move_uploaded_file($_FILES['blog_avt']['tmp_name'], $path . '/' . $filename);
?>
        <div class="flash-data" data-flashdata=1></div>
        <script>
            const flashdata = $('.flash-data').data('flashdata')
            if (flashdata) {
                Swal.fire(
                    'Thành công!',
                    'Đã đăng bài viết.',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        location.href = 'blog.php';
                    }
                })
            }
        </script>
    <?php
    } else {
        echo "<script>alert('cập nhật mục giới thiệu thất bại')</script>";
    }
}

if (isset($_POST['save'])) {
    $loaiblog_id = $_POST['loaiblog_id'];
    $blog_tieude = $_POST['blog_tieude'];
    $blog_noidung = $_POST['blog_noidung'];
    $blog_avt = $_FILES['blog_avt']['name'];
    $path = "../image";
    $blog_avt_ext = pathinfo($blog_avt, PATHINFO_EXTENSION);
    $filename = time() . '.' . $blog_avt_ext;
    $sql_dangblog = "INSERT INTO `blog`(`blog_avt`,`loaiblog_id`, `blog_tieude`, `blog_noidung`, `blog_status`) 
    VALUES ('$filename','$loaiblog_id','$blog_tieude','$blog_noidung','0')";
    if (mysqli_query($conn, $sql_dangblog)) {
        move_uploaded_file($_FILES['blog_avt']['tmp_name'], $path . '/' . $filename);

    ?>

        <div class="flash-data" data-flashdata=1></div>
        <script>
            const flashdata = $('.flash-data').data('flashdata')
            if (flashdata) {
                Swal.fire(
                    'Thành công!',
                    'Đã lưu bài viết.',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        location.href = 'blog.php';
                    }
                })
            }
        </script>
<?php
    } else {
        echo "<script>alert('cập nhật mục giới thiệu thất bại')</script>";
    }
}
?>