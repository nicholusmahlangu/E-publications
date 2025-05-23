<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/img/favicon.webp" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" 
          rel="stylesheet">
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Ion Icons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script defer type="text/javascript" src="../assets/js/signup.js"></script>
    <link rel="stylesheet" href="../assets/css/signup.css"> 
    <title>Sign Up</title>
    <style>
      .body {
            width: 100%;
        }

        .panel {
            border: 1px solid red;
            background-color: blue;
            margin: 50px;
        }
        img {
            width: 100%;
        }

        .logo {
            background-color: red;
            border: 1px solid yellow;
            width: 100px;

        }
      .back-button {
background-color:rgb(28, 28, 28); /* green background */
color: #fff; /* white text */
padding: 5px 10px; /* add some padding */
border: none; /* remove border */
border-radius: 5px; /* rounded corners */
cursor: pointer; /* change cursor on hover */
transition: background-color 0.3s ease-in-out; /* smooth transition */
display: inline-flex; /* add inline-flex display */
align-items: center; /* center icon and text */
font-size: 16px; /* set font size */
}

.back-button i {
margin-right: 5px; /* add some space between icon and text */
font-size: 18px; /* set font size for icon */
}

.back-button:hover {
background-color:rgb(113, 111, 114); /* darker green on hover */
text-decoration: none;

}

 
    </style>

</head>
<body>
    
    <div class="container text-center logo-container"> 
        <img src="../assets/img/NLSA-logo.png" class="logo-img" alt="NLSA Logo"style="width:30%; height:30%">
    </div>

         <!-- Home Button Icon -->
         <div class="back-button-container">
        <a href="adminDashboard.php" class="back-button">
           <i class="bi bi-arrow-left"></i>
            Admin Dashboard
        </a>
    </div>
    <div class="wrapper">
            <!-- Logo and Heading -->
        <!-- <div class="container text-center logo-container">
            
            <img src="../assets/img/NLSA-logo.png" class="logo-img" alt="NLSA Logo"style="width:22%; height:22%">
                <h1 class="system-heading">SIGN UP</h1>
        </div> -->
        <!-- <div class="side-left">
            <img src="../assets/img/photo 5.png" alt="Illustration" class="img-fluid">
        </div> -->

        <h2>Add Cataloguer</h2>
        <p id="error-text"></p>
        <?php 
            if (isset($_SESSION['status'])) {

                ?>
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                        <div>
                            <?php echo $_SESSION['status']; ?>
                        </div>
                    </div>
                <?php
                unset($_SESSION['status']);
            }
                ?>
             
             <?php if(isset($_SESSION['error'])){     
                ?><div class="alert alert-danger d-flex align-items-center" role="alert">
  <svg class="bi flex-shrink-e-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                            <?php echo $_SESSION['error']; ?>
                        </div>
                    </div>
                    <?php
                    unset($_SESSION['error']);
                }  
        ?>
        <form id="form" method="post" action="../assets/php/addCataloguers.php">
            <div>
                <label for="full-name-input">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Z"/></svg>
                </label>
                <input type="text" name="fullname" id="full-name-input" placeholder="Full Name">
            </div>
            <div>
                <label for="input-email">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280 320-200v-80L480-520 160-720v80l320 200Z"/></svg>
                </label>
                <input type="email" name="email_address" id="input-email" placeholder="Email address">
            </div>
            <div>
                <label for="input-contact">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);"><path d="M16.57 22a2 2 0 0 0 1.43-.59l2.71-2.71a1 1 0 0 0 0-1.41l-4-4a1 1 0 0 0-1.41 0l-1.6 1.59a7.55 7.55 0 0 1-3-1.59 7.62 7.62 0 0 1-1.59-3l1.59-1.6a1 1 0 0 0 0-1.41l-4-4a1 1 0 0 0-1.41 0L2.59 6A2 2 0 0 0 2 7.43 15.28 15.28 0 0 0 6.3 17.7 15.28 15.28 0 0 0 16.57 22zM6 5.41 8.59 8 7.3 9.29a1 1 0 0 0-.3.91 10.12 10.12 0 0 0 2.3 4.5 10.08 10.08 0 0 0 4.5 2.3 1 1 0 0 0 .91-.27L16 15.41 18.59 18l-2 2a13.28 13.28 0 0 1-8.87-3.71A13.28 13.28 0 0 1 4 7.41zM20 11h2a8.81 8.81 0 0 0-9-9v2a6.77 6.77 0 0 1 7 7z"></path><path d="M13 8c2.1 0 3 .9 3 3h2c0-3.22-1.78-5-5-5z"></path></svg>
                </label>
                <input type="text" name="contact" id="input-contact" placeholder="Contact no">
            </div>
           
            <div>
                <label for="password-input">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z"/></svg>
                </label>
                <input type="password" name="password" id="password-input" placeholder="Password">
            </div>
            <div>
                <label for="confirm-password-input">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M80-200v-80h800v80H80Zm46-242-52-30 34-60H40v-60h68l-34-58 52-30 34 58 34-58 52 30-34 58h68v60h-68l34 60-52 30-34-60-34 60Zm320 0-52-30 34-60h-68v-60h68l-34-58 52-30 34 58 34-58 52 30-34 58h68v60h-68l34 60-52 30-34-60-34 60Zm320 0-52-30 34-60h-68v-60h68l-34-58 52-30 34 58 34-58 52 30-34 58h68v60h-68l34 60-52 30-34-60-34 60Z"/></svg>
                </label>
                <input type="password" name="confirm_password"  id="confirm-password-input" placeholder="Confirm Password">
            </div>
            <button type="submit" id="submit">Add</button>
        </form>
    </div>
    <a href="index.php" class="home-icon">
        <i class="bi bi-house-fill"></i> Home
    </a>
</body>
</html>