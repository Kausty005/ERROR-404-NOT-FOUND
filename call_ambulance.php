<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Ambulance Services</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #dc3545;
            --secondary-color: #28a745;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 50%, #c44569 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background Elements */
        .bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .ambulance-icon {
            position: absolute;
            color: rgba(255, 255, 255, 0.1);
            font-size: 3rem;
            animation: float 6s ease-in-out infinite;
        }

        .ambulance-icon:nth-child(1) { top: 10%; left: 10%; animation-delay: 0s; }
        .ambulance-icon:nth-child(2) { top: 20%; right: 10%; animation-delay: 2s; }
        .ambulance-icon:nth-child(3) { bottom: 20%; left: 15%; animation-delay: 4s; }
        .ambulance-icon:nth-child(4) { bottom: 10%; right: 20%; animation-delay: 1s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 50px;
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 600px;
            width: 100%;
            position: relative;
            z-index: 2;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .emergency-header {
            margin-bottom: 30px;
        }

        .emergency-icon {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 15px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        h1 {
            font-size: 2.5rem;
            color: var(--dark-color);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .subtitle {
            color: var(--secondary-color);
            font-size: 1.2rem;
            font-weight: 500;
            margin-bottom: 30px;
        }

        .main-contact {
            background: linear-gradient(45deg, var(--primary-color), #e74c3c);
            color: white;
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(220, 53, 69, 0.3);
            position: relative;
            overflow: hidden;
        }

        .main-contact::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        .contact-number {
            font-size: 4rem;
            font-weight: 900;
            margin: 15px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            letter-spacing: 3px;
        }

        .contact-label {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 10px;
        }

        .call-btn {
            background: linear-gradient(45deg, var(--secondary-color), #20c997);
            color: white;
            border: none;
            padding: 18px 40px;
            border-radius: 50px;
            font-size: 1.3rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            margin-bottom: 30px;
        }

        .call-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
        }

        .call-btn:active {
            transform: translateY(0);
        }

        .emergency-contacts {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .contact-card {
            background: var(--light-color);
            padding: 20px;
            border-radius: 15px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-color);
        }

        .contact-card i {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .contact-card.police i { color: #007bff; }
        .contact-card.fire i { color: #fd7e14; }
        .contact-card.women i { color: #e83e8c; }

        .contact-card h3 {
            font-size: 1.1rem;
            margin-bottom: 5px;
            color: var(--dark-color);
        }

        .contact-card .number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .tips-section {
            background: var(--info-color);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .tips-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tips-list {
            text-align: left;
            list-style: none;
        }

        .tips-list li {
            margin-bottom: 8px;
            padding-left: 25px;
            position: relative;
        }

        .tips-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #28a745;
            font-weight: bold;
        }

        .location-btn {
            background: linear-gradient(45deg, var(--warning-color), #f39c12);
            color: var(--dark-color);
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            margin-bottom: 20px;
        }

        .location-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
        }

        .back-btn {
            background: linear-gradient(45deg, #6c757d, #495057);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
            color: white;
            text-decoration: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
                margin: 10px;
            }

            h1 {
                font-size: 2rem;
            }

            .contact-number {
                font-size: 3rem;
            }

            .emergency-contacts {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .emergency-contacts {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="bg-animation">
        <i class="fas fa-ambulance ambulance-icon"></i>
        <i class="fas fa-ambulance ambulance-icon"></i>
        <i class="fas fa-ambulance ambulance-icon"></i>
        <i class="fas fa-ambulance ambulance-icon"></i>
    </div>

    <div class="container">
        <div class="emergency-header">
            <i class="fas fa-ambulance emergency-icon"></i>
            <h1>Emergency Ambulance</h1>
            <p class="subtitle">24/7 Emergency Medical Services</p>
        </div>

        <div class="main-contact">
            <div class="contact-label">National Emergency Number</div>
            <div class="contact-number">108</div>
            <div style="font-size: 0.9rem; opacity: 0.8;">Free • Available 24/7 • All India</div>
        </div>

        <button class="call-btn" onclick="callAmbulance()">
            <i class="fas fa-phone-alt"></i>
            Call Ambulance Now
        </button>

        <button class="location-btn" onclick="shareLocation()">
            <i class="fas fa-map-marker-alt"></i>
            Share My Location
        </button>

        <div class="emergency-contacts">
            <div class="contact-card police" onclick="window.location.href='tel:100'">
                <i class="fas fa-shield-alt"></i>
                <h3>Police</h3>
                <div class="number">100</div>
            </div>
            <div class="contact-card fire" onclick="window.location.href='tel:101'">
                <i class="fas fa-fire-extinguisher"></i>
                <h3>Fire Brigade</h3>
                <div class="number">101</div>
            </div>
            <div class="contact-card women" onclick="window.location.href='tel:1091'">
                <i class="fas fa-female"></i>
                <h3>Women Helpline</h3>
                <div class="number">1091</div>
            </div>
        </div>

        <div class="tips-section">
            <div class="tips-title">
                <i class="fas fa-lightbulb"></i>
                Emergency Tips
            </div>
            <ul class="tips-list">
                <li>Stay calm and speak clearly</li>
                <li>Provide exact location details</li>
                <li>Describe the emergency situation</li>
                <li>Follow dispatcher's instructions</li>
                <li>Keep the patient comfortable</li>
                <li>Don't move seriously injured persons</li>
            </ul>
        </div>

        <a href="emergency_location.php" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Back to Emergency Services
        </a>
    </div>

    <script>
        function callAmbulance() {
            // Vibrate if supported
            if (navigator.vibrate) {
                navigator.vibrate([200, 100, 200]);
            }
            
            // Make the call
            window.location.href = 'tel:108';
        }

        function shareLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;
                        
                        // Create location message
                        const locationText = `Emergency Location: https://maps.google.com/?q=${lat},${lon}`;
                        
                        // Try to share via Web Share API
                        if (navigator.share) {
                            navigator.share({
                                title: 'Emergency Location',
                                text: locationText,
                            });
                        } else {
                            // Fallback: copy to clipboard
                            navigator.clipboard.writeText(locationText).then(() => {
                                alert('Location copied to clipboard! Share this with emergency services.');
                            });
                        }
                    },
                    function(error) {
                        alert('Unable to get location. Please enable location services.');
                    }
                );
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        }

        // Auto-call functionality for extreme emergencies
        let emergencyTimer;
        function startEmergencyTimer() {
            emergencyTimer = setTimeout(() => {
                if (confirm('Auto-calling ambulance in 5 seconds. Cancel if not needed.')) {
                    callAmbulance();
                }
            }, 5000);
        }

        // Add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Press 'E' for emergency call
            if (e.key.toLowerCase() === 'e') {
                callAmbulance();
            }
            // Press 'L' for location sharing
            if (e.key.toLowerCase() === 'l') {
                shareLocation();
            }
        });

        // Add visual feedback for button presses
        document.querySelectorAll('button, .contact-card').forEach(element => {
            element.addEventListener('click', function() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 100);
            });
        });

        // Show emergency tips on page load
        window.addEventListener('load', function() {
            setTimeout(() => {
                const tips = document.querySelector('.tips-section');
                tips.style.animation = 'pulse 1s ease-in-out';
            }, 2000);
        });
    </script>
</body>
</html>
