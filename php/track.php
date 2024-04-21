<?php
include 'LocationTracker.php';

// Instantiate the LocationTracker class
$tracker = new LocationTracker();

// Fetch location information
$location = $tracker->getLocation();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Track My Location</title>
    <link rel="stylesheet" href="../css/track.css">
</head>

<body>
    <div class="navigation-bar">
        <a href="home.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="track.php" class="active">Refresh</a>
    </div>

    <h1>Track My Location</h1>
    <button onclick="getLocation()">Track Location</button>
    <div id="location-display">
        <?php
        if (isset($location['latitude']) && isset($location['longitude'])) {
            echo "Latitude: " . $location['latitude'] . "<br>Longitude: " . $location['longitude'];
        } elseif (isset($location['error'])) {
            echo $location['error'];
        } else {
            echo "Location will be displayed here.";
        }
        ?>
    </div>

    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                document.getElementById("location-display").innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            const lat = position.coords.latitude;
            const long = position.coords.longitude;
            document.getElementById("location-display").innerHTML = "Latitude: " + lat + "<br>Longitude: " + long;

            // Optionally, send this information to the server to save it
            saveLocation(lat, long);
        }

        function showError(error) {
            let message = "";
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    message = "User denied the request for Geolocation.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    message = "Location information is unavailable.";
                    break;
                case error.TIMEOUT:
                    message = "The request to get user location timed out.";
                    break;
                default:
                    message = "An unknown error occurred.";
                    break;
            }
            document.getElementById("location-display").innerHTML = message;
        }

        function saveLocation(lat, long) {
            // Code to send latitude and longitude to the server to save it
            // You can use AJAX to send this data to a PHP script for database insertion
        }
    </script>
</body>

</html>