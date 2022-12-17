<?php
$connect = new PDO("mysql:host=localhost;dbname=dulichdbscl", "root", "");
include('../config/constants.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="style4.css">
    <script src="../js/check_new.js"></script>
    <title>ViVuMekong</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap');
    </style>
</head>

<body>
    <div class="background">
        <div class="container">

            <div class="form-box">
                <div class="title">
                    <p style="font-family: 'Cinzel', serif;font-size:60px;text-align: center;color:#0096c7;">ViVuMekong</p>
                    <h3 style="text-align: center;font-family: 'Cinzel', serif;">Đăng Nhập</h3>
                </div>
                <form id="login" method="post" action="">
                    <input type="email" class="input-field" name="account_email" id="account_email" placeholder="Email" value="<?php if (isset($_COOKIE["account_email"])) {
                                                                                                                                    echo $_COOKIE["account_email"];
                                                                                                                                } ?>">

                    <input type="password" class="input-field" name="account_password" id="account_password" placeholder="Mật Khẩu" value="<?php if (isset($_COOKIE["account_password"])) {
                                                                                                                                                echo $_COOKIE["account_password"];
                                                                                                                                            } ?>">

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php if (isset($_COOKIE["account_email"])) { ?> checked <?php } ?>>
                        <label class="form-check-label" for="remember">
                            Ghi nhớ tôi
                        </label>
                    </div>

                    <button type="submit" onclick="return vali();" class="submit-btn" style="border-radius:30px" name="login-btn" id="login-btn">Đăng Nhập</button>
                </form>
                <br>
                <div class="row">
                    <p style="text-align:center">Bạn chưa có tài khoản? <a href="../templates/register.php" style="color: red;text-decoration:none">Đăng ký</a></p>
                </div>
                <div class="row">
                  <a href="../khachhang/index.php" style="color: blue;text-decoration:none; text-align:center">Trở về trang chủ</a>
                </div>
            </div>

        </div>
        <!-- <video autoplay muted loop>
        <source src="video1.mp4" type="video/mp4">
    </video> -->
    </div>

    <script src="../js/bootstrap.js"></script>
    <script src="../jquery/jquery-3.6.0.min.js"></script>
</body>

</html>
<?php
include('../Config/constants.php');
session_start();
if (isset($_POST['login-btn'])) {
    $account_email = $_POST["account_email"];
    $account_password = $_POST['account_password'];
    if (!empty($_POST["remember"])) {
        setcookie("account_email", $account_email, time() + (3600), "/");
        setcookie("account_password", $account_password, time() + (3600), "/");
    } else {
        if (isset($_COOKIE["account_email"])) {
            setcookie("account_email", "");
        }
        if (isset($_COOKIE["account_password"])) {
            setcookie("account_password", "");
        }
    }
    $account_email = $_POST["account_email"];
    $account_password = md5($_POST['account_password']);
    $sql_email = "select * from account where account_email='$account_email'";
    $result_email = mysqli_query($conn, $sql_email);
    if (mysqli_num_rows($result_email)) {
        $sql_password = "select * from account where account_email='$account_email' AND account_password='$account_password' AND account_trangthai='1'";
        $result = mysqli_query($conn, $sql_password);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['account_loaitaikhoan'] == 3) {
                    if ($row['khachhang_trangthai'] == 0) {
?>
                        <div class="flash-data" data-flashdata=1></div>
                        <script>
                            const flashdata = $('.flash-data').data('flashdata')
                            if (flashdata) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Tài khoản của bạn đã bị đóng',
                                    text: 'Vui lòng liên hệ ViVuMekong để mở'
                                })
                            }
                        </script>
                    <?php
                    } else {
                        $_SESSION["acc_email"] = $account_email;
                        $_SESSION["acc_account_loaitaikhoan"] = $row['account_loaitaikhoan'];

                    ?>
                        <div class="flash-data" data-flashdata=1></div>
                        <script>
                            const flashdata = $('.flash-data').data('flashdata')
                            if (flashdata) {
                                Swal.fire(
                                    'Thành công!',
                                    'khách hàng đăng nhập thành công.',
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        location.href = '../khachhang/index.php';
                                    }
                                })
                            }
                        </script>
                    <?php
                    }
                } else if ($row['account_loaitaikhoan'] == 2) {
                    if ($row['daily_trangthai'] == 0) {
                    ?>
                        <div class="flash-data" data-flashdata=1></div>
                        <script>
                            const flashdata = $('.flash-data').data('flashdata')
                            if (flashdata) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Tài khoản đang được xem xét',
                                    text: 'Vui lòng chờ email phản hồi từ ViVuMekong'
                                })
                            }
                        </script>
                    <?php
                    } elseif ($row['daily_trangthai'] == 1) {
                        $_SESSION["acc_email"] = $account_email;
                        $_SESSION["acc_account_loaitaikhoan"] = $row['account_loaitaikhoan'];

                    ?>
                        <div class="flash-data" data-flashdata=1></div>
                        <script>
                            const flashdata = $('.flash-data').data('flashdata')
                            if (flashdata) {
                                Swal.fire(
                                    'Thành công!',
                                    'Doanh nghiệp đăng nhập thành công.',
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        location.href = '../vivumekong/gioithieu.php';
                                    }
                                })
                            }
                        </script>
                    <?php
                    } elseif ($row['daily_trangthai'] == 2) {
                    ?>
                        <div class="flash-data" data-flashdata=1></div>
                        <script>
                            const flashdata = $('.flash-data').data('flashdata')
                            if (flashdata) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'tài khoản bị từ chối',
                                    text: 'Có thể dịch vụ của bạn không phù hợp, vui lòng liên hệ ViVuMekong để được giải đáp'
                                })
                            }
                        </script>
                    <?php
                    } elseif ($row['daily_trangthai'] == 3) {
                    ?>
                        <div class="flash-data" data-flashdata=1></div>
                        <script>
                            const flashdata = $('.flash-data').data('flashdata')
                            if (flashdata) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'tài khoản doanh nghiệp của bạn đã bị đóng',
                                    text: 'Vui lòng liên hệ ViVuMekong để yêu cầu mở tài khoản'
                                })
                            }
                        </script>
                    <?php
                    }
                } else if ($row['account_loaitaikhoan'] == 1) {
                    $_SESSION["acc_email"] = $account_email;
                    $_SESSION["acc_account_loaitaikhoan"] = $row['account_loaitaikhoan'];
                    ?>
                    <div class="flash-data" data-flashdata=1></div>
                    <script>
                        const flashdata = $('.flash-data').data('flashdata')
                        if (flashdata) {
                            Swal.fire(
                                'Thành công!',
                                'admin đăng nhập thành công.',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = '../admin/doanhnghiep.php';
                                }
                            })
                        }
                    </script>
            <?php
                }
            }
            ?>
            <?php

            $student_id = "";
            $password = "";
            $check = false;
            if (isset($_COOKIE["student_id"]) && isset($_COOKIE["password"])) {
                $student_id = $_COOKIE["student_id"];
                $password = $_COOKIE["password"];
                $check = true;
            }
        } else {

            ?>
            <div class="flash-data" data-flashdata=1></div>
            <script>
                const flashdata = $('.flash-data').data('flashdata')
                if (flashdata) {
                    Swal.fire({
                        icon: 'error',
                        title: 'sai mật khẩu',
                        text: 'Vui lòng kiểm tra lại'
                    })
                }
            </script>
        <?php

        }
    } else {

        ?>
        <div class="flash-data" data-flashdata=1></div>
        <script>
            const flashdata = $('.flash-data').data('flashdata')
            if (flashdata) {
                Swal.fire({
                    icon: 'error',
                    title: 'tài khoản không tồn tại',
                    text: 'Vui lòng kiểm tra lại'
                })
            }
        </script>
<?php

    }
}


?>