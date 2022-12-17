<?php
include('../config/constants.php');
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
    <title>ViVuMeKong</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@500&display=swap');
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="header">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.html" style="font-family: 'Cinzel', serif;font-size: 30px;">ViVuMekong</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="index.php">Trang chủ</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Tour
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="them_tour.php">Thêm Tour</a></li>
                                    <li><a class="dropdown-item" href="quanlytour.php">Quản Lý Tour</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                            </li>
                        </ul>
                        <form class="d-flex">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>
        <?php
        $tour_id = $_GET['tour_id'];
        $sql_tour = "SELECT * FROM `tour` WHERE tour_id='$tour_id'";
        $result_tour = mysqli_query($conn, $sql_tour);
        $data_tour = mysqli_fetch_array($result_tour, MYSQLI_ASSOC);
        $sql_chitiet = "SELECT * FROM `chitiet_tour` WHERE tour_id='$tour_id'";
        $result_chitiet = mysqli_query($conn, $sql_chitiet);
        $data_chitiet = mysqli_fetch_array($result_chitiet, MYSQLI_ASSOC);
        ?>
        <div class="main-content">
            <form action="" method="post">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-1">

                        </div>
                        <div class="col-md-10">
                            <h4 style="text-align: center;">sửa thông tin tour</h4>
                            <form class="main-form" action="" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tour_ten" class="form-label">Tên Tour</label>
                                            <textarea class="form-control" id="tour_ten" name="tour_ten" rows="1" required><?= $data_tour['tour_ten']; ?></textarea>
                                            <!-- <input type="text" class="form-control" id="tour_ten" name="tour_ten" placeholder="tên tour" required value=<?= $data_tour['tour_ten']; ?>> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="tour_gioithieu" class="form-label">Giới Thiệu</label>
                                            <textarea class="form-control" id="tour_gioithieu" name="tour_gioithieu" rows="5" required><?= $data_tour['tour_gioithieu']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="tour_dichvu" class="form-label">Dịch Vụ Bao Gồm</label>
                                            <textarea class="form-control" id="tour_dichvu" name="tour_dichvu" rows="5" required><?= $data_tour['tour_dichvu']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="tour_khongbaogom" class="form-label">Dịch Vụ Không Bao Gồm</label>
                                            <textarea class="form-control" id="tour_khongbaogom" name="tour_khongbaogom" rows="5" required><?= $data_tour['tour_khongbaogom']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="tour_lichtrinh" class="form-label">Lịch Trình</label>
                                            <textarea class="form-control" id="tour_lichtrinh" name="tour_lichtrinh" rows="5" required><?= $data_tour['tour_lichtrinh']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <h5>Chi tiết tour</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="chitiet_tgian_khoihanh" class="form-label">Thời Gian Khởi Hành</label>
                                            <textarea class="form-control" id="chitiet_tgian_khoihanh" name="chitiet_tgian_khoihanh" rows="1" required><?= $data_chitiet['chitiet_tgian_khoihanh']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="chitiet_ddiem_khoihanh" class="form-label">Địa Điểm Khởi Hành</label>
                                            <textarea class="form-control" id="chitiet_ddiem_khoihanh" name="chitiet_ddiem_khoihanh" rows="1" required><?= $data_chitiet['chitiet_ddiem_khoihanh']; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="thoigian" class="form-label">Tổng Thời Gian</label>
                                        <br>
                                        <label for="so_ngay">Số Ngày:</label>
                                        <input type="number" id="chitiet_songay" name="chitiet_songay" min="1" max="20" value=<?= $data_chitiet['chitiet_songay']; ?>>
                                        <label for="so_dem">Số Đêm:</label>
                                        <input type="number" id="chitiet_sodem" name="chitiet_sodem" min="0" max="20" value=<?= $data_chitiet['chitiet_sodem']; ?>>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="chitiet_gia" class="form-label">Giá Tour</label>
                                            <input type="number" class="form-control" id="chitiet_gia" name="chitiet_gia" placeholder="1000000" required value=<?= $data_chitiet['chitiet_gia']; ?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="phuongtien" class="form-label">Phương Tiện</label> <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="chitiet_phuongtien" name="chitiet_phuongtien[]" value="Xe du lịch">
                                            <label class="form-check-label" for="chitiet_phuongtien">Xe du lịch</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="chitiet_phuongtien" name="chitiet_phuongtien[]" value="Tàu">
                                            <label class="form-check-label" for="chitiet_phuongtien">Tàu</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="chitiet_phuongtien" name="chitiet_phuongtien[]" value="Xuồng">
                                            <label class="form-check-label" for="chitiet_phuongtien">Xuồng</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="chitiet_phuongtien" name="chitiet_phuongtien[]" value="Máy Bay">
                                            <label class="form-check-label" for="chitiet_phuongtien">Máy Bay</label>
                                        </div>
                                    </div>
                                    <input class="btn btn-primary" type="submit" value="Cập Nhật" id="cap_nhat_tour" name="cap_nhat_tour">
                            </form>
                        </div>
                        <div class="col-md-1">

                        </div>
                    </div>
                </div>
            </form>

        </div>
        <script src="../js/bootstrap.js"></script>
        <script src="../jquery/jquery-3.6.0.min.js"></script>
</body>

</html>
<?php
$tour_id = $_GET['tour_id'];
if (isset($_POST["cap_nhat_tour"])) {
    $tour_ten = $_POST['tour_ten'];
    $tour_gioithieu = $_POST['tour_gioithieu'];
    $tour_dichvu = $_POST['tour_dichvu'];
    $tour_khongbaogom = $_POST['tour_khongbaogom'];
    $tour_lichtrinh = $_POST['tour_lichtrinh'];
    $chitiet_tgian_khoihanh = $_POST['chitiet_tgian_khoihanh'];
    $chitiet_ddiem_khoihanh = $_POST['chitiet_ddiem_khoihanh'];
    $chitiet_songay = $_POST['chitiet_songay'];
    $chitiet_sodem = $_POST['chitiet_sodem'];
    $chitiet_gia = $_POST['chitiet_gia'];
    $chitiet_phuongtien = $_POST['chitiet_phuongtien'];
    $chkstr = implode(",", $chitiet_phuongtien);
    // echo $chkstr;
    $sql_sua_chitiet = "UPDATE `chitiet_tour` SET `chitiet_tgian_khoihanh`='$chitiet_tgian_khoihanh',
    `chitiet_ddiem_khoihanh`='$chitiet_ddiem_khoihanh',`chitiet_songay`='$chitiet_songay',`chitiet_sodem`='$chitiet_sodem',`chitiet_phuongtien`='$chkstr',
    `chitiet_gia`='$chitiet_gia' WHERE `tour_id`='$tour_id'";
    if (mysqli_query($conn, $sql_sua_chitiet)) {
        // echo "<script>alert('sửa chi tiết thành công')</script>";
        $sql_sua_tour="UPDATE `tour` SET `tour_ten`='$tour_ten',`tour_gioithieu`='$tour_gioithieu',
        `tour_dichvu`='$tour_dichvu',`tour_khongbaogom`='$tour_khongbaogom',`tour_lichtrinh`='$tour_lichtrinh' WHERE `tour_id`='$tour_id'";
        if(mysqli_query($conn,$sql_sua_tour)){
        echo "<script>alert('sửa chi tiết thành công')</script>";

        }
        else{
        echo "lỗi sửa chi tiết tour" . mysqli_error($conn);
        }
    } else {
        echo "lỗi sửa chi tiết tour" . mysqli_error($conn);
    }
}
?>