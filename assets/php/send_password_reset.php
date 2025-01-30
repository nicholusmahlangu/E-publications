<?php //if user click continue button in forgot password form
    session_start();
    include 'conn.php';
    require "vendor/autoload.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    $email = "";
    $name = "";
    $errors = array();
    
    if(isset($_POST['check-email'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $check_email = "SELECT * FROM users WHERE email='$email'";
        $run_sql = mysqli_query($conn, $check_email);
        if(mysqli_num_rows($run_sql) > 0){
            $code = rand(999999, 111111);
            $insert_code = "UPDATE users SET Otp = $code WHERE email = '$email'";
            $run_query =  mysqli_query($conn, $insert_code);
            if($run_query){
                $subject = "Password Reset Code";
                $message = "Your password reset code is $code";
                $sender = "From: nicholus.mahlangu@nlsa.ac.za";
                if(mail($email, $subject, $message, $sender)){
                    $info = "We've sent a passwrod reset otp to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    header('location: reset_password.php');
                    exit();
                }else{
                    $errors['otp-error'] = "Failed while sending code!";
                }
            }else{
                $errors['db-error'] = "Something went wrong!";
            }
        }else{
            $errors['email'] = "This email address does not exist!";
        }
    }
?>