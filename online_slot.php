<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

if (!isset($_SESSION['name']) || !isset($_SESSION['email'])) {
    die("You must be logged in to book an appointment.");
}

// Connect to the signup database to fetch email if not set
$server = "localhost";
$username = "root";
$password = "";
$signup_db = "User";

$con = new mysqli($server, $username, $password, $signup_db);

if ($con->connect_error) {
    die("Database connection failed: " . $con->connect_error);
}

if (!isset($_SESSION['email'])) {
    $name = $_SESSION['name'];
    $stmt = $con->prepare("SELECT email FROM signin WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $_SESSION['email'] = $row['email'];  // Store email in session
    } else {
        die("Email not found!");
    }
    $stmt->close();
}
$con->close();

// Connect to the appointment database
$appointment_db = "appointment_db";
$con = new mysqli($server, $username, $password, $appointment_db);
if ($con->connect_error) {
    die("Database connection failed: " . $con->connect_error);
}

// Ensure it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor = $_POST['doctor'];
    $slot = $_POST['slot'];
    $patient = $_SESSION['name'];
    $patient_email = $_SESSION['email'];
    $today_date = date("Y-m-d");

    // ✅ Check if the slot is already fully booked
    $stmt = $con->prepare("SELECT COUNT(*) AS total FROM online_appointments WHERE doctor_name = ? AND time_slot = ?");
    $stmt->bind_param("ss", $doctor, $slot);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $booked_count = $row['total'];
    $stmt->close();

    if ($booked_count >= 4) {
        echo "Slot is fully booked!";
        exit();
    }

    // ✅ Check if the patient has already booked a slot today with this doctor
    $stmt = $con->prepare("SELECT id FROM online_appointments WHERE patient_name = ? AND doctor_name = ? AND DATE(time_slot) = ?");
    $stmt->bind_param("sss", $patient, $doctor, $today_date);
    $stmt->execute();
    $checkPatient = $stmt->get_result();
    $stmt->close();

    if ($checkPatient->num_rows > 0) {
        echo "You can book only one slot per day!";
        exit();
    }

    // ✅ Fetch Google Meet link for the doctor
    $stmt = $con->prepare("SELECT link FROM doctor_meet_links WHERE doctor_name = ?");
    $stmt->bind_param("s", $doctor);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($row = $result->fetch_assoc()) {
        $meet_link = $row['link'];
    } else {
        $meet_link = "No Meet link available"; // Default message if no link is found
    }

    // ✅ Insert appointment into the database
    $stmt = $con->prepare("INSERT INTO online_appointments (patient_name, patient_email, doctor_name, time_slot, meeting_link, status) VALUES (?, ?, ?, ?, ?, 'booked')");
    $stmt->bind_param("sssss", $patient, $patient_email, $doctor, $slot, $meet_link);

    if ($stmt->execute()) {
        // ✅ Fetch doctor's email
        $stmt = $con->prepare("SELECT email FROM online_doctors WHERE name = ?");
        $stmt->bind_param("s", $doctor);
        $stmt->execute();
        $doctor_result = $stmt->get_result();

        if ($doctor_result->num_rows > 0) {
            $doctor_row = $doctor_result->fetch_assoc();
            $doctor_email = $doctor_row['email'];
        } else {
            die("Doctor email not found.");
        }

        // ✅ Send email notifications with Google Meet link
        sendMail($doctor_email, $doctor, $patient, $slot, "doctor", $meet_link);
        sendMail($patient_email, $doctor, $patient, $slot, "patient", $meet_link);

        echo "success";
    } else {
        echo "Error booking slot!";
    }

    $stmt->close();
}

$con->close();

// ✅ Function to send email with Google Meet link
function sendMail($recipient_email, $doctor, $patient, $slot, $role, $meet_link) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'omkar.katare06@gmail.com';
        $mail->Password = 'jgdcjtzebnggksml';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('omkar.katare06@gmail.com', 'MedConnect');
        $mail->addAddress($recipient_email);

        $mail->isHTML(true);
        $mail->Subject = 'Appointment Confirmation';

        if ($role == "doctor") {
            $mail->Body = "Dear $doctor,<br><br>A new appointment has been booked today.<br><br>
            <b>Patient Name:</b> $patient<br>
            <b>Time Slot:</b> $slot<br><br>
            <b>Google Meet Link:</b> <a href='$meet_link'>$meet_link</a><br><br>
            Please check your schedule.<br><br>Best Regards,<br>MedConnect";
        } else {
            $mail->Body = "Dear $patient,<br><br>Your appointment has been successfully booked.<br><br>
            <b>Doctor:</b> Dr. $doctor<br>
            <b>Time Slot:</b> $slot<br><br>
            <b>Google Meet Link:</b> <a href='$meet_link'>$meet_link</a><br><br>
            Thank you for using MedConnect.<br><br>Best Regards,<br>MedConnect";
        }

        $mail->send();
    } catch (Exception $e) {
        error_log("Mail Error: " . $mail->ErrorInfo);
    }
}

?>
