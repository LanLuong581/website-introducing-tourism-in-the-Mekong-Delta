<?php
include('../config/constants.php');
session_start();
ob_start();

$giatrisearch=$_GET['giatrisearch'];
if (isset($_SESSION["acc_email"])) {
    $mail = $_SESSION["acc_email"];
    $sql_account = mysqli_query($conn, "SELECT account_id FROM `account` WHERE account_email='$mail'");
    while ($account = mysqli_fetch_assoc($sql_account)) {
        $account_id = $account['account_id'];
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
    <title>ViVuMeKong</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@500&display=swap');
    </style>
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

        .button_continue {
            background-color: #2d7d90;
            border-radius: 20px;
            border: none;
            color: #fff;
            padding: 10px;
            width: 100%;
            font-weight: 600;
            text-transform: capitalize;
            cursor: pointer;
        }

        .button_continue:hover {
            background: #22577a;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="header">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php" style="font-family: 'Cinzel', serif;font-size: 30px;">ViVuMekong</a>
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
                        <!-- modal xem thong tin khach hang -->
                        <div class="modal fade" id="info<?php echo $account_id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Thông tin cá nhân</h5>

                                    </div>
                                    <div class="modal-body">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn button_close" data-bs-dismiss="modal">Đóng</button>
                                        <button type="button" class="btn button_submit" data-bs-target="#update<?php echo $account_id ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Cập nhật</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal xem thong tin khach hang -->

                        <!-- modal cap nhat thong tin khach hang -->
                        <div class="modal fade" id="update<?php echo $account_id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Cập nhật thông tin</h5>

                                    </div>
                                    <div class="modal-body">
                                        ...
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn button_close" data-bs-dismiss="modal">Đóng</button>
                                        <button type="button" class="btn button_submit">Cập nhật</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal cap nhat thong tin khach hang -->

                    </div>
                </div>
            </nav>
        </div>
        <div class="main_content" style="background-color: #f8f9fa;padding-top:50px">
            <form action="" method="POST">
                <div class="row" style="margin: 0;">
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-10" style="background-color: #fff;padding:12px 24px 50px 24px">
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
                      WHERE account.daily_trangthai='1' && tour.tour_gioithieu != 'NULL' && tour.tour_ten LIKE '%$giatrisearch%'";
                        $result_tour = mysqli_query($conn, $sql_tour);
                        if (mysqli_num_rows($result_tour) > 0) {
                        ?>
                            <h4>Tìm thấy <?php echo mysqli_num_rows($result_tour) ?> kết quả cho "<?php echo $giatrisearch ?>"</h4>

                            <?php

                            while ($row = mysqli_fetch_assoc($result_tour)) {
                                $tour_id = $row['tour_id'];
                            ?>
                                <div class="grid" style="grid-template-columns: repeat(4, 1fr);padding:0px;margin:0">
                                    <article>
                                        <img src="../image/<?php echo $row['tour_avt'] ?>" alt="" width="400px" height="200px">
                                        <div class="text" style="padding: 10px;">
                                            <h4 style="text-align: center;"><?php echo ucwords($row['tour_ten']) ?></h4>
                                            <p style="text-align: left;line-height:3px">Địa chỉ: <?php echo $row['huyen_ten'] ?>,<?php echo $row['tinh_ten'] ?></p>
                                            <p style="text-align: left;line-height:3px">Loại hình: <?php echo $row['loaitour_ten'] ?></p>
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
                                            <a href="chitiet.php?tour_id=<?php echo $tour_id; ?>" class="btn button_continue">Tiếp</a>

                                        </div>
                                    </article>
                                <?php
                            }
                        } else {
                                ?>

                                <div class="row">
                                    <div class="col-md-2">

                                    </div>
                                    <div class="col-md-8" style="text-align: center;">
                                        <div class="empty-cart" style="background-color: #fff;height:200px;margin-bottom:10%;padding-top:20px;padding-bottom:20px">
                                            <h5>Không tìm thấy kết quả nào cho "<?php echo $giatrisearch ?>"</h5>
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
</body>

</html>