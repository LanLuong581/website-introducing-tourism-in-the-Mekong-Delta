<?php
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Mailer{
    public function dathangmail($tieude,$noidung,$maildathang){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->CharSet  = "utf-8";
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = "true";
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->Username = "thanhlan581@gmail.com";
        $mail->Password = "aulp lcnw abty txzs";
        $mail->Subject = $tieude;
        $mail->setFrom("thanhlan581@gmail.com");
        $mail->Body = $noidung;
        $mail->addAddress($maildathang);
        $mail->isHTML(true);
        if ($mail->send()) {
            header("location:../khachhang/mytour.php?send_mail=1");
        } else {
            $message = $mail->ErrorInfo;
        }
        $mail->smtpClose('');
    }

}
            

?>