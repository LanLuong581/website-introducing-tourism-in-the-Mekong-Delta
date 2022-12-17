<?php
include('../config/constants.php');
session_start();
ob_start();
// if (!isset($_SESSION['acc_account_loaitaikhoan'])) {
//     header("location:../templates/login.php");
// } else {
//     if ($_SESSION['acc_account_loaitaikhoan'] != 3) {
//         header("location:../templates/login.php");
//     }
// }
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

        .search-btn {
            background-color: #2d7d90;
            color: #fff
        }

        .search-btn:hover {
            background-color: #22577a;
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
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php" style="font-family: 'Cinzel', serif;font-size: 30px;">ViVuMekong</a>
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
                                <a class="nav-link active" aria-current="page" href="vuontraicay.php">Vườn Trái Cây</a>
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
                                        <li data-bs-toggle="modal" data-bs-target="#ModalThongTin"><a class="dropdown-item bi bi-person"> Thông tin cá nhân</a></li>
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

                    </div>
                </div>
            </nav>
        </div>
        <div class="main-content">
            <div class="vuontraicay" style="   background-image: url(../image/vuontraicay7.jpg);
    height: 50vh;
    background-size: cover;">
                <div class="timkiem" style="padding-top: 150px;padding-left:300px;padding-right:300px">
                    <form action="" method="post">
                        <!-- <h5 style="color: #fff;">Điểm đến của bạn</h5> -->
                        <div class="row">
                            <div class="col-md-10">
                                <select class="form-select" aria-label="Default select example" name="tinh" required>
                                    <option selected style="color:gray" value="" disabled>Lựa chọn điểm đến của bạn</option>
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
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-light search-btn" style="width: 95px;font-weight:600;border:none" id="search_submit" name="search_submit">Tìm kiếm</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <form action="" method="post">
                <div class="row" style="margin: 0;">
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-8" style="background-color: #fff;padding-bottom: 50px;">
                        <h5>Các dịch vụ vườn trái cây</h5>

                        <!-- product list -->
                        <div class="grid" style="grid-template-columns: repeat(3, 1fr);padding-left:0px">
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
                      WHERE account.daily_trangthai='1' && tour.tour_gioithieu != 'NULL' && loai_tour.loaitour_id='5'";
                            $result_tour = mysqli_query($conn, $sql_tour);
                            if (mysqli_num_rows($result_tour) > 0) {
                                while ($row = mysqli_fetch_assoc($result_tour)) {
                                    $tour_id = $row['tour_id'];
                            ?>
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
                            }
                            ?>
                        </div>
                        <!-- product list -->
                    </div>
                    <div class="col-md-2">

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
<?php
if (isset($_POST["search_submit"])) {
    $loaitour_id = "5";
    $tinh = $_POST["tinh"];
    echo "<script>console.log($tinh)</script>";
    echo "<script>console.log($loaitour_id)</script>";
    header("location:tour_search2.php?tinh=$tinh&loaitour=$loaitour_id");
    ob_end_flush();
    exit();
}
?>