<?php
session_start();
if (!isset($_SESSION['email'])){
    header("Location:register.php");
    exit();
}
?>

<?php
// Database connection without OOP
$conn = mysqli_connect("localhost","root", "", "appointment_db");

// Check if connection failed
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch user email from SESSION
$email = $_SESSION['email'];

// Query to fetch all appointments based on email ID
$query = "
    SELECT a.patient_name, a.appointment_date, a.slot, d.name AS doctor_name, d.speciality, h.name AS hospital_name
    FROM appointments a
    JOIN doctors d ON a.doctor_id = d.id
    JOIN hospitals h ON a.hospital_id = h.id
    WHERE a.email = ?
    ORDER BY a.appointment_date DESC
";

// Prepare the statement
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container { 
            max-width: 1000px; 
            margin: 30px auto; 
            background: white; 
            padding: 30px; 
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 600;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .user-info {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            padding: 15px 20px;
            border-radius: 10px;
            border-left: 4px solid #28a745;
        }

        .user-info i {
            margin-right: 10px;
            color: #28a745;
            font-size: 18px;
        }

        .user-info span {
            font-weight: 500;
            color: #333;
        }

        .appointments-count {
            background: linear-gradient(135deg, #17a2b8, #20c997);
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            background: white;
            min-width: 700px;
        }

        th, td { 
            padding: 15px 12px; 
            text-align: left; 
            border-bottom: 1px solid #e9ecef;
        }

        th { 
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white; 
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 0.5px;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        tbody tr {
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        tbody tr:nth-child(even) {
            background-color: #fdfdfd;
        }

        td {
            font-size: 14px;
            color: #555;
        }

        .appointment-date {
            font-weight: 600;
            color: #333;
        }

        .time-slot {
            background: #e8f5e8;
            color: #28a745;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }

        .doctor-info {
            font-weight: 500;
            color: #333;
        }

        .speciality {
            color: #6c757d;
            font-size: 12px;
            background: #f8f9fa;
            padding: 3px 8px;
            border-radius: 15px;
            margin-top: 5px;
            display: inline-block;
        }

        .hospital-name {
            color: #17a2b8;
            font-weight: 500;
        }

        .btn-back {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #218838, #1e9f85);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .no-appointments {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .no-appointments i {
            font-size: 80px;
            color: #dee2e6;
            margin-bottom: 20px;
        }

        .no-appointments h3 {
            color: #495057;
            margin-bottom: 15px;
            font-size: 24px;
        }

        .no-appointments p {
            font-size: 16px;
            margin-bottom: 30px;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-upcoming {
            background: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-today {
            background: #cce5ff;
            color: #0056b3;
        }

        @media (max-width: 768px) {
            .container {
                margin: 10px;
                padding: 20px;
            }

            .header-section {
                flex-direction: column;
                text-align: center;
            }

            .user-info, .appointments-count {
                width: 100%;
                justify-content: center;
            }

            h2 {
                font-size: 24px;
            }

            th, td {
                padding: 10px 8px;
                font-size: 13px;
            }

            .btn-back {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><i class="fas fa-calendar-check" style="margin-right: 10px; color: #28a745;"></i>My Appointments</h2>
        
        <div class="header-section">
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <span><?php echo htmlspecialchars($email); ?></span>
            </div>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <div class="appointments-count">
                    <i class="fas fa-clipboard-list"></i>
                    <span><?php echo mysqli_num_rows($result); ?> Appointments</span>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-user" style="margin-right: 5px;"></i>Patient Name</th>
                            <th><i class="fas fa-calendar-alt" style="margin-right: 5px;"></i>Date</th>
                            <th><i class="fas fa-clock" style="margin-right: 5px;"></i>Time Slot</th>
                            <th><i class="fas fa-user-md" style="margin-right: 5px;"></i>Doctor</th>
                            <th><i class="fas fa-stethoscope" style="margin-right: 5px;"></i>Speciality</th>
                            <th><i class="fas fa-hospital" style="margin-right: 5px;"></i>Hospital</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <?php
                            $appointment_date = new DateTime($row['appointment_date']);
                            $today = new DateTime();
                            $status_class = '';
                            
                            if ($appointment_date->format('Y-m-d') == $today->format('Y-m-d')) {
                                $status_class = 'status-today';
                            } elseif ($appointment_date > $today) {
                                $status_class = 'status-upcoming';
                            } else {
                                $status_class = 'status-completed';
                            }
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                                <td class="appointment-date">
                                    <?php echo $appointment_date->format('M d, Y'); ?>
                                    <br>
                                    <span class="status-badge <?php echo $status_class; ?>">
                                        <?php 
                                        if ($appointment_date->format('Y-m-d') == $today->format('Y-m-d')) {
                                            echo 'Today';
                                        } elseif ($appointment_date > $today) {
                                            echo 'Upcoming';
                                        } else {
                                            echo 'Completed';
                                        }
                                        ?>
                                    </span>
                                </td>
                                <td><span class="time-slot"><?php echo htmlspecialchars($row['slot']); ?></span></td>
                                <td class="doctor-info">
                                    <i class="fas fa-user-md" style="margin-right: 5px; color: #28a745;"></i>
                                    <?php echo htmlspecialchars($row['doctor_name']); ?>
                                </td>
                                <td><span class="speciality"><?php echo htmlspecialchars($row['speciality']); ?></span></td>
                                <td class="hospital-name">
                                    <i class="fas fa-hospital-alt" style="margin-right: 5px;"></i>
                                    <?php echo htmlspecialchars($row['hospital_name']); ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <a href="index.php" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Back to Home
            </a>
        <?php else: ?>
            <div class="no-appointments">
                <i class="fas fa-calendar-times"></i>
                <h3>No Appointments Found</h3>
                <p>You haven't booked any appointments yet. Start by booking your first appointment!</p>
                <a href="index.php" class="btn-back">
                    <i class="fas fa-plus-circle"></i>
                    Book New Appointment
                </a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>