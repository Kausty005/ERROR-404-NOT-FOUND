<?php
session_start();


error_reporting(E_ALL);
ini_set('display_errors', 1);


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "HospitalDB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$booking_made = false;
$booking_id = null;
$hospital_details = null;
$error_message = "";


if(isset($_GET['hospital']) && isset($_GET['injury'])) {
    $hospital_name = trim($_GET['hospital']);
    $injury_type = trim($_GET['injury']);
    
    if(!empty($hospital_name) && !empty($injury_type)) {
        try {
            // Get hospital details
            $hospital_query = "SELECT * FROM hospitals WHERE name = ? LIMIT 1";
            $stmt = $conn->prepare($hospital_query);
            
            if($stmt) {
                $stmt->bind_param("s", $hospital_name);
                $stmt->execute();
                $hospital_result = $stmt->get_result();
                $hospital_details = $hospital_result->fetch_assoc();
                $stmt->close();
                
                // Generate booking reference and times
                $booking_reference = 'EMG' . date('Ymd') . rand(1000, 9999);
                $booking_time = date('Y-m-d H:i:s');
                $appointment_time = date('Y-m-d H:i:s', strtotime('+2 hours'));
                
                // Insert booking - simplified version first
                $insert_query = "INSERT INTO bookings (hospital_name, injury_type, booking_time) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($insert_query);
                
                if($stmt) {
                    $stmt->bind_param("sss", $hospital_name, $injury_type, $booking_time);
                    
                    if($stmt->execute()) {
                        $booking_id = $stmt->insert_id;
                        $booking_made = true;
                        
                        // Update bed availability if hospital exists
                        if($hospital_details && isset($hospital_details['id'])) {
                            $update_beds = "UPDATE hospitals SET beds_available = GREATEST(0, beds_available - 1) WHERE id = ?";
                            $stmt2 = $conn->prepare($update_beds);
                            if($stmt2) {
                                $stmt2->bind_param("i", $hospital_details['id']);
                                $stmt2->execute();
                                $stmt2->close();
                            }
                        }
                    } else {
                        $error_message = "Error creating booking: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    $error_message = "Error preparing insert statement: " . $conn->error;
                }
            } else {
                $error_message = "Error preparing hospital query: " . $conn->error;
            }
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
        }
    } else {
        $error_message = "Missing hospital name or injury type.";
    }
}


$bookings = [];
try {
    $result = $conn->query("SELECT * FROM bookings ORDER BY booking_time DESC LIMIT 10");
    if($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
    }
} catch (Exception $e) {
    $error_message .= " Error fetching bookings: " . $e->getMessage();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Confirmation - Emergency Medical System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #0dcaf0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px 0;
        }

        .main-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            padding: 40px;
            margin: 20px auto;
            max-width: 1000px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
        }

        .page-title {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .confirmation-card {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
            position: relative;
            overflow: hidden;
        }

        .confirmation-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        .confirmation-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .confirmation-icon {
            font-size: 3rem;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        .booking-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .detail-item {
            background: rgba(255, 255, 255, 0.2);
            padding: 15px;
            border-radius: 10px;
            backdrop-filter: blur(5px);
        }

        .detail-label {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .booking-reference {
            background: rgba(255, 255, 255, 0.3);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            margin-top: 20px;
        }

        .reference-number {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .history-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .history-header {
            color: var(--dark-color);
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .booking-table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background: var(--primary-color);
            color: white;
            font-weight: 600;
            border: none;
            padding: 15px;
        }

        .table td {
            padding: 15px;
            vertical-align: middle;
            border-color: #e9ecef;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            background: var(--success-color);
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn-custom {
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary-custom {
            background: linear-gradient(45deg, var(--primary-color), #0056b3);
            color: white;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 110, 253, 0.4);
            color: white;
        }

        .btn-secondary-custom {
            background: linear-gradient(45deg, var(--secondary-color), #495057);
            color: white;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }

        .btn-secondary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.4);
            color: white;
        }

        .no-bookings {
            text-align: center;
            padding: 40px;
            color: var(--secondary-color);
        }

        .no-bookings i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: var(--info-color);
        }

        .emergency-info {
            background: linear-gradient(45deg, #dc3545, #fd7e14);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
        }

        .emergency-info h6 {
            margin-bottom: 10px;
            font-weight: 600;
        }

        .error-alert {
            background: var(--danger-color);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-container {
                margin: 10px;
                padding: 20px;
            }

            .page-title {
                font-size: 2rem;
                flex-direction: column;
                gap: 10px;
            }

            .booking-details {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn-custom {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-calendar-check"></i>
                Booking Confirmation
            </h1>
        </div>

        <?php if(!empty($error_message)): ?>
        <div class="error-alert">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Error:</strong> <?= htmlspecialchars($error_message) ?>
        </div>
        <?php endif; ?>

        <?php if($booking_made): ?>
        <div class="confirmation-card">
            <div class="confirmation-header">
                <i class="fas fa-check-circle confirmation-icon"></i>
                <div>
                    <h3 style="margin: 0;">Booking Confirmed Successfully!</h3>
                    <p style="margin: 0; opacity: 0.9;">Your emergency appointment has been scheduled</p>
                </div>
            </div>

            <div class="booking-details">
                <div class="detail-item">
                    <div class="detail-label">Hospital</div>
                    <div class="detail-value"><?= htmlspecialchars($_GET['hospital']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Specialty</div>
                    <div class="detail-value"><?= htmlspecialchars($_GET['injury']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Appointment Time</div>
                    <div class="detail-value"><?= date('M j, Y - H:i', strtotime('+2 hours')) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">Confirmed</div>
                </div>
            </div>

            <div class="booking-reference">
                <div class="detail-label">Booking Reference</div>
                <div class="reference-number">EMG<?= date('Ymd') . sprintf('%04d', $booking_id ?: rand(1000, 9999)) ?></div>
            </div>
        </div>

        <div class="emergency-info">
            <h6><i class="fas fa-phone-alt"></i> Important Information</h6>
            <div><strong>Emergency Hotlines:</strong> Ambulance: 108 | Police: 100 | Fire: 101</div>
            <?php if($hospital_details && isset($hospital_details['phone'])): ?>
            <div><strong>Hospital Contact:</strong> <?= htmlspecialchars($hospital_details['phone']) ?></div>
            <?php endif; ?>
            <small>Please arrive 15 minutes before your appointment time. Bring valid ID and insurance documents.</small>
        </div>
        <?php endif; ?>

        <div class="history-card">
            <h3 class="history-header">
                <i class="fas fa-history"></i>
                Recent Bookings
            </h3>
            
            <?php if(count($bookings) > 0): ?>
            <div class="booking-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hospital"></i> Hospital</th>
                            <th><i class="fas fa-user-md"></i> Specialty</th>
                            <th><i class="fas fa-calendar"></i> Date</th>
                            <th><i class="fas fa-info-circle"></i> Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($bookings as $booking): ?>
                        <tr>
                            <td><?= htmlspecialchars($booking['hospital_name']) ?></td>
                            <td><?= htmlspecialchars($booking['injury_type']) ?></td>
                            <td><?= date('M j, Y H:i', strtotime($booking['booking_time'])) ?></td>
                            <td>
                                <span class="status-badge">
                                    Confirmed
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="no-bookings">
                <i class="fas fa-calendar-times"></i>
                <h5>No Previous Bookings</h5>
                <p>This is your first emergency booking with our system.</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="action-buttons">
            <a href="emergency_location.php" class="btn btn-primary-custom btn-custom">
                <i class="fas fa-plus"></i>
                New Emergency Booking
            </a>
            <a href="hospital_lists.php" class="btn btn-secondary-custom btn-custom">
                <i class="fas fa-search"></i>
                Find More Hospitals
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
       
        setTimeout(function() {
            if(window.location.search.includes('hospital=')) {
          
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        }, 5000);

     
        function printBooking() {
            window.print();
        }

        <?php if($booking_made): ?>
        document.addEventListener('DOMContentLoaded', function() {
            const actionButtons = document.querySelector('.action-buttons');
            const printBtn = document.createElement('button');
            printBtn.className = 'btn btn-secondary-custom btn-custom';
            printBtn.innerHTML = '<i class="fas fa-print"></i> Print Confirmation';
            printBtn.onclick = printBooking;
            actionButtons.appendChild(printBtn);
        });
        <?php endif; ?>
    </script>
</body>
</html>
