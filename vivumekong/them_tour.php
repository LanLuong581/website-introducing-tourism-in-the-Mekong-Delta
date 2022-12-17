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

    <div class="main-content">

      <form action="" method="post">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-1">

            </div>
            <div class="col-md-10">

              <h4 style="text-align: center;">Nhập thông tin tour</h4>
              <?php
              $sql_loaitour = "SELECT * FROM loai_tour;";
              $result_loaitour = mysqli_query($conn, $sql_loaitour);
              $loaitour_list = [];
              while ($row = mysqli_fetch_array($result_loaitour, MYSQLI_ASSOC)) {
                $loaitour_list[] = [
                  'loaitour_id' => $row['loaitour_id'],
                  'loaitour_ten' => $row['loaitour_ten'],
                ];
              }

              ?>
              <form class="main-form" action="" method="post" name="frmAddTour" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="tour_ten" class="form-label">Tên Tour</label>
                      <input type="text" class="form-control" id="tour_ten" name="tour_ten" placeholder="tên tour" required>
                    </div>

                  </div>
                  <div class="col-md-6">
                    <label for="loaitour_id" class="form-label required">Loại Tour</label>
                    <select name="loaitour_id" id="loaitour_id" class="form-select" required>
                      <?php foreach ($loaitour_list as $loaitour_ls) : ?>
                        <option value="<?= $loaitour_ls['loaitour_id'] ?>"><?= $loaitour_ls['loaitour_ten'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <!-- tinh -->
                  <div class="col-md-4">
                    <label for="tinh_id" class="form-label required">Tỉnh</label>
                    <select name="tinh" class=" tinh form-select" required>
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
                  <!-- huyen -->

                  <div class="col-md-4">
                    <label for="huyen_id" class="form-label required">Huyện</label>
                    <select name="huyen" class="huyen form-select" required>
                      <option selected="selected">--Chọn Huyện---</option>
                    </select>
                  </div>
                  <!-- xa -->
                  <div class="col-md-4">
                    <label for="xa_id" class="form-label required">Xa</label>
                    <select name="xa" class="xa form-select" required>
                      <option selected="selected">--Chọn Xã---</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label for="tour_gioithieu" class="form-label">Giới Thiệu</label>
                      <textarea class="form-control" id="tour_gioithieu" name="tour_gioithieu" rows="3" required></textarea>
                    </div>

                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label for="tour_dichvu" class="form-label">Dịch Vụ Bao Gồm</label>
                      <textarea class="form-control" id="tour_dichvu" name="tour_dichvu" rows="3" required></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label for="tour_khongbaogom" class="form-label">Dịch Vụ Không Bao Gồm</label>
                      <textarea class="form-control" id="tour_khongbaogom" name="tour_khongbaogom" rows="3" required></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label for="tour_lichtrinh" class="form-label">Lịch Trình</label>
                      <textarea class="form-control" id="tour_lichtrinh" name="tour_lichtrinh" rows="3" required></textarea>
                    </div>
                  </div>
                </div>
                <h5>Chi tiết tour</h5>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="chitiet_tgian_khoihanh" class="form-label">Thời Gian Khởi Hành</label>
                      <input type="text" class="form-control" id="chitiet_tgian_khoihanh" name="chitiet_tgian_khoihanh" placeholder="7:00 am" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="chitiet_ddiem_khoihanh" class="form-label">Địa Điểm Khởi Hành</label>
                      <input type="text" class="form-control" id="chitiet_ddiem_khoihanh" name="chitiet_ddiem_khoihanh" placeholder="Ninh Kiều" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <label for="thoigian" class="form-label">Tổng Thời Gian</label>
                    <br>
                    <label for="so_ngay">Số Ngày:</label>
                    <input type="number" id="chitiet_songay" name="chitiet_songay" min="1" max="20">
                    <label for="so_dem">Số Đêm:</label>
                    <input type="number" id="chitiet_sodem" name="chitiet_sodem" min="0" max="20">
                  </div>

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="chitiet_gia" class="form-label">Giá Tour</label>
                      <input type="number" class="form-control" id="chitiet_gia" name="chitiet_gia" placeholder="1000000" required>
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

                  <input class="btn btn-primary" type="submit" value="Thêm Tour" id="them_tour" name="them_tour">

              </form>
            </div>
            <div class="col-md-1">

            </div>
          </div>
        </div>
      </form>

    </div>

    <script>
      CKEDITOR.replace('tour_gioithieu', {
        filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
        filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
      });

      CKEDITOR.replace('tour_dichvu', {
        filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
        filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
      });
      CKEDITOR.replace('tour_khongbaogom', {
        filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
        filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
      });
      CKEDITOR.replace('tour_lichtrinh', {
        filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
        filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
      });
    </script>


</body>

</html>
<?php
if (isset($_POST["them_tour"])) {
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
  $sql_them_tour = "INSERT INTO `tour`(`tour_ten`, `tour_gioithieu`, `tour_dichvu`, `tour_khongbaogom`, `tour_lichtrinh`) 
  VALUES ('$tour_ten','$tour_gioithieu','$tour_dichvu','$tour_khongbaogom','$tour_lichtrinh')";
  if (mysqli_query($conn, $sql_them_tour)) {
    // echo "<script>alert('thêm tour thành công')</script>";
    $sql_tour_id = "SELECT MAX(tour_id) as tour_id FROM tour";
    $result = mysqli_query($conn, $sql_tour_id);
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $tour_id = $row['tour_id'];
        $sql_themchitiet = "INSERT INTO `chitiet_tour`(`tour_id`, `chitiet_tgian_khoihanh`, `chitiet_ddiem_khoihanh`, `chitiet_songay`, `chitiet_sodem`, `chitiet_phuongtien`, `chitiet_gia`) 
        VALUES ('$tour_id','$chitiet_tgian_khoihanh','$chitiet_ddiem_khoihanh','$chitiet_songay','$chitiet_sodem','$chkstr','$chitiet_gia')";
        if (mysqli_query($conn, $sql_themchitiet)) {
          echo "<script>alert('thêm chi tiết thành công')</script>";
        } else {
          echo "lỗi thêm tour" . mysqli_error($conn);
        }
      }
    }
  } else {
    echo "lỗi thêm tour" . mysqli_error($conn);
  }
}
?>