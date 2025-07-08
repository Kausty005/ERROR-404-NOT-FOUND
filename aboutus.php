<?php
session_start();

?>

<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   About Us - Ambulance Emergency
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet"/>
  <style>
   * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #4e4ef0 0%, #0239a7 100%);
            color: #333;
            line-height: 1.6;
            overflow-x: hidden;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background: linear-gradient(135deg, #0239a7 0%, #4e4ef0 100%);
            color: white;
            padding: 50px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(2, 57, 167, 0.3);
        }

        header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        header h1 {
            font-size: 4em;
            font-weight: 700;
            margin: 0;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.4);
            position: relative;
            z-index: 1;
            animation: fadeInUp 1s ease-out;
            letter-spacing: 2px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .about-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 40px;
            margin-top: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            position: relative;
            overflow: hidden;
            animation: slideInLeft 0.8s ease-out;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .about-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #ff6b6b, #ee5a24, #ff6b6b);
            background-size: 200% 100%;
            animation: shimmer 2s linear infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .about-section h2 {
            font-size: 2.8em;
            margin-bottom: 25px;
            color: #0239a7;
            font-weight: 700;
            position: relative;
            display: inline-block;
            text-shadow: 0 2px 4px rgba(2, 57, 167, 0.2);
        }

        .about-section h2::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #4e4ef0, #0239a7);
            border-radius: 2px;
            box-shadow: 0 2px 8px rgba(78, 78, 240, 0.3);
        }

        .about-section p {
            font-size: 1.4em;
            color: #444;
            margin-bottom: 25px;
            font-weight: 300;
            text-align: justify;
            line-height: 1.8;
        }

        .team-section {
            margin-top: 60px;
        }

        .team-section h2 {
            font-size: 2.5em;
            margin-bottom: 40px;
            text-align: center;
            color: white;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .team-member {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(15px);
            padding: 35px;
            border-radius: 25px;
            box-shadow: 0 20px 50px rgba(2, 57, 167, 0.15);
            border: 1px solid rgba(255,255,255,0.3);
            text-align: center;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            animation: slideInUp 0.8s ease-out;
            animation-fill-mode: both;
        }

        .team-member:nth-child(1) { animation-delay: 0.1s; }
        .team-member:nth-child(2) { animation-delay: 0.2s; }
        .team-member:nth-child(3) { animation-delay: 0.3s; }
        .team-member:nth-child(4) { animation-delay: 0.4s; }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .team-member::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(78, 78, 240, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .team-member:hover::before {
            left: 100%;
        }

        .team-member:hover {
            transform: translateY(-15px);
            box-shadow: 0 35px 80px rgba(2, 57, 167, 0.25);
            border-color: rgba(78, 78, 240, 0.3);
        }

        .team-member img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            margin-bottom: 25px;
            object-fit: cover;
            border: 4px solid #4e4ef0;
            box-shadow: 0 10px 30px rgba(78, 78, 240, 0.3);
            transition: all 0.4s ease;
        }

        .team-member:hover img {
            transform: scale(1.08);
            box-shadow: 0 15px 40px rgba(78, 78, 240, 0.4);
            border-color: #0239a7;
        }

        .team-member h3 {
            font-size: 1.7em;
            margin-bottom: 12px;
            color: #0239a7;
            font-weight: 600;
            text-shadow: 0 1px 3px rgba(2, 57, 167, 0.2);
        }

        .team-member p {
            font-size: 1.1em;
            color: #555;
            font-weight: 400;
            margin: 0;
            line-height: 1.6;
        }

        footer {
            background: linear-gradient(135deg, #0239a7 0%, #4e4ef0 100%);
            color: white;
            text-align: center;
            padding: 40px 0;
            margin-top: 80px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 -10px 40px rgba(2, 57, 167, 0.2);
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #4e4ef0, #0239a7, #4e4ef0);
            background-size: 200% 100%;
            animation: shimmer 2s linear infinite;
        }

        footer p {
            margin: 0;
            font-size: 1.2em;
            font-weight: 300;
            text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            header h1 {
                font-size: 2.5em;
            }
            
            .about-section {
                padding: 25px;
                margin-top: 30px;
            }
            
            .about-section h2 {
                font-size: 2em;
            }
            
            .about-section p {
                font-size: 1.1em;
            }
            
            .team-section h2 {
                font-size: 2em;
            }
            
            .team-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .team-member {
                padding: 15px;
            }
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #4e4ef0, #0239a7);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #0239a7, #4e4ef0);
        }
  </style>
 </head>
 <body>
  <header>
   <h1>
    <i class="fas fa-ambulance"></i> ABOUT THE TEAM
   </h1>
  </header>
  <div class="container">
   <div class="about-section">
    <h2>
     <i class="fas fa-heart"></i> About Us
    </h2>
    <p>
     Welcome to Ambulance Emergency! We are dedicated to providing the fastest and most reliable emergency medical services. Our team of highly trained professionals is here to ensure that you receive the best care possible in times of need.
    </p>
    <p>
     Our mission is to save lives by providing prompt and efficient emergency medical services. We are equipped with state-of-the-art ambulances and medical equipment to handle any emergency situation.
    </p>
   </div>
   <div class="team-section">
    <h2>
     <i class="fas fa-users"></i> Meet Our Team
    </h2>
    <div class="team-grid">
     <div class="team-member">
      <img alt="Portrait of KAUSTUBH GULWADE, BACKEND DEVELOPING MEMBER" src="kg.jpg"/>
      <div>
       <h3>
        KAUSTUBH GULWADE
       </h3>
       <p>
        BACKEND DEVELOPING MEMBER
       </p>
      </div>
     </div>
     <div class="team-member">
      <img alt="Portrait of SRISHTI GUPTA, BACKEND DEVELOPING MEMBER" src="srishti.jpg"/>
      <div>
       <h3>
        SRISHTI GUPTA
       </h3>
       <p>
         BACKEND DEVELOPING MEMBER
       </p>
      </div>
     </div>
     <div class="team-member">
      <img alt="Portrait of RIYA GUPTA, GROUP MEMBER AND FRONTEND DEVELOPING MEMBER" src="rg.jpg"/>
      <div>
       <h3>
        RIYA GUPTA
       </h3>
       <p>
         FRONTEND DEVELOPING MEMBER
       </p>
      </div>
     </div>
     <div class="team-member">
      <img alt="Portrait of OMKAR KATARE GROUP MEMBER AND FRONTEND DEVELOPING MEMBER" src="omkar.jpeg"/>
      <div>
       <h3>
        OMKAR KATARE
       </h3>
       <p>
         FRONTEND DEVELOPING MEMBER
       </p>
      </div>
     </div>
    </div>
   </div>
  </div>
  <footer>
   <p>
    <i class="fas fa-copyright"></i> 2024-2025 Ambulance Emergency. All rights reserved.
   </p>
  </footer>
 </body>
</html>