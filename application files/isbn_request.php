<?php
    include 'forms_header.php';
    include '../assets/php/conn.php';

    require "vendor/autoload.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

function isValidSouthAfricanID($id_number) {
  if (!preg_match('/^\d{13}$/', $id_number)) {
      return false;
  }

  $dob = substr($id_number, 0, 6);
  $citizen = substr($id_number, 10, 1);
  $checksum = substr($id_number, -1);

  // Validate date of birth
  $year = substr($dob, 0, 2);
  $month = substr($dob, 2, 2);
  $day = substr($dob, 4, 2);
  $full_year = ($year < date('y')) ? '20' . $year : '19' . $year;
  if (!checkdate($month, $day, $full_year)) {
      return false;
  }

  // Validate citizenship (must be 0 for South Africans)
  if ($citizen !== '0') {
      return false;
  }

  // Validate using Luhn Algorithm
  return luhnCheck($id_number);
}

function luhnCheck($number) {
  $sum = 0;
  $alt = false;
  $digits = str_split(strrev($number));
  foreach ($digits as $i => $digit) {
      $num = (int) $digit;
      if ($alt) {
          $num *= 2;
          if ($num > 9) {
              $num -= 9;
          }
      }
      $sum += $num;
      $alt = !$alt;
  }
  return ($sum % 10) === 0;
}

        // Insert into the database
        $stmt = $conn->prepare(
            "INSERT INTO author (
            country, bookName,publisherName, publisherAddress, publisherContact, publisherEmail,
            format, publicationDate, externalPlatforms
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "sssssssss",
            $country, $bookName,
            $publisherName, $publisherAddress, $publisherContact, $publisherEmail,
            $format, $publicationDate, $externalPlatforms
        );

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // validate inputs
    $id_number = $_POST['id_number'];
    $country = htmlspecialchars($_POST['country']);
    $bookName = htmlspecialchars($_POST['bookName']);
    $publisherName = htmlspecialchars($_POST['publisherName']);
    $publisherAddress = htmlspecialchars($_POST['publisherAddress']);
    $publisherContact = htmlspecialchars($_POST['publisherContact']);
    $publisherEmail = htmlspecialchars($_POST['publisherEmail']);
    $format = htmlspecialchars($_POST['format']);
    $publicationDate = htmlspecialchars($_POST['publicationDate']);
    $externalPlatforms = htmlspecialchars($_POST['externalPlatforms']);

    if (!isValidSouthAfricanID($id_number)) {
      die("Invalid South African ID number.");
  }

    // Insert into the database
    $stmt = $conn->prepare(
        "INSERT INTO author (
            idNumber, country, bookName,
            publisherName, publisherAddress, publisherContact, publisherEmail, 
            format, publicationDate, externalPlatforms
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "ssssssssss",
        $id_number, $country, $bookName,
        $publisherName, $publisherAddress, $publisherContact, $publisherEmail,
        $format, $publicationDate, $externalPlatforms
    );

    $subject = "Request for ISBN from a Self Publisher";
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->isHTML(true);
            $mail->SMTPAuth   = true;
            $mail->Host       = "smtp.gmail.com";
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->Username   = "nicolasmahlangu75@gmail.com";
            $mail->Password   = "ykbq ecat ctyl avbb ";
            $mail->setFrom($publisherEmail, $publisherName);
            $mail->addAddress("nicholus.mahlangu@nlsa.ac.za", "Nicholus");
            //$mail->addAddress("Kholofelo.Mojela@nlsa.ac.za","Kholofelo");
            $mail->Subject = "$subject";
            $mail->Body="<html>
                     <head>
                         <title>Birthday Reminders for August</title>
                     </head>
                     <body>
                         <table  border=\"1\" cellspacing='3' width='60%'>
                             <tr>
                                 <td>Country:</td>
                                 <td>$country</td>
                             </tr>
                             <tr>
                                 <td>Email:</td>
                                 <td>$id_number</td>
                             </tr>
                             <tr>
                                 <td>Address:</td>
                                 <td>$bookName</td>
                             </tr>
                             <tr>
                                 <td>Phone:</td>
                                 <td>$publisherName</td>
                             </tr>
                             <tr>
                                 <td>Subject:</td>
                                 <td>$publisherAddress</td>
                             </tr>
                             <tr>
                                 <td>Services:</td>
                                 <td>$publisherContact</td>
                             </tr>
                             <tr>
                                 <td>Message:</td>
                                 <td>$publisherEmail</td>
                             </tr>
                         </table>
                     </body>
                 </html>";
            
            
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $mailto = "myself@example.com";
            $sub = "Get In Touch With Us";
            mail($mailto,$sub,$info,$headers);
            $contactsuccess = "Your message has been sent successfully! We will contact you shortly.";
            $name = $email = $address = $phone = $service = $subject =  $message ="";

            if ($mail->send()) {
                $successMessage = "Form submitted successfully.";

                $to      = $publisherEmail;
                $subject = "ISBN Request Sent Successfully";

                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->SMTPAuth   = true;
                $mail->Host       = "smtp.gmail.com";
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;
                $mail->Username   = "nicolasmahlangu75@gmail.com";
                $mail->Password   = "ykbq ecat ctyl avbb ";
                $mail->setFrom($publisherEmail, $publisherName);
                $mail->addAddress($publisherEmail, $publisherName);
                //$mail->addAddress("Kholofelo.Mojela@nlsa.ac.za","Kholofelo");
                $mail->Subject = "$subject";
                $mail->Body    = "Your request for an ISBN as a Self Publisher has been sent to one of our NLSA ISBN Administrators for the book: $bookName by: $publisherName Email addresss: $publisherEmail. We mainly testing the system neh. Thank you";
                echo "Please check your mail. Email sent!";
            }
        } else {
            $errorMessage = "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Self-publisher ISBN Request Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<style>
    h1{
      margin-top: 60px;
    }
    .logo-img{
      margin-top: 60px;
    }
    body {
            background-image: url('../assets/img/BackgroundI.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #333
        }
</style>
</head>
<body>

<div class="container mt-5">
        <center>
            <img src="../assets/img/NLSA-logo.png" class="logo-img" alt="NLSA Logo"style="width:25%; height:20%">
        </center>
  <h1 class="text-center mb-4">Self-publisher ISBN Request Form</h1>

  <!-- Display Success/Error Messages -->
  <?php if (! empty($successMessage)): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($successMessage)?></div>
  <?php elseif (! empty($errorMessage)): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage)?></div>
  <?php endif; ?>

  <form id="isbnForm" action="" method="POST" class="needs-validation" novalidate>
    <!-- Country Selection -->
    <div class="mb-3">
      <label for="country" class="form-label">Select Your Country</label>
      <select id="country" name="country" class="form-select" required>
        <option value="" selected>— Select a country —</option>

            <!-- African Countries -->
    <optgroup label="Africa">
      <option data-code="+213" value="Algeria">🇩🇿 Algeria</option>
      <option data-code="+244" value="Angola">🇦🇴 Angola</option>
      <option data-code="+229" value="Benin">🇧🇯 Benin</option>
      <option data-code="+267" value="Botswana">🇧🇼 Botswana</option>
      <option data-code="+226" value="Burkina Faso">🇧🇫 Burkina Faso</option>
      <option data-code="+257" value="Burundi">🇧🇮 Burundi</option>
      <option data-code="+237" value="Cameroon">🇨🇲 Cameroon</option>
      <option data-code="+238" value="Cape Verde">🇨🇻 Cape Verde</option>
      <option data-code="+236" value="Central African Republic">🇨🇫 Central African Republic</option>
      <option data-code="+235" value="Chad">🇹🇩 Chad</option>
      <option data-code="+269" value="Comoros">🇰🇲 Comoros</option>
      <option data-code="+242" value="Congo (Brazzaville)">🇨🇬 Congo (Brazzaville)</option>
      <option data-code="+243" value="Congo (Kinshasa)">🇨🇩 Congo (Kinshasa)</option>
      <option data-code="+253" value="Djibouti">🇩🇯 Djibouti</option>
      <option data-code="+20" value="Egypt">🇪🇬 Egypt</option>
      <option data-code="+240" value="Equatorial Guinea">🇬🇶 Equatorial Guinea</option>
      <option data-code="+291" value="Eritrea">🇪🇷 Eritrea</option>
      <option data-code="+251" value="Ethiopia">🇪🇹 Ethiopia</option>
      <option data-code="+241" value="Gabon">🇬🇦 Gabon</option>
      <option data-code="+220" value="Gambia">🇬🇲 Gambia</option>
      <option data-code="+233" value="Ghana">🇬🇭 Ghana</option>
      <option data-code="+224" value="Guinea">🇬🇳 Guinea</option>
      <option data-code="+245" value="Guinea-Bissau">🇬🇼 Guinea-Bissau</option>
      <option data-code="+225" value="Ivory Coast">🇨🇮 Ivory Coast</option>
      <option data-code="+254" value="Kenya">🇰🇪 Kenya</option>
      <option data-code="+266" value="Lesotho">🇱🇸 Lesotho</option>
      <option data-code="+231" value="Liberia">🇱🇷 Liberia</option>
      <option data-code="+218" value="Libya">🇱🇾 Libya</option>
      <option data-code="+261" value="Madagascar">🇲🇬 Madagascar</option>
      <option data-code="+265" value="Malawi">🇲🇼 Malawi</option>
      <option data-code="+223" value="Mali">🇲🇱 Mali</option>
      <option data-code="+222" value="Mauritania">🇲🇷 Mauritania</option>
      <option data-code="+230" value="Mauritius">🇲🇺 Mauritius</option>
      <option data-code="+212" value="Morocco">🇲🇦 Morocco</option>
      <option data-code="+258" value="Mozambique">🇲🇿 Mozambique</option>
      <option data-code="+264" value="Namibia">🇳🇦 Namibia</option>
      <option data-code="+227" value="Niger">🇳🇪 Niger</option>
      <option data-code="+234" value="Nigeria">🇳🇬 Nigeria</option>
      <option data-code="+250" value="Rwanda">🇷🇼 Rwanda</option>
      <option data-code="+290" value="Saint Helena">🇸🇭 Saint Helena</option>
      <option data-code="+221" value="Senegal">🇸🇳 Senegal</option>
      <option data-code="+248" value="Seychelles">🇸🇨 Seychelles</option>
      <option data-code="+232" value="Sierra Leone">🇸🇱 Sierra Leone</option>
      <option data-code="+27" value="South Africa">🇿🇦 South Africa</option>
      <option data-code="+211" value="South Sudan">🇸🇸 South Sudan</option>
      <option data-code="+249" value="Sudan">🇸🇩 Sudan</option>
      <option data-code="+268" value="Eswatini">🇸🇿 Eswatini</option>
      <option data-code="+255" value="Tanzania">🇹🇿 Tanzania</option>
      <option data-code="+228" value="Togo">🇹🇬 Togo</option>
      <option data-code="+216" value="Tunisia">🇹🇳 Tunisia</option>
      <option data-code="+256" value="Uganda">🇺🇬 Uganda</option>
      <option data-code="+260" value="Zambia">🇿🇲 Zambia</option>
      <option data-code="+263" value="Zimbabwe">🇿🇼 Zimbabwe</option>
    </optgroup>

    <!-- Rest of the World -->
    <optgroup label="World">
      <option data-code="+1" value="USA">🇺🇸 USA</option>
      <option data-code="+44" value="UK">🇬🇧 UK</option>
      <option data-code="+91" value="India">🇮🇳 India</option>
      <option data-code="+61" value="Australia">🇦🇺 Australia</option>
      <option data-code="+81" value="Japan">🇯🇵 Japan</option>
      <option data-code="+86" value="China">🇨🇳 China</option>
      <option data-code="+49" value="Germany">🇩🇪 Germany</option>
      <option data-code="+33" value="France">🇫🇷 France</option>
      <option data-code="+7" value="Russia">🇷🇺 Russia</option>
      <option data-code="+55" value="Brazil">🇧🇷 Brazil</option>
    </optgroup>
      </select>
      <div class="invalid-feedback">Please select a country.</div>
    </div>

    <!-- other Fields -->
    <div class="mb-5">
    <label for="id_number" class="form-label">ID Number:</label>
    <input type="text" name="id_number" required pattern="\d{13}" title="Enter a valid 13-digit South African ID number." class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="bookName" class="form-label">Title/Name of the Book(s)</label>
      <input type="text" id="bookName" name="bookName" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="publisherName" class="form-label">Publisher Name</label>
      <input type="text" id="publisherName" name="publisherName" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="publisherAddress" class="form-label">Publisher Address</label>
      <input type="text" id="publisherAddress" name="publisherAddress" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="publisherContact" class="form-label">Publisher Contact</label>
      <input type="text" id="publisherContact" name="publisherContact" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="publisherEmail" class="form-label">Publisher Email</label>
      <input type="email" id="publisherEmail" name="publisherEmail" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="format" class="form-label">Format</label>
      <select id="format" name="format" class="form-select" required>
        <option value="">—Please choose an option—</option>
        <option value="Hardcover">Print</option>
        <option value="Paperback">Electronic</option>
        <option value="Digital">Both</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="publicationDate" class="form-label">Estimated Publication Date</label>
      <input type="text" id="publicationDate" name="publicationDate" class="form-control datepicker" required>
    </div>

    <div class="mb-3">
      <label for="externalPlatforms" class="form-label">External Publishing Platforms</label>
      <input type="text" id="externalPlatforms" name="externalPlatforms" class="form-control" placeholder="e.g. Amazon" required>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>

<script>
  // Update country code when a country is selected
  document.getElementById('country').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const countryCode = selectedOption.getAttribute('data-code');
    document.getElementById('countryCode').textContent = countryCode || '';
  });

  // Initialize datepicker
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    startDate: new Date() // Restrict to today and future dates
  });

  // Bootstrap form validation
  (() => {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  })();
</script>
</body>
</html>
