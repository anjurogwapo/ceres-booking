<?php
session_start(); // Start or resume a session

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: /Ceresfinal/php/login.php");
    exit;
}

// Handle the "Back" button functionality using JavaScript
echo "<script>
function goBack() {
  window.history.back();
}
</script>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CERES LINER</title>
    <link rel="stylesheet" href="home.css">
    <style>
        body {
            margin: 0;
            font-family: Poppins, Arial, sans-serif;
            /* Change font to Poppins */
            color: #333;
            background-image: url('homepage.gif');
            /* Set background image */
            background-size: cover;
            background-repeat: no-repeat;
        }

        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
        }

        .profile-header a {
            color: #ffd700;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .profile-header a:hover {
            background-color: #ffd700;
            color: #333;
        }

        button {
            background-color: #ffd700;
            color: #333;
            border: none;
            padding: 15px 30px;
            /* Increased padding */
            font-size: 18px;
            /* Increased font size */
            cursor: pointer;
            border-radius: 10px;
            /* Slightly bigger border radius */
            transition: background-color 0.3s ease;
            font-family: Poppins, Arial, sans-serif;
            /* Change font to Poppins */
        }

        .image-container {
            position: absolute;
            top: 60px;
            /* Adjust as needed */
            left: 20px;
            /* Adjust as needed */
            width: 814px;
            height: 396px;
            flex-shrink: 0;
            border-radius: 140px;
            border: 10px solid #9F3900;
            background: url('ceres1.gif') lightgray 50% / cover no-repeat;
        }

        .button-container {
            position: absolute;
            top: 20px;
            right: 20px;
            /* Adjust top and right values as needed */
            display: flex;
            align-items: center;
        }

        .circle-button {
            width: 90px;
            /* Increased button size */
            height: 90px;
            /* Increased button size */
            border-radius: 140px;
            border: 4px solid #9F3900;
            /* Change button color */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            /* Adjust spacing */
            cursor: pointer;
            fill: #FFB800;
            /* Fill color */
            stroke-width: 5%;
            /* Stroke width */
            stroke: #000000;
            /* Stroke color */
        }

        .circle-button-text {
            font-family: Poppins, sans-serif;
            /* Change font to Poppins */
            font-size: 14px;
            /* Adjust font size */
            color: white;
            margin-top: 5px;
            text-align: center;
            font-weight: bold;
            /* Make font weight bold */
        }

        .ceres-button {
            position: absolute;
            top: 60px;
            right: 20px;
            /* Adjust top and right values as needed */
            width: 327px;
            height: 312px;
            flex-shrink: 0;
            border-radius: 16px;
            border: 2px solid var(--Colors-Black, #000);
            background: var(--Colors-White, #FFF);
            box-shadow: 0px 6px 0px 0px #18191F;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Poppins, Arial, sans-serif;
            /* Change font to Poppins */
        }

        .ceres-content {
            width: 279px;
            color: var(--Colors-Black, #000);
            text-align: center;
            font-family: Poppins, Arial, sans-serif;
            /* Change font to Poppins */
        }

        .ceres-content h2 {
            font-size: 36px;
            font-style: normal;
            font-weight: 800;
            line-height: 40px;
            margin-bottom: 10px;
        }

        .ceres-content p {
            color: var(--Colors-Black-800, #474A57);
            font-size: 15px;
            font-style: normal;
            font-weight: 500;
            line-height: 20px;
            margin-bottom: 20px;
        }

        .ceres-content button {
            width: 279px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            border-radius: 16px;
            background: #FF6A16;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .ceres-content button:hover {
            background-color: #FF893D;
        }

        .ceres-image {
            position: absolute;
            top: 400px;
            right: 20px;
            /* Adjust top and right values as needed */
            width: 300px;
            height: 200px;
            flex-shrink: 0;
            border-radius: 114.5px;
            border: 10px solid #9F3900;
            background: url('cerespasalubong.gif') lightgray 50% / cover no-repeat;
        }
    </style>
</head>

<body>
    <div class="profile-header">
        <span>CERES LINER</span>
        <div>
            <a href="book.php">Book</a>
            <a href="track.php">Track</a>
            <a href="updates.php">Updates</a>
            <a href="profile.php">Profile</a>
        </div>
    </div>

    <div class="button-container">
        <button onclick="goBack()">Back</button>
    </div>

    <div class="image-container"></div>

    <div class="button-container">
        <div class="circle-button" onclick="window.location.href='https://www.facebook.com/profile.php?id=100067808630784'">
            <div class="circle-button-text">Facebook Page</div>
        </div>
        <div class="circle-button" onclick="window.location.href='https://ygbc.com.ph/subsidiary-companies/vallacar-transit/'">
            <div class="circle-button-text">Vallacar Transit</div>
        </div>
        <div class="circle-button" onclick="window.location.href='https://ygbc.com.ph/'">
            <div class="circle-button-text">Yanson Group</div>
        </div>
    </div>

    <div class="ceres-button">
        <div class="ceres-content">
            <h2 style="font-family: Poppins, Arial, sans-serif; 
                   font-size: 28px;  
                   font-weight: bold; 
                   color: #333; 
                   margin-bottom: 12px;">CERES PASALUBONG</h2>
            <p style="font-family: Poppins, Arial, sans-serif; 
                  font-size: 20px; 
                  margin-bottom: 25px;">Experience Filipino flavors at Ceres Pasalubong, <br> where every bite is crafted with love and tradition.</p>
            <button onclick="window.location.href='https://cerespasalubong.com/pages/about-us';" style="font-family: Poppins, Arial, sans-serif; 
                       font-size: 18px; 
                       font-weight: bold; 
                       color: #fff; 
                       background-color: #FF6A16; 
                       border: none; 
                       padding: 12px 20px; 
                       border-radius: 8px; 
                       cursor: pointer; 
                       transition: background-color 0.4s ease;">
                VISIT
            </button>
        </div>
    </div>



    <div class="ceres-image"></div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>