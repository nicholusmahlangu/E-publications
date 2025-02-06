<?php 
    include ('../assets/php/conn.php');
    
    require "vendor/autoload.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    function send_password_reset($get_name, $get_email,$token){
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->Host = "smtp.gmail.com";
        $mail->Username = "nicolasmahlangu75@gmail.com";
        $mail->Password = "ykbq ecat ctyl avbb ";
        $mail->setFrom("nicolasmahlangu75@gmail.com", $get_name);
        $mail->addAddress($get_email);

        $mail->isHTML(true);
        $mail->Subject = "Reset Paassword Notification";

        $email_template = "
        <h2>Hi, how are you?<h2>
        <h3>You are receiving this email because we received a password reset request for your account.</h3>
        <br/><br/>
        <a href='http://localhost:81/e-publications/application files/reset_password.php?token=$token&email=$get_email'>Click Me</a> 
        ";

        $mail->Body = $email_template;
        $mail->send();

    }

    if (isset($_POST['send_password_reset'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $token = md5(rand());

        $check_email = "SELECT * FROM users WHERE EmailAddress = '$email' LIMIT 1";
        $check_email_run = mysqli_query($conn, $check_email);

        if (mysqli_num_rows($check_email_run) > 0) {
            $row = mysqli_fetch_array($check_email_run);
            $get_name = $row['FullName'];
            $get_email = $row['EmailAddress'];
            $date = getdate();
            $mydate = $date['mon']."/".$date['day']."/".$date['year'];
            // $time = strtotime('$mydate');
            // $newformat = date('Y-M-D hh:mm:ss');

            $update_token = "UPDATE users SET verify_token ='$token',created_at ='$mydate',verify_status =1  WHERE EmailAddress = '$get_email' LIMIT 1";
            $update_token_run = mysqli_query($conn,$update_token);           

            if($update_token_run){
                send_password_reset($get_name, $get_email,$token);
                $_SESSION['status'] = "We e-mailed you a password reset link";
                header("Location: forgot_password.php");
                exit(0);
            }
            else{
                $_SESSION['status']="Something went wrong. #1";
                header("forgot_password.php");
                exit(0);
            }
        }
        else{
            $_SESSION['status'] = "No Email Found";
            header("Location: forgot_password.php");
        }
    }

    if(isset($_POST['password_update'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
        $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
        $token = mysqli_real_escape_string($conn, $_POST['password_token']);
        
        if(!empty($token)){

            if(!empty($email) && !empty($new_password) && !empty($confirm_password)){
                $check_token = "SELECT verify_token FROM users WHERE verify_token LIMIT 1";
                $check_token_run = mysqli_query($conn, $check_token);

                if(mysqli_num_rows($check_token_run) > 0){
                    if($new_password == $confirm_password){
                        $update_password = "UPDATE users SET ";
                    }
                    else{
                        $_SESSION['status'] = "Password and confirm Password does not match";
                        header("Location: reset_password.php?token=$token&email=$email");
                        exit(0);
                    }
                }
                else{
                    $_SESSION['status'] = "Invalid Token";
                    header("Location: forgot_password.php?token=$token&email=$email");
                    exit(0);
                }
            }
            else{
                $_POST['status'] = "All fields must be filled";
                header("Location: forgot_password.php?token=$token&email=$email");
                exit(0);
            }
        }

    }else{
        $_SESSION['status']="No Token Available";
        header("Location: forgot_password.php");
        exit(0);
    }
?>