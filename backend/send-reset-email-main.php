<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/backend/PHPMailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/backend/PHPMailer/src/SMTP.php';
require $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/backend/PHPMailer/src/Exception.php';

function sendResetPasswordEmail($email, $resetLink, $username, $fullName)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hungrypaws.noreply@gmail.com';
        $mail->Password = 'ginl wlse yjjy qaks';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('hungrypaws.noreply@gmail.com', 'HungryPaws No Reply');

        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Password Reset";
        $mail->Body = "
        <table width='100%' cellpadding='0' cellspacing='0' style='font-family: Arial, sans-serif; background:#f7f9fc; padding: 40px 0;'>
            <tr>
                <td align='center'>
                    <table width='600' cellpadding='0' cellspacing='0' style='background:#ffffff; border-radius: 10px; padding: 30px; border:1px solid #e3e8f0;'>

                        <!-- Logo -->
                        <tr>
                            <td align='center' style='padding-bottom: 20px;'>
                                <img src='https://raw.githubusercontent.com/FranzMarlo/Portfolio/98cb30ce838197d291d51f0209394617de9f2a49/src/assets/hungrypaws.png' 
                                    alt='Hungry Paws Logo'
                                    style='width:140px; height:auto; margin-bottom:10px;' />
                            </td>
                        </tr>

                        <!-- Title -->
                        <tr>
                            <td align='center' style='padding-bottom: 20px;'>
                                <h2 style='margin:0; color:#2b74c7; font-size:24px;'>🐾 Password Reset Request</h2>
                            </td>
                        </tr>

                        <!-- Message -->
                        <tr>
                            <td style='color:#555; font-size:15px; line-height:1.6;'>
                                <p>Hello $fullName,</p>
                                <p>We received a request to reset your password for <strong>$username</strong>, your <strong>Hungry Paws</strong> account.</p>
                                <p>Kindly click the button below to continue:</p>                   
                            </td>
                        </tr>

                        <tr>
                            <td align='center' style='padding: 25px 0;'>
                                <a href='$resetLink'
                                style='background:#ff6fa8; color:#ffffff; padding: 12px 22px; border-radius: 6px;
                                        text-decoration:none; font-weight:bold; display:inline-block;'>
                                Reset Password
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td style='color:#555; font-size:14px; line-height:1.6;'>
                                <p>If the button above doesn't work, copy and paste this link into your browser:</p>
                                <p style='word-break:break-all;'>
                                    <a href='$resetLink' style='color:#2b74c7;'>$resetLink</a>
                                </p>
                                <p>If you didn't request this, you can safely ignore this email.</p>
                            </td>
                        </tr>

                        <tr>
                            <td align='center' style='padding-top:25px; color:#999; font-size:12px;'>
                                <p>Hungry Paws PH · SIMIS</p>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}
