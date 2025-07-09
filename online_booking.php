<?php
// Database connection
$server = "localhost";
$username = "root";
$password = "";
$database = "appointment_db"; 

$con = new mysqli($server, $username, $password, $database);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch doctor name from URL
$doctor = isset($_GET['doctor']) ? $_GET['doctor'] : "Unknown Doctor";

// Fetch booked slots and count how many patients are booked
$booked_slots = [];
$sql = "SELECT time_slot, COUNT(*) as booked_count FROM online_appointments WHERE doctor_name = ? GROUP BY time_slot";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $doctor);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $booked_slots[$row['time_slot']] = $row['booked_count'];
}
$stmt->close();
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        .slots-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
            margin-top: 20px;
        }
        .slot {
            background: #007bff;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .slot:hover {
            background: #0056b3;
        }
        .slot.booked {
            background: #6c757d;
            cursor: not-allowed;
            text-decoration: line-through;
            font-weight: bold;
        }
        .back-button {
            display: block;
            text-align: center;
            margin: 20px auto;
            padding: 10px 15px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            width: 100px;
        }
        .back-button:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Book Appointment</h1>
        <h2><?php echo htmlspecialchars($doctor); ?></h2>
        <div class="slots-container">
            <?php
            // Define available slots
            $slots = [
                "9:00 AM", "9:15 AM", "9:30 AM", "9:45 AM", "10:00 AM", "10:15 AM",
                "10:30 AM", "10:45 AM", "11:00 AM", "11:15 AM", "11:30 AM", "11:45 AM",
                "12:00 PM", "12:15 PM", "12:30 PM", "12:45 PM", "1:00 PM",
                "4:00 PM", "4:15 PM", "4:30 PM", "4:45 PM", "5:00 PM", "5:15 PM",
                "5:30 PM", "5:45 PM", "6:00 PM", "6:15 PM", "6:30 PM", "6:45 PM",
                "7:00 PM", "7:15 PM", "7:30 PM", "7:45 PM", "8:00 PM"
            ];

            // Display slots dynamically
            foreach ($slots as $slot) {
                $isFullyBooked = isset($booked_slots[$slot]) && $booked_slots[$slot] >= 4;
                echo "<div class='slot " . ($isFullyBooked ? "booked" : "") . "' " .
                     (!$isFullyBooked ? "onclick='bookSlot(this, \"$slot\")'" : "") . ">" .
                     $slot . ($isFullyBooked ? " (Booked)" : "") . "</div>";
            }
            ?>
        </div>
        <a href="Welcome.php" class="back-button">Back</a>
    </div>

    <script>
        function bookSlot(slotElement, slotTime) {
            if (slotElement.classList.contains('booked')) {
                alert('This slot is fully booked!');
                return;
            }
            const confirmBooking = confirm(`Do you want to book the slot at ${slotTime}?`);
            if (confirmBooking) {
                fetch('online_slot.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `doctor=<?php echo urlencode($doctor); ?>&slot=${slotTime}`
                })
                .then(response => response.text())
                .then(data => {
                    if (data === "success") {
                        slotElement.classList.add('booked');
                        slotElement.onclick = null;
                        slotElement.innerHTML = slotTime + " (Booked)";
                    } else {
                        alert(data);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
</body>
</html>
