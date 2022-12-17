<?php
$connect = new PDO("mysql:host=localhost;dbname=dulichdbscl", "root", "");
include('../config/constants.php');
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$error_otp = '';
$account_email = '';
$message = '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style4.css">
    <title>ViVuMekong</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap');
    </style>
</head>

<body>
    <div class="background" style="padding-top: 0;">
        <div class="container" style="padding-top: 100px;">
            <div class="otp-form">
                <div class="title">
                    <p style="font-family: 'Cinzel', serif;font-size:60px;text-align: center;color:#0096c7;">ViVuMekong</p>
                </div>

                <form id="otp" class="input-otp-group" method="post">
                    <input type="text" class="input-field" placeholder="Mã OTP" name="account_OTP" id="account_OTP" style="width:360px" required>
                    
                    <button type="submit" class="submit-otp-btn" name="submit_otp" id="submit_otp" style="margin-top: 10px;">Xác Nhận</button>
                </form>

            </div>

        </div>
    </div>


    <script src="../js/bootstrap.js"></script>
    <script src="../jquery/jquery-3.6.0.min.js"></script>
</body>

</html>
<?php
if (isset($_GET["account_email"])) {
    $account_email = $_GET["account_email"];
    if (isset($_POST["submit_otp"])) {
        if (empty($_POST["account_OTP"])) {
            $error_otp = '<label class="text-danger">Vui lòng nhập mã OTP để hoàn tất đăng ký</label>';
        } else {
            $query = "select * from account where account_email='" . $account_email . "' and account_OTP='" . trim($_POST["account_OTP"]) . "'";
            $statement = $connect->prepare($query);
            $statement->execute();
            $total_row = $statement->rowCount();
            if ($total_row > 0) {

                $sql_update = "update account set account_trangthai='1' where account_email='" . $account_email . "' ";
                $statement = $connect->prepare($sql_update);
                if ($statement->execute()) {
                    // 
                    $sql_account = "SELECT * FROM account WHERE account_id= (SELECT MAX(account_id) FROM account);";
                    $result_account = mysqli_query($conn, $sql_account);
                    if (mysqli_num_rows($result_account)) {
                        while ($row = mysqli_fetch_assoc($result_account)) {
                            $account_loaitaikhoan = $row['account_loaitaikhoan'];
                        }
                        // nếu là tài khoản doanh nghiệp
                        if ($account_loaitaikhoan == '2') {
                            $sql_email_admin = "select account_email from account where account_loaitaikhoan='1'";
                            $result_email_admin = mysqli_query($conn, $sql_email_admin);
                            if (mysqli_num_rows($result_email_admin)) {
                                while ($email_admin = mysqli_fetch_assoc($result_email_admin)) {
                                    $account_email_admin = $email_admin['account_email'];
                                }
                                $mail = new PHPMailer();
                                $mail->isSMTP();
                                $mail->CharSet  = "utf-8";
                                $mail->Host = "smtp.gmail.com";
                                $mail->SMTPAuth = "true";
                                $mail->SMTPSecure = "tls";
                                $mail->Port = 587;
                                $mail->Username = "thanhlan581@gmail.com";
                                $mail->Password = "aulp lcnw abty txzs";
                                $mail->Subject = "ViVuMekong có doanh nghiệp cần duyệt";
                                $mail->setFrom("thanhlan581@gmail.com");
                                $mail->Body = "Xin chào $account_email_admin,<br>
                                    ViVuMekong có doanh nghiệp đăng ký tài khoản, vui lòng truy cập website để duyệt tài khoản cho doanh nghiệp<br>
                                    Xin cám ơn";
                                $mail->addAddress($account_email_admin);
                                $mail->isHTML(true);
                                if ($mail->send()) {
                                    header("../khachhang/index.php");
                                } else {
                                    $message = $mail->ErrorInfo;
                                }
                                $mail->smtpClose('');
                            }
?>
                            <div class="flash-data" data-flashdata=1></div>
                            <script>
                                const flashdata = $('.flash-data').data('flashdata')
                                if (flashdata) {
                                    Swal.fire(
                                        'Xác thực OTP thành công.',
                                        'Vui lòng đợi email phản hồi từ ViVuMekong',
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
                        //nếu là tài khoản khách hàng
                        elseif ($account_loaitaikhoan == '3') {
                        ?>
                            <div class="flash-data" data-flashdata=1></div>
                            <script>
                                const flashdata = $('.flash-data').data('flashdata')
                                if (flashdata) {
                                    Swal.fire(
                                        'Xác thực OTP thành công.',
                                        'Tiến hành đăng nhập',
                                        'success'
                                    ).then((result) => {
                                        if (result.isConfirmed) {
                                            location.href = 'login.php';

                                        }
                                    })
                                }
                            </script>
                        <?php
                        } else {
                        ?>
                            <div class="flash-data" data-flashdata=1></div>
                            <script>
                                const flashdata = $('.flash-data').data('flashdata')
                                if (flashdata) {
                                    Swal.fire(
                                        'Tài khoản chưa xác định.',
                                        'Tiến hành đăng nhập',
                                        'error'
                                    ).then((result) => {
                                        if (result.isConfirmed) {
                                            location.href = 'login.php';

                                        }
                                    })
                                }
                            </script>
                <?php
                        }
                    }


                    // 


                }
            } else {
                ?>
                <div class="flash-data" data-flashdata=1></div>
                <script>
                    const flashdata = $('.flash-data').data('flashdata')
                    if (flashdata) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Mã OTP chưa đúng',
                            text: 'Vui lòng kiểm tra lại!'
                        })
                    }
                </script>
<?php
            }
        }
    }
}
?>