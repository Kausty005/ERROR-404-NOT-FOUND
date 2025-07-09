<?php
session_start();
?>

<?php
$conn = mysqli_connect("localhost", "root", "", "appointment_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Appointment Booking</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            max-width: 500px; 
            margin: 50px auto; 
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

        .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            z-index: 1;
        }

        input, select { 
            width: 100%; 
            padding: 15px 15px 15px 45px; 
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #28a745;
            background: white;
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
        }

        select {
            cursor: pointer;
        }

        .btn-submit { 
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white; 
            border: none; 
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #218838, #1e9f85);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .view-appointments {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e1e5e9;
        }

        .view-appointments a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .view-appointments a:hover {
            color: #5a67d8;
            text-decoration: underline;
        }

        .slot-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 10px;
        }

        .slot-option {
            display: none;
        }

        .slot-label {
            padding: 12px;
            background: #f8f9fa;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
        }

        .slot-label:hover {
            background: #e9ecef;
            border-color: #28a745;
        }

        .slot-option:checked + .slot-label {
            background: #28a745;
            color: white;
            border-color: #28a745;
        }

        .form-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            padding-left: 5px;
        }

        @media (max-width: 600px) {
            .container {
                margin: 20px auto;
                padding: 20px;
            }
            
            .slot-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <script>
        $(document).ready(function() {
            $("#hospital").change(function() {
                var hospital_id = $(this).val();
                $.ajax({
                    url: 'get_doctors.php',
                    type: 'POST',
                    data: {hospital_id: hospital_id},
                    success: function(response) {
                        $("#doctor").html(response);
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h2><i class="fas fa-calendar-check" style="margin-right: 10px; color: #28a745;"></i>Book an Appointment</h2>
        <form action="book_appointment.php" method="POST">
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="patient_name" placeholder="Enter Your Name" required>
            </div>

            <div class="form-group">
                <i class="fas fa-hospital"></i>
                <select name="hospital_id" id="hospital" required>
                    <option value="">Select Hospital</option>
                    <?php
                    $result = $conn->query("SELECT * FROM hospitals");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <i class="fas fa-user-md"></i>
                <select name="doctor_id" id="doctor" required>
                    <option value="">Select Doctor</option>
                </select>
            </div>

            <div class="form-group">
                <i class="fas fa-calendar-alt"></i>
                <input type="date" name="appointment_date" required>
            </div>

            <div class="form-group">
                <div class="form-title">
                    <i class="fas fa-clock" style="margin-right: 8px;"></i>Select Time Slot
                </div>
                <div class="slot-grid">
                    <input type="radio" name="slot" id="slot1" value="9AM-10AM" class="slot-option" required>
                    <label for="slot1" class="slot-label">9AM - 10AM</label>

                    <input type="radio" name="slot" id="slot2" value="10AM-11AM" class="slot-option" required>
                    <label for="slot2" class="slot-label">10AM - 11AM</label>

                    <input type="radio" name="slot" id="slot3" value="11AM-12PM" class="slot-option" required>
                    <label for="slot3" class="slot-label">11AM - 12PM</label>

                    <input type="radio" name="slot" id="slot4" value="12PM-1PM" class="slot-option" required>
                    <label for="slot4" class="slot-label">12PM - 1PM</label>

                    <input type="radio" name="slot" id="slot5" value="2PM-3PM" class="slot-option" required>
                    <label for="slot5" class="slot-label">2PM - 3PM</label>

                    <input type="radio" name="slot" id="slot6" value="3PM-4PM" class="slot-option" required>
                    <label for="slot6" class="slot-label">3PM - 4PM</label>

                    <input type="radio" name="slot" id="slot7" value="4PM-5PM" class="slot-option" required>
                    <label for="slot7" class="slot-label">4PM - 5PM</label>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-check-circle" style="margin-right: 8px;"></i>Book Appointment
            </button>
        </form>
        
        <div class="view-appointments">
            <a href="my_appointments.php">
                <i class="fas fa-list" style="margin-right: 5px;"></i>View My Appointments
            </a>
        </div>
    </div>
</body>
</html>