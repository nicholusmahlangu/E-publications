<?php 
    session_start();
    $page_title = "Change Password";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="../assets/img/favicon.webp" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600|Nunito:300,400,600|Poppins:300,400,600" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

    <script>
        // JavaScript function to validate the password match and strength
        function validatePasswords() {
            var newPassword = document.getElementsByName("new_password")[0].value;
            var confirmPassword = document.getElementsByName("confirm_password")[0].value;
            var errorMessage = document.getElementById("error-message");
            var strengthMessage = document.getElementById("strength-message");

            // Check if passwords match
            if (newPassword !== confirmPassword) {
                errorMessage.style.display = 'block';  
                strengthMessage.style.display = 'none';  
                return false;  
            }

            var passwordStrengthRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[\W]).{8,}$/;

            // Check if the password matches the strength requirements
            if (!passwordStrengthRegex.test(newPassword)) {
                strengthMessage.style.display = 'block';  
                errorMessage.style.display = 'none';  
                return false;  
            }

            // If both checks pass, hide error messages and allow form submission
            errorMessage.style.display = 'none';
            strengthMessage.style.display = 'none';
            return true;
        }
    </script>

</head>
<body>
<div class="py-5">
    <div class="container">
        <div class="row" id="justify-content-center">
            <div class="col-md-6">

                <?php 
                    if(isset($_SESSION['status'])){
                        ?>
                        <div class="alert alert-success">
                            <h5><?= $_SESSION['status']; ?></h5>
                        </div>
                        <?php 
                            unset($_SESSION['status']); 
                    }
                ?>

                <div id="error-message" class="alert alert-danger" style="display:none;">
                    <h5>Passwords do not match!</h5>
                </div>

                <div id="strength-message" class="alert alert-danger" style="display:none;">
                    <h5>Password must be at least 8 characters long, contain one uppercase letter, one number, and one special character.</h5>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5>Change Password</h5>
                    </div>

                    <div class="card-body p-4">
                        <!-- Ensure the form calls the validatePasswords function on submit -->
                        <form action="send_password_reset.php" method="POST" onsubmit="return validatePasswords()">
                            <div class="form-group mb-3">
                                <input type="hidden" name="token" value="<?php if(isset($_GET['token'])){echo $_GET['token'];} ?>" class="form-control" placeholder="Enter Email Address">
                            </div>
                            <div class="form-group mb-3">
                                <label>Email Address</label>
                                <input type="text" name="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>" class="form-control" placeholder="Enter Email Address" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label>New Password</label>
                                <input type="password" name="new_password" class="form-control" placeholder="Enter New Password" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                            </div>

                            <div class="form-group mb-3">
                                <button type="submit" name="password_update" class="btn btn-success w-100">Update Password</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
