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
            <div class="row" style="margin: 0; padding:30px 0px">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="control">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="them_blog">
                                        <a class="them-blog btn button_submit" style="width:223px" href="them_blog.php">Thêm bài viết</a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="timkiem">
                                        <div class="them_blog">
                                            <input type="text" class="form-control" placeholder="Nhập tên bài viết..." name="key_search">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="search_btn">
                                        <button type="submit" class="bi bi-search" style="border: none; background:none;font-size:25px;color:#22577a" name="search_btn" id="search_btn"></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <br>
                    </div>
                    <div class="blog_list">
                        <?php
                        if (isset($_POST['search_btn'])) {
                            $key_search = $_POST['key_search'];
                            $sql_blog = "SELECT blog.id,blog.blog_avt,blog.blog_tieude,blog.blog_noidung,blog.blog_status,loai_blog.loaiblog_ten,blog.loaiblog_id
               FROM (blog
                     INNER JOIN loai_blog ON loai_blog.id=blog.loaiblog_id) WHERE blog.blog_tieude LIKE '%$key_search%'";
                            $result_blog = mysqli_query($conn, $sql_blog);
                            if (mysqli_num_rows($result_blog) > 0) {
                                while ($blog_row = mysqli_fetch_assoc($result_blog)) {
                                    $id = $blog_row['id'];
                                    $blog_avt = $blog_row['blog_avt'];
                                    $blog_tieude = $blog_row['blog_tieude'];
                                    $blog_noidung = $blog_row['blog_noidung'];
                                    $blog_status = $blog_row['blog_status'];
                                    $loaiblog_ten = $blog_row['loaiblog_ten'];
                                    $loaiblog_id = $blog_row['loaiblog_id'];
                        ?>
                                    <div class="row content" style="margin:0px;background: #eef4ed;padding:10px">
                                        <div class="row" style="margin:0">
                                            <div class="col-md-3 avt">
                                                <!-- hinh dai dien -->
                                                <img src="../image/<?= $blog_avt; ?>" alt="<?= $blog_avt; ?>" srcset="" width="300px" height="200px" style="border-radius:3px ;">
                                            </div>
                                            <div class="col-md-6" style="padding: 0px 20px;">

                                                <div class="row">
                                                    <!-- ten dich vu -->
                                                    <?php
                                                    if ($blog_status == 0) {
                                                    ?>
                                                        <span style="font-size:20px"> <b><?php echo $blog_tieude ?></b> </span><span style="color:red">(Tạm đóng)</span>

                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span style="font-size:20px"> <b><?php echo $blog_tieude ?></b> </span>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>

                                            </div>
                                            <div class="col-md-3" style="text-align:right">
                                                <div class="row" style="display: inline;">
                                                    <a href="edit_blog.php?id=<?php echo $id ?>" class="btn button_submit" style="width: 66px;background-color:#48b89f">Sửa</a>
                                                    <a href="xoa_blog.php?id=<?php echo $id ?>" class="btn button_submit delete" style="width: 66px">Xóa</a>
                                                    <?php
                                                    if ($blog_status == 1) {
                                                    ?>
                                                        <a class="close" href="dong_blog.php?id=<?php echo $id ?>" style="padding:0px"><button type="button" class="btn button_submit" style="width: 66px;background-color:#df2935;">Đóng</button></a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a class="open" href="mo_blog.php?id=<?php echo $id ?>" style="padding:0px"><button type="button" class="btn button_submit" style="width: 66px;background-color:#ffa62b">Mở</button></a>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <br>
                                <?php
                                }
                            }
                        } else {
                            // ---------------
                            $sql_blog = "SELECT blog.id,blog.blog_avt,blog.blog_tieude,blog.blog_noidung,blog.blog_status,loai_blog.loaiblog_ten,blog.loaiblog_id
                       FROM (blog
                             INNER JOIN loai_blog ON loai_blog.id=blog.loaiblog_id) ORDER BY blog.id DESC";
                            $result_blog = mysqli_query($conn, $sql_blog);
                            if (mysqli_num_rows($result_blog) > 0) {
                                while ($blog_row = mysqli_fetch_assoc($result_blog)) {
                                    $id = $blog_row['id'];
                                    $blog_avt = $blog_row['blog_avt'];
                                    $blog_tieude = $blog_row['blog_tieude'];
                                    $blog_noidung = $blog_row['blog_noidung'];
                                    $blog_status = $blog_row['blog_status'];
                                    $loaiblog_ten = $blog_row['loaiblog_ten'];
                                    $loaiblog_id = $blog_row['loaiblog_id'];

                                ?>
                                    <div class="row content" style="margin:0px;background: #eef4ed;padding:10px">
                                        <div class="row" style="margin:0">
                                            <div class="col-md-3 avt">
                                                <!-- hinh dai dien -->
                                                <img src="../image/<?= $blog_avt; ?>" alt="<?= $blog_avt; ?>" srcset="" width="300px" height="200px" style="border-radius:3px ;">
                                            </div>
                                            <div class="col-md-6" style="padding: 0px 20px;">

                                                <div class="row">
                                                    <!-- ten dich vu -->
                                                    <?php
                                                    if ($blog_status == 0) {
                                                    ?>
                                                        <span style="font-size:20px"> <b><?php echo $blog_tieude ?></b> </span><span style="color:red">(Tạm đóng)</span>

                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span style="font-size:20px"> <b><?php echo $blog_tieude ?></b> </span>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>

                                            </div>
                                            <div class="col-md-3" style="text-align:right">
                                                <div class="row" style="display: inline;">
                                                    <a href="edit_blog.php?id=<?php echo $id ?>" class="btn button_submit" style="width: 66px;background-color:#48b89f">Sửa</a>
                                                    <a href="xoa_blog.php?id=<?php echo $id ?>" class="btn button_submit delete" style="width: 66px">Xóa</a>
                                                    <?php
                                                    if ($blog_status == 1) {
                                                    ?>
                                                        <a class="close" href="dong_blog.php?id=<?php echo $id ?>" style="padding:0px"><button type="button" class="btn button_submit" style="width: 66px;background-color:#df2935;">Đóng</button></a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a class="open" href="mo_blog.php?id=<?php echo $id ?>" style="padding:0px"><button type="button" class="btn button_submit" style="width: 66px;background-color:#ffa62b">Mở</button></a>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <br>
                        <?php
                                }
                            }
                        }

                        ?>

                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>

        </div>
        <div class="footer">
            <?php include("../templates/footer.html") ?>
        </div>
    </div>
    <script>
        $('.delete').on('click', function(e) {
            e.preventDefault();
            var self = $(this);
            console.log(self.data('title'));
            Swal.fire({
                title: 'Bạn có chắc muốn xóa bài viết này?',
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

        $('.close').on('click', function(e) {
            e.preventDefault();
            var self = $(this);
            console.log(self.data('title'));
            Swal.fire({
                title: 'Bạn có chắc muốn đóng tạm thời bài viết này?',
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

        $('.open').on('click', function(e) {
            e.preventDefault();
            var self = $(this);
            console.log(self.data('title'));
            Swal.fire({
                title: 'Bạn có chắc muốn mở lại bài viết này?',
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
</body>

</html>