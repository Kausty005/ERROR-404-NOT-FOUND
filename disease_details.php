<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Disease Details</title>
  <!-- Bootstrap CSS for styling -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #4a6fa5;
      --secondary-color: #166088;
      --accent-color: #4fc3f7;
      --light-color: #f8f9fa;
      --dark-color: #343a40;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f5f7fa;
      color: #333;
      line-height: 1.6;
    }
    
    .container {
      max-width: 900px;
      margin: 30px auto;
      padding: 20px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .disease-header {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 2px solid var(--accent-color);
    }
    
    .disease-icon {
      font-size: 2.5rem;
      margin-right: 20px;
      color: var(--primary-color);
    }
    
    .disease-title {
      color: var(--secondary-color);
      font-weight: 700;
      margin: 0;
    }
    
    .details-card {
      border: none;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
      margin-bottom: 25px;
      transition: transform 0.3s ease;
    }
    
    .details-card:hover {
      transform: translateY(-5px);
    }
    
    .card-header {
      background-color: var(--primary-color);
      color: white;
      font-weight: 600;
      padding: 15px 20px;
    }
    
    .card-body {
      padding: 20px;
    }
    
    .info-section {
      margin-bottom: 20px;
    }
    
    .info-section h5 {
      color: var(--secondary-color);
      font-weight: 600;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
    }
    
    .info-section h5 i {
      margin-right: 10px;
      color: var(--accent-color);
    }
    
    .info-section p {
      padding-left: 30px;
      margin-bottom: 0;
    }
    
    .btn-back {
      background-color: var(--secondary-color);
      color: white;
      border: none;
      padding: 10px 25px;
      border-radius: 30px;
      font-weight: 500;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
    }
    
    .btn-back:hover {
      background-color: var(--primary-color);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      color: white;
    }
    
    .btn-back i {
      margin-right: 8px;
    }
    
    .not-found {
      text-align: center;
      padding: 30px;
      border-radius: 8px;
      background-color: #fff8e1;
    }
    
    .not-found i {
      font-size: 3rem;
      color: #ffc107;
      margin-bottom: 15px;
    }
    
    .not-found h4 {
      color: var(--dark-color);
      margin-bottom: 15px;
    }
    
    @media (max-width: 768px) {
      .container {
        margin: 15px;
        padding: 15px;
      }
      
      .disease-header {
        flex-direction: column;
        text-align: center;
      }
      
      .disease-icon {
        margin-right: 0;
        margin-bottom: 15px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="disease-header">
      <div class="disease-icon">
        <i class="fas fa-heartbeat"></i>
      </div>
      <h1 id="disease-title" class="disease-title">Disease Details</h1>
    </div>
    
    <div id="details-card" class="details-card" style="display:none;">
      <div class="card-header">
        <i class="fas fa-info-circle mr-2"></i> Disease Information
      </div>
      <div class="card-body">
        <div class="info-section">
          <h5><i class="fas fa-pills"></i> Medication</h5>
          <p id="medication"></p>
        </div>
        <div class="info-section">
          <h5><i class="fas fa-exclamation-triangle"></i> Symptoms</h5>
          <p id="symptoms"></p>
        </div>
        <div class="info-section">
          <h5><i class="fas fa-heart"></i> Possible Cure</h5>
          <p id="cure"></p>
        </div>
      </div>
    </div>
    
    <div id="not-found" class="not-found" style="display:none;">
      <i class="fas fa-question-circle"></i>
      <h4>Disease details not found</h4>
      <p>We couldn't find information about this disease in our database.</p>
    </div>
    
    <a href="index.php" class="btn btn-back mt-3">
      <i class="fas fa-arrow-left"></i> Back to Search
    </a>
  </div>
  
  <script>
    // Predefined data for the top 10 diseases with icons
    const diseaseData = {
      "Diabetes": {
        "icon": "fa-bolt",
        "medication": "Insulin, Metformin, Sulfonylureas, DPP-4 inhibitors, SGLT2 inhibitors",
        "symptoms": "Increased thirst, frequent urination, extreme hunger, unexplained weight loss, fatigue, irritability, blurred vision, slow-healing sores",
        "cure": "Lifestyle changes (healthy eating, regular exercise), blood sugar monitoring, diabetes medications or insulin therapy, bariatric surgery for some patients"
      },
      "Hypertension": {
        "icon": "fa-heartbeat",
        "medication": "ACE inhibitors (Lisinopril), ARBs (Losartan), Calcium channel blockers (Amlodipine), Diuretics (Hydrochlorothiazide), Beta blockers (Metoprolol)",
        "symptoms": "Severe headaches, fatigue or confusion, vision problems, chest pain, difficulty breathing, irregular heartbeat, blood in urine",
        "cure": "DASH diet (low sodium, high potassium), regular physical activity, maintaining healthy weight, limiting alcohol, stress management, medication adherence"
      },
      "Cancer": {
        "icon": "fa-bacterium",
        "medication": "Chemotherapy (Cisplatin, Doxorubicin), Radiation therapy, Immunotherapy (Pembrolizumab), Targeted therapy (Imatinib), Hormone therapy (Tamoxifen)",
        "symptoms": "Fatigue, lump or thickening, weight changes, skin changes, persistent cough, unusual bleeding, night sweats",
        "cure": "Treatment depends on type and stage: surgery, radiation, chemotherapy, immunotherapy, targeted therapy, stem cell transplant, precision medicine approaches"
      },
      "Influenza": {
        "icon": "fa-virus",
        "medication": "Antiviral drugs (Oseltamivir/Tamiflu, Zanamivir), Pain relievers (Acetaminophen, Ibuprofen), Decongestants",
        "symptoms": "Fever over 100.4°F, muscle or body aches, chills, headache, sore throat, runny or stuffy nose, fatigue, sometimes vomiting/diarrhea (more common in children)",
        "cure": "Annual flu vaccination, rest, hydration, antiviral medications if taken early, over-the-counter symptom relief, staying home to prevent spread"
      },
      "COVID-19": {
        "icon": "fa-virus",
        "medication": "Antivirals (Remdesivir, Paxlovid), Monoclonal antibodies, Anti-inflammatories (Dexamethasone), Blood thinners for hospitalized patients",
        "symptoms": "Fever or chills, cough, shortness of breath, fatigue, muscle/body aches, headache, new loss of taste/smell, sore throat, congestion/nausea/diarrhea",
        "cure": "Vaccination and boosters, antiviral treatments for high-risk patients, supportive care (oxygen for severe cases), isolation to prevent spread, monoclonal antibody therapy for some patients"
      },
      "Asthma": {
        "icon": "fa-wind",
        "medication": "Quick-relief inhalers (Albuterol), Inhaled corticosteroids (Fluticasone), Combination inhalers (Advair), Leukotriene modifiers (Montelukast), Theophylline",
        "symptoms": "Shortness of breath, chest tightness or pain, wheezing, coughing (especially at night), trouble sleeping due to breathing difficulties",
        "cure": "Identifying and avoiding triggers, allergy management, long-term control medications, quick-relief inhalers, bronchial thermoplasty for severe cases, regular monitoring"
      },
      "Heart Disease": {
        "icon": "fa-heart",
        "medication": "Statins (Atorvastatin), Beta blockers (Metoprolol), ACE inhibitors (Lisinopril), Aspirin, Calcium channel blockers, Diuretics, Nitroglycerin",
        "symptoms": "Chest pain (angina), shortness of breath, pain/numbness/weakness in legs/arms, pain in neck/jaw/throat/upper abdomen, fatigue, irregular heartbeat",
        "cure": "Lifestyle changes (heart-healthy diet, exercise, smoking cessation), medications, medical procedures (angioplasty, stent placement), surgery (bypass, valve repair), cardiac rehabilitation"
      },
      "Stroke": {
        "icon": "fa-brain",
        "medication": "tPA (clot-busting drug), Antiplatelet drugs (Aspirin), Anticoagulants (Warfarin), Statins, Blood pressure medications",
        "symptoms": "Trouble speaking/understanding, paralysis/numbness in face/arm/leg (often one side), vision problems, headache, trouble walking",
        "cure": "Emergency treatment (tPA within 4.5 hours, mechanical thrombectomy), rehabilitation (physical/occupational/speech therapy), lifestyle changes to prevent recurrence, treatment of underlying conditions"
      },
      "Arthritis": {
        "icon": "fa-bone",
        "medication": "NSAIDs (Ibuprofen, Naproxen), Corticosteroids (Prednisone), DMARDs (Methotrexate), Biologic agents (Etanercept), Analgesics (Acetaminophen)",
        "symptoms": "Joint pain, stiffness, swelling, redness, decreased range of motion, warmth around joint, morning stiffness lasting hours",
        "cure": "Physical therapy, medications, joint-friendly exercise, weight management, assistive devices, surgery (joint repair/replacement), alternative therapies (acupuncture)"
      },
      "COPD": {
        "icon": "fa-lungs",
        "medication": "Bronchodilators (Albuterol, Tiotropium), Inhaled steroids (Fluticasone), Combination inhalers (Advair), Phosphodiesterase-4 inhibitors (Roflumilast), Theophylline",
        "symptoms": "Shortness of breath (especially with activity), wheezing, chest tightness, chronic cough (with/without mucus), frequent respiratory infections, lack of energy",
        "cure": "Smoking cessation, pulmonary rehabilitation, oxygen therapy, medications, lung volume reduction surgery, lung transplant for severe cases, vaccination against flu/pneumonia"
      }
    };

    // Function to get a query parameter value by name
    function getQueryParam(param) {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.get(param);
    }
    
    // Load disease details when page loads
    document.addEventListener("DOMContentLoaded", function() {
      const diseaseName = getQueryParam("disease");
      const disease = diseaseData[diseaseName];
      
      // Set page title
      if (diseaseName) {
        document.title = `${diseaseName} Details | Health Portal`;
        document.getElementById("disease-title").textContent = diseaseName;
      }
      
      if (disease) {
        // Update disease icon
        const iconElement = document.querySelector('.disease-icon i');
        iconElement.className = `fas ${disease.icon}`;
        
        // Fill in disease details
        document.getElementById("medication").textContent = disease.medication;
        document.getElementById("symptoms").textContent = disease.symptoms;
        document.getElementById("cure").textContent = disease.cure;
        
        // Show details card
        document.getElementById("details-card").style.display = "block";
      } else if (diseaseName) {
        // Show not found message
        document.getElementById("not-found").style.display = "block";
      }
    });
  </script>
</body>
</html>