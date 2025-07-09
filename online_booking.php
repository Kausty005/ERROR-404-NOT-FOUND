<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login page
    exit();
}

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --gray-light: #e9ecef;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: var(--dark);
            line-height: 1.6;
            padding: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #28a745, #20c997, #17a2b8);
        }
        
        header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        h1 {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        h2 {
            font-size: 1.5rem;
            color: var(--secondary);
            font-weight: 500;
        }
        
        .doctor-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .doctor-icon {
            font-size: 1.8rem;
            color: var(--primary);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            padding: 10px 20px;
            background: #f8f9fa;
            border-radius: 8px;
            color: #666;
            font-size: 14px;
        }
        
        .slots-section {
            margin-top: 2rem;
        }
        
        .time-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--gray-light);
        }
        
        .time-period {
            font-weight: 500;
            color: var(--primary);
            font-size: 1.1rem;
        }
        
        .slots-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 12px;
            margin-bottom: 2rem;
        }
        
        .slot {
            background: white;
            border: 2px solid var(--primary);
            color: var(--primary);
            padding: 0.8rem 0.5rem;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }
        
        .slot:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .slot.booked {
            background: var(--gray-light);
            border-color: var(--gray-light);
            color: var(--gray);
            cursor: not-allowed;
            position: relative;
        }
        
        .slot.booked::after {
            content: "FULL";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: var(--danger);
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: bold;
        }
        
        .slot.loading {
            position: relative;
            pointer-events: none;
        }
        
        .slot.loading::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .slot.loading::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 3px solid var(--primary);
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 0.8s linear infinite;
            z-index: 1;
        }
        
        @keyframes spin {
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }
        
        .slot.booked-success {
            background: var(--success);
            border-color: var(--success);
            color: white;
            cursor: default;
        }
        
        .slot.booked-success::after {
            content: "BOOKED";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: bold;
        }
        
        .back-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin: 2rem auto 0;
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .back-button:hover {
            background: linear-gradient(135deg, #218838, #1e9f85);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }
        
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--primary);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            max-width: 300px;
        }
        
        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }
        
        .toast.success {
            background: #28a745;
        }
        
        .toast.error {
            background: var(--danger);
        }
        
        .toast-icon {
            font-size: 1.2rem;
        }
        
        @media (max-width: 768px) {
            .container {
                margin: 1rem;
                padding: 1.5rem;
            }
            
            .slots-grid {
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            }
            
            .toast {
                bottom: 10px;
                right: 10px;
                left: 10px;
                max-width: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-calendar-check" style="margin-right: 10px; color: #28a745;"></i>Book Your Appointment</h1>
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <span>Logged in as: <?php echo htmlspecialchars($_SESSION['email']); ?></span>
            </div>
            <div class="doctor-info">
                <i class="fas fa-user-md doctor-icon"></i>
                <h2><?php echo htmlspecialchars($doctor); ?></h2>
            </div>
        </header>
        
        <div class="slots-section">
            <div class="time-header">
                <span class="time-period"><i class="fas fa-sun" style="margin-right: 8px;"></i>Morning Session</span>
            </div>
            <div class="slots-grid">
                <?php
                // Define available slots
                $morning_slots = [
                    "9:00 AM", "9:15 AM", "9:30 AM", "9:45 AM", 
                    "10:00 AM", "10:15 AM", "10:30 AM", "10:45 AM", 
                    "11:00 AM", "11:15 AM", "11:30 AM", "11:45 AM",
                    "12:00 PM", "12:15 PM", "12:30 PM", "12:45 PM", 
                    "1:00 PM"
                ];
                
                foreach ($morning_slots as $slot) {
                    $isFullyBooked = isset($booked_slots[$slot]) && $booked_slots[$slot] >= 4;
                    echo "<div class='slot " . ($isFullyBooked ? "booked" : "") . "' " .
                         "data-slot='$slot' " .
                         (!$isFullyBooked ? "onclick='bookSlot(this)'" : "") . ">" .
                         $slot . "</div>";
                }
                ?>
            </div>
            
            <div class="time-header">
                <span class="time-period"><i class="fas fa-moon" style="margin-right: 8px;"></i>Evening Session</span>
            </div>
            <div class="slots-grid">
                <?php
                $evening_slots = [
                    "4:00 PM", "4:15 PM", "4:30 PM", "4:45 PM", 
                    "5:00 PM", "5:15 PM", "5:30 PM", "5:45 PM", 
                    "6:00 PM", "6:15 PM", "6:30 PM", "6:45 PM",
                    "7:00 PM", "7:15 PM", "7:30 PM", "7:45 PM", 
                    "8:00 PM"
                ];
                
                foreach ($evening_slots as $slot) {
                    $isFullyBooked = isset($booked_slots[$slot]) && $booked_slots[$slot] >= 4;
                    echo "<div class='slot " . ($isFullyBooked ? "booked" : "") . "' " .
                         "data-slot='$slot' " .
                         (!$isFullyBooked ? "onclick='bookSlot(this)'" : "") . ">" .
                         $slot . "</div>";
                }
                ?>
            </div>
        </div>
        
        <div style="text-align: center;">
            <a href="Online_Appointments.html" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back to Doctor Selection
            </a>
        </div>
    </div>
    
    <div id="toast" class="toast">
        <i class="fas fa-check-circle toast-icon"></i>
        <span class="toast-message">Appointment booked successfully!</span>
    </div>

    <script>
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastIcon = toast.querySelector('.toast-icon');
            const toastMessage = toast.querySelector('.toast-message');
            
            // Update toast content
            toastMessage.textContent = message;
            toast.className = `toast ${type}`;
            
            // Set appropriate icon
            if (type === 'success') {
                toastIcon.className = 'fas fa-check-circle toast-icon';
            } else if (type === 'error') {
                toastIcon.className = 'fas fa-exclamation-circle toast-icon';
            }
            
            // Show toast
            toast.classList.add('show');
            
            // Hide after 4 seconds
            setTimeout(() => {
                toast.classList.remove('show');
            }, 4000);
        }
        
        function bookSlot(slotElement) {
            const slotTime = slotElement.getAttribute('data-slot');
            const doctor = "<?php echo urlencode($doctor); ?>";
            
            if (slotElement.classList.contains('booked')) {
                showToast('This slot is already fully booked!', 'error');
                return;
            }
            
            const confirmBooking = confirm(`Confirm booking with Dr. <?php echo htmlspecialchars($doctor); ?> at ${slotTime}?`);
            
            if (confirmBooking) {
                // Show loading state
                slotElement.classList.add('loading');
                
                fetch('online_slot.php', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `doctor=${doctor}&slot=${encodeURIComponent(slotTime)}`
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(data => {
                    slotElement.classList.remove('loading');
                    
                    if (data.trim() === "success") {
                        // Update UI for successful booking
                        slotElement.classList.add('booked-success');
                        slotElement.removeAttribute('onclick');
                        showToast(`Appointment confirmed for ${slotTime}!`, 'success');
                        
                        // Refresh page after 2 seconds to update slot counts
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        showToast(data || 'Error booking appointment. Please try again.', 'error');
                    }
                })
                .catch(error => {
                    slotElement.classList.remove('loading');
                    showToast('Failed to book appointment. Please check your connection and try again.', 'error');
                    console.error('Error:', error);
                });
            }
        }
    </script>
</body>
</html>