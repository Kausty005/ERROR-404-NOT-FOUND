<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Emergency Medical Assistance</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .container-box {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
      backdrop-filter: blur(10px);
      max-width: 1200px;
      width: 100%;
      display: flex;
      flex-direction: row;
      align-items: center;
      gap: 40px;
    }

    .left-section {
      flex: 1.5;
      display: flex;
      flex-direction: column;
      gap: 25px;
    }

    .right-section {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      border-left: 2px solid #e9ecef;
      padding-left: 40px;
    }

    .page-title {
      color: var(--primary-color);
      font-weight: 700;
      font-size: 2.2rem;
      text-align: center;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
    }

    .page-subtitle {
      color: var(--secondary-color);
      text-align: center;
      font-size: 1.1rem;
      margin-bottom: 30px;
    }

    .form-group {
      position: relative;
      margin-bottom: 25px;
    }

    .form-label {
      color: var(--dark-color);
      font-weight: 600;
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .form-control {
      width: 100%;
      padding: 15px 20px;
      border: 2px solid #e9ecef;
      border-radius: 12px;
      font-size: 1rem;
      transition: all 0.3s ease;
      background: white;
    }

    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
      outline: none;
    }

    .form-control::placeholder {
      color: #adb5bd;
      font-style: italic;
    }

    .form-select {
      width: 100%;
      padding: 15px 20px;
      border: 2px solid #e9ecef;
      border-radius: 12px;
      font-size: 1rem;
      background: white;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .form-select:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
      outline: none;
    }

    .btn-emergency {
      background: linear-gradient(45deg, #dc3545, #fd7e14);
      border: none;
      color: white;
      padding: 18px 40px;
      border-radius: 50px;
      font-size: 1.2rem;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      width: 100%;
      margin-top: 20px;
    }

    .btn-emergency:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(220, 53, 69, 0.4);
      color: white;
    }

    .btn-emergency:active {
      transform: translateY(0);
    }

    .location-status {
      background: var(--info-color);
      color: white;
      padding: 10px 20px;
      border-radius: 25px;
      font-size: 0.9rem;
      text-align: center;
      margin-top: 10px;
      display: none;
    }

    .location-status.show {
      display: block;
    }

    .location-status.success {
      background: var(--success-color);
    }

    .location-status.error {
      background: var(--danger-color);
    }

    /* Video Styling */
    .right-section video {
      max-width: 100%;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    /* Emergency Features */
    .emergency-features {
      background: var(--light-color);
      padding: 20px;
      border-radius: 12px;
      margin-bottom: 20px;
      border-left: 4px solid var(--primary-color);
    }

    .feature-item {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 8px;
      color: var(--dark-color);
    }

    .feature-icon {
      color: var(--success-color);
      font-size: 1.1rem;
    }

    /* Loading Animation */
    .loading-spinner {
      display: none;
      width: 20px;
      height: 20px;
      border: 2px solid #ffffff;
      border-top: 2px solid transparent;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .container-box {
        flex-direction: column;
        padding: 30px 20px;
        gap: 30px;
      }

      .right-section {
        border-left: none;
        border-top: 2px solid #e9ecef;
        padding-left: 0;
        padding-top: 30px;
      }

      .page-title {
        font-size: 1.8rem;
      }

      .btn-emergency {
        padding: 15px 30px;
        font-size: 1.1rem;
      }
    }

    /* Pulse animation for emergency button */
    @keyframes pulse {
      0% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
      }
      70% {
        box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
      }
      100% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
      }
    }

    .btn-emergency.pulse {
      animation: pulse 2s infinite;
    }
  </style>
</head>

<body>
  <div class="container-box">

    <form action="hospital_lists.php" method="GET" id="emergencyForm">
      <div class="left-section">
        <h2 class="page-title">
          <i class="fas fa-ambulance"></i>
          Emergency Medical Assistance
        </h2>
        <p class="page-subtitle">Get immediate help from nearby hospitals and specialists</p>

        <div class="emergency-features">
          <div class="feature-item">
            <i class="fas fa-check-circle feature-icon"></i>
            <span>Automatic location detection</span>
          </div>
          <div class="feature-item">
            <i class="fas fa-check-circle feature-icon"></i>
            <span>Find nearest specialized hospitals</span>
          </div>
          <div class="feature-item">
            <i class="fas fa-check-circle feature-icon"></i>
            <span>Real-time availability information</span>
          </div>
          <div class="feature-item">
            <i class="fas fa-check-circle feature-icon"></i>
            <span>Direct booking system</span>
          </div>
        </div>

        <div class="form-group position-relative">
          <label for="locationInput" class="form-label">
            <i class="fas fa-map-marker-alt"></i>
            Your Location
          </label>
          <input type="text" id="locationInput" name="location" class="form-control" placeholder="Detecting your location..." autocomplete="off" readonly>
          <input type="hidden" id="latitude" name="latitude">
          <input type="hidden" id="longitude" name="longitude">
          <div class="location-status" id="locationStatus">
            <i class="fas fa-spinner fa-spin"></i> Fetching your location...
          </div>
        </div>

        <div class="form-group">
          <label for="speciality" class="form-label">
            <i class="fas fa-user-md"></i>
            Medical Specialty Required
          </label>
          <select id="speciality" name="injury" class="form-select" required>
            <option value="" disabled selected>Select the type of medical assistance needed</option>
            <option value="emergency_physician">🚨 Emergency Physician (General Emergency)</option>
            <option value="cardiologist">❤️ Cardiologist (Heart/Chest Issues)</option>
            <option value="neurologist">🧠 Neurologist (Head/Brain/Stroke)</option>
            <option value="orthopedist">🦴 Orthopedist (Bone/Joint/Fracture)</option>
            <option value="general_surgeon">🔪 General Surgeon (Surgery Required)</option>
            <option value="pediatrician">👶 Pediatrician (Child Emergency)</option>
            <option value="ophthalmologist">👁️ Ophthalmologist (Eye Emergency)</option>
            <option value="dermatologist">🩹 Dermatologist (Skin/Burns)</option>
            <option value="pulmonologist">🫁 Pulmonologist (Breathing/Lung Issues)</option>
            <option value="other">❓ Other/Not Sure</option>
          </select>
        </div>

        <button type="submit" class="btn btn-emergency pulse" id="findHospitalsBtn">
          <i class="fas fa-hospital"></i>
          <span>Find Emergency Hospitals</span>
          <div class="loading-spinner" id="loadingSpinner"></div>
        </button>
      </div>
    </form>

 
    <div class="right-section">
      <video loop muted autoplay>
        <source src="Screen Recording 2025-02-27 234312.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      const locationInput = $("#locationInput");
      const latitudeInput = $("#latitude");
      const longitudeInput = $("#longitude");
      const locationStatus = $("#locationStatus");
      const findBtn = $("#findHospitalsBtn");
      const loadingSpinner = $("#loadingSpinner");


      locationStatus.addClass('show');

     
      function reverseGeocode(lat, lon) {
        const apiKey = 'pk.9d70d4abd0dd986062058532456829b0';
        const url = `https://us1.locationiq.com/v1/reverse.php?key=${apiKey}&lat=${lat}&lon=${lon}&format=json`;

        fetch(url)
          .then(response => response.json())
          .then(data => {
            if (data && data.display_name) {
              locationInput.val(data.display_name);
              locationStatus.removeClass('error').addClass('success');
              locationStatus.html('<i class="fas fa-check-circle"></i> Location detected successfully');
              
              // Hide status after 3 seconds
              setTimeout(() => {
                locationStatus.removeClass('show');
              }, 3000);
            } else {
              throw new Error('Address not found');
            }
          })
          .catch(() => {
            locationInput.val("Location detected (address unavailable)");
            locationStatus.removeClass('success').addClass('error');
            locationStatus.html('<i class="fas fa-exclamation-triangle"></i> Address unavailable, but location detected');
            
            setTimeout(() => {
              locationStatus.removeClass('show');
            }, 3000);
          });
      }


      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            latitudeInput.val(lat);
            longitudeInput.val(lon);

            reverseGeocode(lat, lon);
          }, 
          function(error) {
            locationInput.val("Unable to detect location. Please enable location services.");
            locationInput.prop('readonly', false);
            locationInput.attr('placeholder', 'Please enter your location manually...');
            
            locationStatus.removeClass('success').addClass('error');
            locationStatus.html('<i class="fas fa-exclamation-triangle"></i> Location access denied. Please enter manually.');
            
            setTimeout(() => {
              locationStatus.removeClass('show');
            }, 5000);
          },
          {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 300000
          }
        );
      } else {
        locationInput.val("Geolocation not supported by this browser.");
        locationInput.prop('readonly', false);
        locationInput.attr('placeholder', 'Please enter your location manually...');
        
        locationStatus.removeClass('success').addClass('error');
        locationStatus.html('<i class="fas fa-exclamation-triangle"></i> Geolocation not supported');
        
        setTimeout(() => {
          locationStatus.removeClass('show');
        }, 5000);
      }

   
      $("#emergencyForm").on('submit', function(e) {
        const specialty = $("#speciality").val();
        const location = locationInput.val();
        
        if (!specialty) {
          e.preventDefault();
          alert('Please select the type of medical assistance needed.');
          return;
        }
        
        if (!location || location.includes('Unable to detect')) {
          e.preventDefault();
          alert('Please ensure your location is detected or enter it manually.');
          return;
        }

     
        findBtn.prop('disabled', true);
        findBtn.find('span').text('Searching Hospitals...');
        loadingSpinner.show();
        findBtn.removeClass('pulse');
      });

      
      locationInput.on('input', function() {
        if (!$(this).prop('readonly')) {

          latitudeInput.val('');
          longitudeInput.val('');
        }
      });

     
      const emergencyInfo = `
        <div class="alert alert-danger mt-3" role="alert">
          <h6><i class="fas fa-phone-alt"></i> Emergency Hotlines:</h6>
          <div><strong>Ambulance:</strong> 108 | <strong>Police:</strong> 100 | <strong>Fire:</strong> 101</div>
          <small>For life-threatening emergencies, call immediately!</small>
        </div>
      `;
      
      $('.left-section').append(emergencyInfo);
    });
  </script>
</body>
</html>
