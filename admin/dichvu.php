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
                                <a class="nav-link active" aria-current="page" href="dichvu.php">Dịch vụ</a>
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
        <div class="main_content"  style="background-color: #f8f9fa;">
            <div class="dichvu">
                <h4 style="text-align: center;">Danh sách các dịch vụ</h4>
                <table class="table table-bordered" >
                    <thead>
                        <tr class="table-success">
                            <th>STT</th>
                            <th>Tên doanh nghiệp</th>
                            <th>Tên dịch vụ</th>
                            <th>Giá người lớn</th>
                            <th>Giá trẻ em</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #fff;">

                        <?php
                        $n = 1;
                        $sql_dichvu = "SELECT DISTINCT chitiet_tour.tour_id,tour.tour_ten
                    FROM (chitiet_tour
                          INNER JOIN tour ON tour.tour_id=chitiet_tour.tour_id)";
                        $result_dichvu = mysqli_query($conn, $sql_dichvu);
                        if (mysqli_num_rows($result_dichvu) > 0) {
                            while ($dichvu_row = mysqli_fetch_assoc($result_dichvu)) {
                                $tour_id = $dichvu_row['tour_id'];
                                $tour_ten = $dichvu_row['tour_ten'];
                                $sql_chitiet = "SELECT chitiet_ten,chitiet_gia_nguoilon,chitiet_gia_treem,chitiet_trangthai
                            FROM chitiet_tour
                            WHERE tour_id='$tour_id'";
                                $result_chitiet = mysqli_query($conn, $sql_chitiet);
                                if (mysqli_num_rows($result_chitiet) > 0) {
                                    $count_chitiet = mysqli_num_rows($result_chitiet) + 1;
                        ?>
                                    <tr>
                                        <td rowspan="<?php echo $count_chitiet ?>"><?php echo $n++ ?></td>
                                        <td rowspan="<?php echo $count_chitiet ?>"><?php echo $tour_ten ?></td>
                                        <td style="display: none;"></td>
                                        <td style="display: none;"></td>
                                        <td style="display: none;"></td>
                                        <td style="display: none;"></td>
                                    </tr>
                                    <?php
                                    while ($chitiet_row = mysqli_fetch_assoc($result_chitiet)) {
                                        $chitiet_ten = $chitiet_row['chitiet_ten'];
                                        $chitiet_gia_nguoilon = number_format($chitiet_row['chitiet_gia_nguoilon']);
                                        $chitiet_gia_treem = number_format($chitiet_row['chitiet_gia_treem']);
                                        $chitiet_trangthai = $chitiet_row['chitiet_trangthai'];
                                    ?>
                                        <tr>
                                            <td><?php echo $chitiet_ten ?></td>
                                            <td><?php echo $chitiet_gia_nguoilon ?></td>
                                            <td><?php echo $chitiet_gia_treem ?></td>
                                            <td>
                                                <?php if ($chitiet_trangthai == 0) : ?>
                                                    <span class="badge bg-warning">Tạm đóng</span>
                                                <?php elseif ($chitiet_trangthai == 1) : ?>
                                                    <span class="badge bg-success">Hoạt động</span>
                                                <?php endif; ?>

                                            </td>
                                        </tr>
                        <?php
                                    }
                                }
                            }
                        } else {
                            echo "<script>console.log('khong tim thay tour_id')</script>";
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="footer">
            <?php include("../templates/footer.html") ?>
        </div>
    </div>

</body>

</html>