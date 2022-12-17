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
    <!-- main-content -->
    <div class="main-content">
      <h5>Danh sách tour</h5>
      <table class="table table-striped table-hover">
        <thead>
          <tr style="background-color: #d7dee4;">
            <th scope="col">#</th>
            <th scope="col">Tên tour</th>
            <th scope="col">giới thiệu</th>
            <th scope="col">bao gồm</th>
            <th scope="col">không bao gồm</th>
            <th scope="col">lịch trình</th>
            <th scope="col">thời gian khởi hành</th>
            <th scope="col">địa điểm khởi hành</th>
            <th scope="col">ngày</th>
            <th scope="col">đêm</th>
            <th scope="col">phương tiện</th>
            <th scope="col">giá</th>
            <th scope="col">Tác Vụ</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sn = 1;
          $sql_tour = "SELECT tour.tour_id, tour_ten,tour_gioithieu,tour.tour_dichvu,tour.tour_khongbaogom,tour.tour_lichtrinh,chitiet_tour.chitiet_tgian_khoihanh,
              chitiet_tour.chitiet_ddiem_khoihanh,chitiet_tour.chitiet_songay,chitiet_tour.chitiet_sodem,chitiet_tour.chitiet_phuongtien,chitiet_tour.chitiet_gia
              FROM (tour
                  INNER JOIN chitiet_tour ON chitiet_tour.tour_id=tour.tour_id)";
          $result_tour = mysqli_query($conn, $sql_tour);
          if (mysqli_num_rows($result_tour)) {
            while ($row = mysqli_fetch_assoc($result_tour)) {
          ?>
              <tr>
                <td><?php echo $sn++ ?></td>
                <td><?php echo $row['tour_ten'] ?></td>
                <td><?php echo $row['tour_gioithieu'] ?></td>
                <td><?php echo $row['tour_dichvu'] ?></td>
                <td><?php echo $row['tour_khongbaogom'] ?></td>
                <td><?php echo $row['tour_lichtrinh'] ?></td>
                <td><?php echo $row['chitiet_tgian_khoihanh'] ?></td>
                <td><?php echo $row['chitiet_ddiem_khoihanh'] ?></td>
                <td><?php echo $row['chitiet_songay'] ?></td>
                <td><?php echo $row['chitiet_sodem'] ?></td>
                <td><?php echo $row['chitiet_phuongtien'] ?></td>
                <td><?php echo $row['chitiet_gia'] ?></td>
                <td>
                  <a href="sua_tour.php?tour_id=<?php echo $row['tour_id'] ?>"><button type="button" class="bi bi-pencil-square" style="border:0px;font-size:20px"></button></a>
                  <a class="delete" href="xoa_tour.php?tour_id=<?php echo $row['tour_id'] ?>"><button type="button" class="bi bi-trash" style="border:0px;font-size:20px"></button></a>
                </td>
              </tr>
          <?php
            }
          }
          ?>
        </tbody>
      </table>
    </div>
    <!-- end main-content -->
  </div>
  <script src="../js/bootstrap.js"></script>
  <script src="../jquery/jquery-3.6.0.min.js"></script>
</body>

</html>