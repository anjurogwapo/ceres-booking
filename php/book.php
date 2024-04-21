<?php
session_start();
include 'db.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or show a message
    header('Location: login.php');
    exit; // Ensure no further code is executed before redirect
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT seat_number, status FROM seat_reservations WHERE user_id = ? ORDER BY seat_number ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$seats = [];
while ($row = $result->fetch_assoc()) {
    $seats[$row['seat_number']] = $row['status'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bus Booking</title>
    <link rel="stylesheet" href="../css/book.css">
</head>

<body>

    <div class="navigation">
        <a href="home.php">CERES LINER</a>
        | <a href="book.php">Book</a>
        | <a href="track.php">Track</a>
        | <a href="updates.php">Updates</a>
        | <a href="profile.php">Profile</a>
        | <a href="home.php">Home</a>
    </div>

    <div class="main-container">

        <div class="bus-container">
            <div class="driver-area">Driver</div>
            <?php for ($i = 1; $i <= 32; $i++) : ?>
                <?php if ($i % 4 == 1) : ?>
                    <div class="row">
                    <?php endif; ?>

                    <div class="seat <?= isset($seats[$i]) ? 'reserved' : ''; ?>" data-seat-number="<?= $i; ?>">S<?= $i; ?></div>

                    <?php if ($i % 2 == 0 && $i % 4 != 0) : ?>
                        <div class="aisle"></div> <!-- Aisle after every two seats -->
                    <?php endif; ?>

                    <?php if ($i % 4 == 0) : ?>
                    </div> <!-- Close the row -->
                <?php endif; ?>
            <?php endfor; ?>
        </div>

        <div class="booking-controls">

            <select id="destination" onchange="updateMap()">
                <option value="Silay City, Negros Occidental">Silay City</option>
                <option value="Talisay City, Negros Occidental">Talisay City</option>
                <option value="Victorias City, Negros Occidental">Victorias City</option>
            </select>

            <!-- Total Price Display -->
            <div class="total-price">Total Price: ₱0</div>

            <!-- Checkout Button -->
            <button id="checkout">Check Out</button>

            <!-- Cancel Booking Button -->
            <button id="cancelBooking">Cancel Booking</button>

            <div id="map-container" style="margin-top: 20px;">
                <iframe id="mapFrame" width="700" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>

            <script>
                function updateMap() {
                    var cityMap = {
                        "Silay City, Negros Occidental": "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125431.18117217653!2d123.0079462138142!3d10.755709935999125!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33aed61aecc67287%3A0x420b7cea0efc5e27!2sSilay%20City%2C%20Negros%20Occidental!5e0!3m2!1sen!2sph!4v1709517850701!5m2!1sen!2sph",
                        "Talisay City, Negros Occidental": "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125456.97598777601!2d123.00570751282397!3d10.693503945876333!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33aed697a1b3bf85%3A0xd9d283bf68690385!2sTalisay%20City%2C%20Negros%20Occidental!5e0!3m2!1sen!2sph!4v1709518421440!5m2!1sen!2sph",
                        "Victorias City, Negros Occidental": "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62692.735732312285!2d123.0537403543964!3d10.865077607870205!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33af2d28f196044d%3A0xf27d45c201b83d0b!2sVictorias%20City%2C%20Negros%20Occidental!5e0!3m2!1sen!2sph!4v1709518458989!5m2!1sen!2sph"
                    };

                    // Adjusting to use 'destination' as the ID
                    var destinationSelect = document.getElementById("destination");
                    var selectedCity = destinationSelect.value;
                    var mapFrame = document.getElementById("mapFrame");
                    mapFrame.src = cityMap[selectedCity];
                }

                // Initialize the map with the first selection
                document.addEventListener('DOMContentLoaded', function() {
                    updateMap();
                }, false);

                document.addEventListener('DOMContentLoaded', function() {
                    const seats = document.querySelectorAll('.seat:not(.reserved)');
                    const total = document.querySelector('.total-price');
                    let totalPrice = 0;

                    const pricePerDestination = {
                        "Silay City, Negros Occidental": 15,
                        "Talisay City, Negros Occidental": 12,
                        "Victorias City, Negros Occidental": 30
                    };
                    const destinationSelect = document.getElementById('destination');
                    const checkoutButton = document.getElementById('checkout');
                    const cancelButton = document.getElementById('cancelBooking'); // Get the cancel button

                    seats.forEach(function(seat) {
                        seat.addEventListener('click', function() {
                            if (seat.classList.contains('selected')) {
                                seat.classList.remove('selected');
                            } else {
                                seat.classList.add('selected');
                            }
                            updateTotalPrice();
                            updateCancelButtonVisibility();
                        });
                    });

                    cancelButton.addEventListener('click', function() {
                        const selectedSeats = document.querySelectorAll('.seat.selected');
                        if (selectedSeats.length === 0) {
                            alert('Please select at least one booked seat to cancel.');
                            return;
                        }

                        let seatsToCancel = [];
                        selectedSeats.forEach(function(seat) {
                            if (seat.classList.contains('reserved')) { // Ensure we are canceling only reserved seats
                                seatsToCancel.push(seat.getAttribute('data-seat-number'));
                                seat.classList.remove('selected', 'reserved'); // Visually unmark as reserved/selected
                            }
                        });

                        if (seatsToCancel.length > 0) {
                            // Perform AJAX request to cancel_seats.php to update database
                            fetch('cancel_seats.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: `seatsToCancel=${JSON.stringify(seatsToCancel)}`
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        alert('Cancellation successful.');
                                    } else {
                                        alert('Cancellation failed.');
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        } else {
                            alert('No reserved seats selected for cancellation.');
                        }
                    });

                    function updateTotalPrice() {
                        let selectedSeatsCount = document.querySelectorAll('.seat.selected').length;
                        let destination = destinationSelect.value;

                        // Ensure that the price is being fetched correctly from pricePerDestination
                        // It seems like the original code expected destination format that didn't match the select option values.
                        // Adjust the pricePerDestination keys or the way destination is used to match the keys correctly.
                        let price = pricePerDestination[destination]; // This might be undefined if keys don't match

                        // Adding a fallback price if the destination's price is not found
                        if (typeof price === 'undefined') {
                            console.error(`Price for destination "${destination}" not found. Using a fallback value of 0.`);
                            price = 0; // Default to 0 or any fallback value you see fit
                        }

                        totalPrice = selectedSeatsCount * price;
                        total.textContent = `Total Price: ₱${totalPrice}`;
                    }

                    // Ensure the initial call to updateTotalPrice is made after the page is fully loaded or after destination change.
                    document.addEventListener('DOMContentLoaded', updateTotalPrice, false);
                    destinationSelect.addEventListener('change', updateTotalPrice);
                    checkoutButton.addEventListener('click', function() {
                        const selectedSeats = document.querySelectorAll('.seat.selected');
                        if (selectedSeats.length === 0) {
                            alert('Please select at least one seat.');
                            return;
                        }
                        let bookedSeats = [];
                        selectedSeats.forEach(function(seat) {
                            const seatNumber = seat.dataset.seatNumber;
                            bookedSeats.push(seatNumber);
                            seat.classList.remove('selected');
                            seat.classList.add('reserved');
                        });
                        const destination = destinationSelect.value;
                        const totalPrice = document.querySelector('.total-price').textContent.split('₱')[1];
                        // AJAX call to book seats
                        fetch('book_seats.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: `seats=${JSON.stringify(bookedSeats)}&destination=${destination}&totalPrice=${totalPrice}`
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    alert('Booking successful.');
                                } else {
                                    alert('Booking failed.');
                                }
                            })
                            .catch(error => console.error('Error:', error));

                        updateTotalPrice(); // Reset total price after booking
                    });
                });
            </script>

</body>

</html>