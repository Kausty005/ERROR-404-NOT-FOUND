<?php
session_start();

// Retrieve GET parameters
$latitude = $_GET['latitude'] ?? 0;
$longitude = $_GET['longitude'] ?? 0;
$injury = $_GET['injury'] ?? '';
$location = $_GET['location'] ?? '';

// Map injury to specialty
$specialtyMapping = [
    'cardiologist' => 'Cardiologist',
    'neurologist' => 'Neurologist',
    'ophthalmologist' => 'Ophthalmologist',
    'orthopedist' => 'Orthopedist',
    'general_surgeon' => 'General Surgeon',
    'emergency_physician' => 'Emergency Physician',
    'pediatrician' => 'Pediatrician',
    'dermatologist' => 'Dermatologist',
    'pulmonologist' => 'Pulmonologist',
    'other' => 'General Medicine'
];

$specialty = $specialtyMapping[$injury] ?? 'General Medicine';

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "HospitalDB";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query with Haversine formula for distance calculation
$query = "SELECT id, name, latitude, longitude, speciality,
          (6371 * acos( cos( radians(?) ) * cos( radians(latitude) ) 
          * cos( radians(longitude) - radians(?) ) + sin( radians(?) ) * sin( radians(latitude) ) )) AS distance
          FROM hospitals
          WHERE speciality = ?
          ORDER BY distance
          LIMIT 5";

$stmt = $conn->prepare($query);
$stmt->bind_param("ddds", $latitude, $longitude, $latitude, $specialty);
$stmt->execute();
$result = $stmt->get_result();

$hospitals = [];
while ($row = $result->fetch_assoc()) {
    $hospitals[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nearest Hospitals for <?php echo htmlspecialchars($specialty); ?></title>
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
      max-width: 1200px;
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
    }

    .location-info {
      background: linear-gradient(45deg, #667eea, #764ba2);
      color: white;
      padding: 15px 25px;
      border-radius: 50px;
      display: inline-block;
      font-weight: 500;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .hospital-card {
      background: white;
      border-radius: 15px;
      padding: 25px;
      margin-bottom: 25px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
      cursor: pointer;
      border: 1px solid #e9ecef;
      position: relative;
      overflow: hidden;
    }

    .hospital-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(45deg, #667eea, #764ba2);
      transform: scaleX(0);
      transition: transform 0.3s ease;
    }

    .hospital-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .hospital-card:hover::before {
      transform: scaleX(1);
    }

    .hospital-name {
      color: var(--dark-color);
      font-weight: 600;
      font-size: 1.3rem;
      margin-bottom: 15px;
    }

    .hospital-info {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .info-item {
      display: flex;
      align-items: center;
      gap: 10px;
      color: var(--secondary-color);
    }

    .info-icon {
      color: var(--primary-color);
      width: 20px;
    }

    .distance-badge {
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      padding: 5px 15px;
      border-radius: 20px;
      font-size: 0.9rem;
      font-weight: 500;
      position: absolute;
      top: 20px;
      right: 20px;
    }

    .no-hospitals {
      text-align: center;
      padding: 60px 20px;
      background: white;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .no-hospitals i {
      font-size: 4rem;
      color: var(--warning-color);
      margin-bottom: 20px;
    }

    .new-search-btn {
      background: linear-gradient(45deg, #667eea, #764ba2);
      border: none;
      color: white;
      padding: 15px 30px;
      border-radius: 50px;
      font-weight: 600;
      font-size: 1.1rem;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .new-search-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
      color: white;
    }

    /* Enhanced Popup Styles */
    #hospitalDetailsPopup {
      position: fixed;
      bottom: -60vh;
      left: 0;
      width: 100%;
      height: 60vh;
      background: white;
      box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.3);
      transition: bottom 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      z-index: 1050;
      padding: 30px;
      overflow-y: auto;
      border-top-left-radius: 25px;
      border-top-right-radius: 25px;
    }

    #hospitalDetailsPopup.show {
      bottom: 0;
    }

    .popup-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
      padding-bottom: 15px;
      border-bottom: 2px solid #e9ecef;
    }

    .popup-close {
      background: var(--danger-color);
      color: white;
      border: none;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      font-size: 1.2rem;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .popup-close:hover {
      background: #c82333;
      transform: rotate(90deg);
    }

    .popup-hospital-name {
      color: var(--primary-color);
      font-weight: 700;
      font-size: 1.8rem;
      margin: 0;
    }

    .popup-details {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .detail-card {
      background: var(--light-color);
      padding: 20px;
      border-radius: 12px;
      text-align: center;
      border: 1px solid #dee2e6;
    }

    .detail-icon {
      font-size: 2rem;
      color: var(--primary-color);
      margin-bottom: 10px;
    }

    .detail-value {
      font-size: 1.2rem;
      font-weight: 600;
      color: var(--dark-color);
    }

    .detail-label {
      color: var(--secondary-color);
      font-size: 0.9rem;
    }

    .book-btn {
      background: linear-gradient(45deg, #28a745, #20c997);
      border: none;
      color: white;
      padding: 15px 40px;
      border-radius: 50px;
      font-size: 1.2rem;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
      width: 100%;
    }

    .book-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .main-container {
        margin: 10px;
        padding: 20px;
      }

      .page-title {
        font-size: 2rem;
      }

      .hospital-card {
        padding: 20px;
      }

      .distance-badge {
        position: static;
        display: inline-block;
        margin-top: 10px;
      }

      #hospitalDetailsPopup {
        height: 70vh;
        padding: 20px;
      }

      .popup-details {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <div class="main-container">
    <div class="page-header">
      <h1 class="page-title">
        <i class="fas fa-hospital-alt"></i>
        Nearest Hospitals
      </h1>
      <div class="location-info">
        <i class="fas fa-map-marker-alt"></i>
        <?php echo htmlspecialchars($location); ?>
      </div>
    </div>

    <div class="row">
      <?php if (count($hospitals) > 0): ?>
        <?php foreach ($hospitals as $hospital): ?>
          <div class="col-lg-6 col-xl-4">
            <div class="hospital-card" onclick="showHospitalDetails('<?php echo addslashes($hospital['name']); ?>', <?php echo round($hospital['distance'], 2); ?>)">
              <div class="distance-badge">
                <?php echo round($hospital['distance'], 2); ?> km
              </div>
              
              <h5 class="hospital-name"><?php echo htmlspecialchars($hospital['name']); ?></h5>
              
              <div class="hospital-info">
                <div class="info-item">
                  <i class="fas fa-user-md info-icon"></i>
                  <span><strong>Specialty:</strong> <?php echo htmlspecialchars($hospital['speciality']); ?></span>
                </div>
                <div class="info-item">
                  <i class="fas fa-map-pin info-icon"></i>
                  <span><strong>Location:</strong> <?php echo $hospital['latitude']; ?>, <?php echo $hospital['longitude']; ?></span>
                </div>
                <div class="info-item">
                  <i class="fas fa-clock info-icon"></i>
                  <span><strong>Status:</strong> <span class="text-success">Available</span></span>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12">
          <div class="no-hospitals">
            <i class="fas fa-exclamation-triangle"></i>
            <h3>No Hospitals Found</h3>
            <p class="text-muted">Sorry, we couldn't find any hospitals with the selected specialty in your area.</p>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <div class="text-center mt-4">
      <a href="emergency_location.php" class="btn new-search-btn">
        <i class="fas fa-search"></i>
        New Search
      </a>
    </div>
  </div>

  <!-- Enhanced Hospital Details Popup -->
  <div id="hospitalDetailsPopup">
    <div class="popup-header">
      <h3 class="popup-hospital-name" id="popupHospitalName"></h3>
      <button class="popup-close" onclick="hideHospitalDetails()">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <div class="popup-details">
      <div class="detail-card">
        <i class="fas fa-route detail-icon"></i>
        <div class="detail-value" id="popupDistance"></div>
        <div class="detail-label">Distance</div>
      </div>
      <div class="detail-card">
        <i class="fas fa-bed detail-icon"></i>
        <div class="detail-value" id="popupBeds"></div>
        <div class="detail-label">Available Beds</div>
      </div>
      <div class="detail-card">
        <i class="fas fa-user-md detail-icon"></i>
        <div class="detail-value" id="popupDoctorCount"></div>
        <div class="detail-label">Doctors Available</div>
      </div>
    </div>

    <div class="mb-3">
      <strong>Available Doctors:</strong>
      <p id="popupDoctors" class="text-muted"></p>
    </div>

    <button class="book-btn" onclick="bookNow()">
      <i class="fas fa-calendar-check"></i>
      Book Appointment Now
    </button>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const doctorNames = ["Dr. Smith", "Dr. Johnson", "Dr. Williams", "Dr. Brown", "Dr. Jones", "Dr. Miller", "Dr. Davis", "Dr. Wilson", "Dr. Taylor", "Dr. Anderson"];

    function showHospitalDetails(hospitalName, distance) {
      const bedsAvailable = Math.floor(Math.random() * 16);
      const numDoctors = Math.floor(Math.random() * 6);
      let doctorsInfo = "";
      
      if (numDoctors > 0) {
        let shuffled = [...doctorNames].sort(() => 0.5 - Math.random());
        let selected = shuffled.slice(0, numDoctors);
        doctorsInfo = selected.join(', ');
      } else {
        doctorsInfo = "No doctors currently available";
      }

      document.getElementById("popupHospitalName").innerText = hospitalName;
      document.getElementById("popupDistance").innerText = `${distance} km`;
      document.getElementById("popupBeds").innerText = bedsAvailable;
      document.getElementById("popupDoctorCount").innerText = numDoctors;
      document.getElementById("popupDoctors").innerText = doctorsInfo;

      document.getElementById("hospitalDetailsPopup").classList.add("show");
    }

    function hideHospitalDetails() {
      document.getElementById("hospitalDetailsPopup").classList.remove("show");
    }

    function bookNow() {
      const hospitalName = document.getElementById("popupHospitalName").innerText;
      const injuryType = "<?php echo $specialty; ?>";
      window.location.href = `booking_confirmation.php?hospital=${encodeURIComponent(hospitalName)}&injury=${encodeURIComponent(injuryType)}`;
    }

    // Close popup when clicking outside
    document.addEventListener('click', function(event) {
      const popup = document.getElementById('hospitalDetailsPopup');
      if (event.target === popup) {
        hideHospitalDetails();
      }
    });
  </script>
</body>
</html>
