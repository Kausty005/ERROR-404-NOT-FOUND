<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>INSTANT BED RESERVER - Your Health, Our Priority</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      scroll-behavior: smooth;
    }    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f8fafc;
      line-height: 1.6;
      color: #b2d0f3;
    }
    
    header {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
      box-shadow: 0 2px 20px rgba(6, 6, 186, 0.1);
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    
    .header-content {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 5%;
      max-width: 1400px;
      margin: 0 auto;
    }
    
    .logo-section {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    .logo-icon {
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, #14be9a, #0f9b7a);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 24px;
      font-weight: bold;
      box-shadow: 0 4px 15px rgba(2, 44, 84, 0.3);
    }
    
    .logo {
      font-size: 26px;
      font-weight: 700;
      color: #4e4ef0;
      cursor: pointer;
      transition: color 0.3s;
    }
    
    .logo:hover {
      color: #022163;
    }
    
    nav ul {
      list-style: none;
      display: flex;
      gap: 30px;
      align-items: center;
    }
    
    nav ul li a {
      text-decoration: none;
      color: #0a3d89;
      font-weight: 500;
      font-size: 16px;
      padding: 8px 0;
      position: relative;
      transition: color 0.3s;
    }
    
    nav ul li a:hover {
      color: #011b68;
    }
    
    nav ul li a::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 0;
      height: 2px;
      background: #063378;
      transition: width 0.3s;
    }
    
    nav ul li a:hover::after {
      width: 100%;
    }
    
    .login-btn {
      background: linear-gradient(135deg, #01266b, #022a67);
      color: white;
      padding: 12px 24px;
      border: none;
      border-radius: 25px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      box-shadow: 0 4px 15px rgba(65, 65, 70, 0.3);
    }
    
    .login-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(65, 65, 70, 0.4);
      background: linear-gradient(135deg, #043476, #3b3bed);
    }
    
    .hero-section {
      background: linear-gradient(135deg, #3333cf 0%, #053bc2 100%);
      color: white;
      padding: 80px 5%;
      display: flex;
      align-items: center;
      min-height: 500px;
      position: relative;
      overflow: hidden;
    }
    
    .hero-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 300"><path d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1008,160,1032,176L1056,192L1056,320L1032,320C1008,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z" fill="rgba(255,255,255,0.1)"/></svg>') repeat-x;
      opacity: 0.1;
    }
    
    .hero-content {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      align-items: center;
      position: relative;
      z-index: 1;
    }
    
    .hero-text {
      padding-right: 20px;
    }
    
    .hero-title {
      font-size: 48px;
      font-weight: 700;
      margin-bottom: 20px;
      line-height: 1.2;
    }
    
    .hero-subtitle {
      font-size: 18px;
      margin-bottom: 30px;
      opacity: 0.9;
      line-height: 1.6;
    }
    
    .hero-buttons {
      display: flex;
      gap: 20px;
      margin-top: 30px;
    }
    
    .hero-btn {
      padding: 15px 30px;
      border: none;
      border-radius: 25px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      text-decoration: none;
      display: inline-block;
    }
    
    .hero-btn-primary {
      background: linear-gradient(135deg, #14be9a, #0f9b7a);
      color: white;
    }
    
    .hero-btn-secondary {
      background: transparent;
      color: white;
      border: 2px solid white;
    }
    
    .hero-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }
    
    .hero-image {
      position: relative;
      height: 400px;
      background: white;
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #f0fffe 0%, #e6fffe 100%);
    }
    
    .hero-image::before {
      content: '🏥 Healthcare Excellence';
      font-size: 18px;
      color: #012248;
      font-weight: 600;
    }
    
    .search-section {
      background: white;
      padding: 40px 10%;
      box-shadow: 0 -5px 20px rgba(1, 52, 118, 0.05);
      margin-top: -30px;
      position: relative;
      z-index: 2;
    }
    
    .search-container {
      max-width: 800px;
      margin: 0 auto;
    }
    
    .search-bar {
      position: relative;
      display: flex;
      align-items: center;
      background: white;
      border-radius: 50px;
      box-shadow: 0 10px 30px rgba(1, 52, 118, 0.05);
      overflow: hidden;
      border: 2px solid #e9ecef;
      transition: all 0.3s;
    }
    
    .search-bar:focus-within {
      border-color: #053169;
      box-shadow: 0 10px 30px rgba(65, 65, 70, 0.25);
    }
    
    .search-icon {
      padding: 0 20px;
      color: #052e6a;
      font-size: 20px;
    }
    
    .search-bar input {
      flex: 1;
      padding: 30px 33px;
      border: none;
      outline: none;
      font-size: 16px;
      background: transparent;
      color: #042d67;
    }
    
    .search-bar input::placeholder {
      color: #888;
    }
    
    .search-btn {
      background: linear-gradient(135deg, #03358b, #023085);
      color: white;
      padding: 30px 33px;
      border: none;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
    }
    
    .search-btn:hover {
      background: linear-gradient(135deg, #2a2a2e, #414146);
    }

    .search-suggestions {
      position: absolute;
      top: 45px;
      background-color: rgb(220, 213, 213);
      width: 60%;
      max-height: 300px;
      overflow-y: auto;
      box-shadow: 0 4px 6px rgb(0, 0, 0, 0.1);
      z-index: 1000;
      display: none;
    }
    .suggestion-item {
      padding: 10px;
      cursor: pointer;
      transition: background 0.3s;
    }
    .suggestion-item:hover {
      background: #f0f0f0;
    }
    
    .services-section {
      padding: 80px 5%;
      background: white;
    }
    
    .services-container {
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .section-title {
      text-align: center;
      font-size: 36px;
      font-weight: 700;
      color: #0239a7;
      margin-bottom: 20px;
    }
    
    .section-subtitle {
      text-align: center;
      font-size: 30px;
      color:#0239a7;
      margin-bottom: 60px;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }
    
    .services-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr); 
    gap: 20px; 
    margin-top: 40px;
    }
    
    
    .service-card {
      background: white;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(6, 60, 142, 0.08);
      transition: all 0.3s;
      cursor: pointer;
      border: 1px solid #f0f0f0;
    }
    
    .service-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(6, 60, 142, 0.08);
      border-color: #042f7f;
    }
    
    .service-image {
      height: 200px;
      background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #073996;
      font-size: 16px;
      font-weight: 600;
      position: relative;
      overflow: hidden;
    }
    
    .service-image::before {
      content: attr(data-placeholder);
      text-align: center;
    }
    
    .service-content {
      padding: 30px;
      text-align: center;
    }
    
    .service-icon {
      width: 60px;
      height: 60px;
      margin: 0 auto 20px;
      background: linear-gradient(135deg, #414146, #2a2a2e);
      border-radius: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 24px;
      transition: all 0.3s;
    }
    
    .service-card:hover .service-icon {
      transform: scale(1.1);
    }
    
    .service-title {
      font-size: 22px;
      font-weight: 600;
      color: #0a3180;
      margin-bottom: 15px;
    }
    
    .service-description {
      color: #062e79;
      font-size: 16px;
      line-height: 1.6;
    }
    
    .features-section {
      padding: 80px 5%;
      background: linear-gradient(135deg, #eff1f4 0%, #e2e5e9 100%);
    }
    
    .features-container {
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .features-content {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      align-items: center;
      margin-top: 40px;
    }
    
    .features-image {
      height: 400px;
      background: white;
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #0c428e;
      font-size: 18px;
      font-weight: 600;
      box-shadow: 0 10px 30px rgba(66, 66, 231, 0.1);
    }
    
    .features-image::before {
      text-align: center;
    }
    
    .features-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 30px;
    }
    
    .feature-card {
      background: rgb(245, 247, 248);
      border-radius: 15px;
      padding: 25px;
      display: flex;
      align-items: center;
      gap: 20px;
      box-shadow: 0 5px 20px rgba(96, 161, 241, 0.05);
      transition: all 0.3s;
    }
    
    .feature-card:hover {
      transform: translateX(10px);
      box-shadow: 0 10px 30px rgba(51, 107, 172, 0.1);
    }
    
    .feature-icon {
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, #151595, #2b2bd3);
      border-radius: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 24px;
      flex-shrink: 0;
    }
    
    .feature-info {
      flex: 1;
    }
    
    .feature-title {
      font-size: 18px;
      font-weight: 600;
      color: #2e2ef2;
      margin-bottom: 5px;
    }
    
    .feature-description {
      color: #2742e0;
      font-size: 14px;
    }
    
    .gallery-section {
      padding: 80px 5%;
      background: white;
    }
    
    .gallery-container {
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
      margin-top: 40px;
    }
    
    .gallery-item {
      height: 250px;
      background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
      border-radius: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #04227e;
      font-size: 16px;
      font-weight: 600;
      transition: all 0.3s;
      cursor: pointer;
      overflow: hidden;
      position: relative;
    }
    
    .gallery-item:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 30px rgba(65, 65, 70, 0.2);
    }
    
    .gallery-item::before {
      content: attr(data-placeholder);
      text-align: center;
      z-index: 1;
    }
    
    .stats-section {
      background: linear-gradient(135deg, #414146, #2a2a2e);
      color: white;
      padding: 60px 5%;
      text-align: center;
    }
    
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 40px;
      max-width: 1000px;
      margin: 0 auto;
    }
    
    .stat-item {
      text-align: center;
    }
    
    .stat-number {
      font-size: 48px;
      font-weight: 700;
      margin-bottom: 10px;
    }
    
    .stat-label {
      font-size: 16px;
      opacity: 0.9;
    }
    
    .testimonials-section {
      padding: 80px 5%;
      background: #f8fafc;
    }
    
    .testimonials-container {
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .testimonials-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 30px;
      margin-top: 40px;
    }
    
    .testimonial-card {
      background: white;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(65, 65, 70, 0.08);
      position: relative;
      text-align: center;
    }
    
    .testimonial-avatar {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #0d339d;
      font-size: 14px;
      font-weight: 600;
      margin: 0 auto 20px;
    }
    
    .testimonial-avatar::before {
      content: '👤';
      font-size: 32px;
    }
    
    .testimonial-text {
      font-style: italic;
      color: #082f9b;
      margin-bottom: 20px;
      line-height: 1.6;
    }
    
    .testimonial-author {
      font-weight: 600;
      color: #2828f4;
    }
    
    .testimonial-rating {
      color: #fbbf24;
      font-size: 18px;
      margin-bottom: 15px;
    }
    
    footer {
      background: #4343e5;
      color: white;
      padding: 60px 5% 30px;
    }
    
    .footer-content {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1fr;
      gap: 40px;
      margin-bottom: 40px;
    }
    
    .footer-section h4 {
      font-size: 20px;
      margin-bottom: 25px;
      color: #14be9a;
      font-weight: 600;
    }
    
    .footer-section p {
      color: #ccc;
      margin-bottom: 15px;
      line-height: 1.6;
    }
    
    .footer-section ul {
      list-style: none;
    }
    
    .footer-section ul li {
      margin-bottom: 12px;
    }
    
    .footer-section ul li a {
      color: #ccc;
      text-decoration: none;
      transition: color 0.3s;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .footer-section ul li a:hover {
      color: #14be9a;
    }
    
    .footer-section ul li a::before {
      content: '→';
      opacity: 0;
      transition: opacity 0.3s;
    }
    
    .footer-section ul li a:hover::before {
      opacity: 1;
    }
    
    .social-links {
      display: flex;
      gap: 15px;
      margin-top: 20px;
    }
    
    .social-link {
      width: 45px;
      height: 45px;
      background: linear-gradient(135deg, #14be9a, #0f9b7a);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-decoration: none;
      transition: all 0.3s;
      font-size: 18px;
    }
    
    .social-link:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(20, 190, 154, 0.3);
      background: linear-gradient(135deg, #0f9b7a, #14be9a);
    }
    
    .contact-info {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    
    .contact-item {
      display: flex;
      align-items: center;
      gap: 12px;
      color: #ccc;
    }
    
    .contact-icon {
      width: 35px;
      height: 35px;
      background: linear-gradient(135deg, #14be9a, #0f9b7a);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 14px;
      flex-shrink: 0;
    }
    
    .footer-bottom {
      text-align: center;
      padding-top: 30px;
      border-top: 1px solid #555;
      color: #999;
    }
    
    .footer-bottom p {
      margin-bottom: 10px;
    }
    
    .footer-links {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin-top: 20px;
    }
    
    .footer-links a {
      color: #ccc;
      text-decoration: none;
      transition: color 0.3s;
    }
    
    .footer-links a:hover {
      color: #022248;
    }
    
    /* Mobile Responsiveness */
    @media (max-width: 768px) {
      .header-content {
        flex-direction: column;
        gap: 20px;
      }
      
      nav ul {
        flex-direction: column;
        gap: 15px;
      }
      
      .hero-content {
        grid-template-columns: 1fr;
        text-align: center;
      }
      
      .hero-title {
        font-size: 36px;
      }
      
      .hero-buttons {
        justify-content: center;
        flex-direction: column;
      }
      
      .search-bar {
        flex-direction: column;
        border-radius: 15px;
      }
      
      .search-btn {
        width: 100%;
      }
      
      .services-grid {
        grid-template-columns: 1fr;
      }
      
      .features-content {
        grid-template-columns: 1fr;
      }
      
      .footer-content {
        grid-template-columns: 1fr;
        gap: 30px;
      }
      
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .gallery-grid {
        grid-template-columns: 1fr;
      }
      
      .footer-links {
        flex-direction: column;
        gap: 15px;
      }
    }
    
    /* Animations */
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
    
    @keyframes pulse {
      0%, 100% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.05);
      }
    }
    
    .service-card, .feature-card, .testimonial-card {
      animation: fadeInUp 0.6s ease-out;
    }
    
    .stats-section .stat-number {
      animation: pulse 2s ease-in-out infinite;
    }
    
    
    .scroll-top {
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, #2f2fcd, #3333f0);
      border: none;
      border-radius: 50%;
      color: white;
      font-size: 18px;
      cursor: pointer;
      box-shadow: 0 4px 15px  rgba(47, 47, 215, 0.4);
      transition: all 0.3s;
      opacity: 0;
      visibility: hidden;
      z-index: 1000;
    }
    
    .scroll-top.show {
      opacity: 1;
      visibility: visible;
    }
    
    .scroll-top:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(47, 47, 215, 0.4);
    }
  </style>
</head>
<body>
  <header>
    <div class="header-content">
      <div class="logo-section">
        <div class="logo-icon">🏥</div>
        <div class="logo" onclick="scrollToTop()">INSTANT BED RESERVER</div>
      </div>
      <nav>
        <ul>
          <li><a href="my_appointments.php">BOOK APPOINTMENT</a></li>
          <li><a href="booking_confirmation.php">EMERGENCY</a></li>
          <li><a href="profile.php">PROFILE</a></li>
          <li><a href="aboutus.php">ABOUT US</a></li>
          <li><a href="register.php" class="login-btn">Login / Signup</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <section class="hero-section">
    <div class="hero-content">
      <div class="hero-text">
        <h1 class="hero-title">Your Health, Our Priority</h1>
        <p class="hero-subtitle">Book hospital beds instantly, access emergency services, and manage your healthcare appointments with ease. Join thousands of satisfied patients who trust us with their health.</p>
        <div class="hero-buttons">
          <a href="doc_appointment.php" class="hero-btn hero-btn-primary">Book Now</a>
          <a href="booking_confirmation.php" class="hero-btn hero-btn-secondary">Emergency</a>
        </div>
      </div>
      
        <img src="https://i.pinimg.com/736x/d5/e1/3b/d5e13b1559bed686a2ab22d1914a16f6.jpg" alt="Emergency Services" style="width: 100%; height: 400px; object-fit: cover;">
        
      </div>
    </div>
  </section>

  <section class="search-section">
    <div class="search-container">
      <div class="search-bar">
        <div class="search-icon">🔍</div>
        <input type="text" id="search-input" placeholder="Search Diseases" onkeyup="showSuggestions()">
        <div id="searchSuggestions" class="search-suggestions"></div>
      </div>
    </div>
  </section>

  <section class="services-section" id="services">
        <div class="services-container">
            <h2 class="section-title">Our Services</h2>
            <p class="section-subtitle">Comprehensive healthcare solutions at your fingertips</p>
            
            <div class="services-grid">
                <a href="emergency_location.php" class="service-card" onclick="handleEmergency()">
                    <img src="https://i.pinimg.com/736x/db/6d/31/db6d3148a32f383c1bf040d5ea27951b.jpg" style="width: 100%; height: 250px; object-fit: cover;" alt="Emergency Services">
                    <div class="service-content">
                        <div class="service-icon">🚨</div>
                        <h3 class="service-title">Emergency Services</h3>
                        <p class="service-description">24/7 emergency care with immediate response and expert medical attention when you need it most.</p>
                    </div>
                </a>
                
                <a href="doc_appointment.php" class="service-card" onclick="handleBooking()">
                    <img src="https://i.pinimg.com/736x/6d/cb/25/6dcb2576a88b791d3d42c67b58157945.jpg" style="width: 100%; height: 250px; object-fit: cover;" alt="Book Appointment">
                    <div class="service-content">
                        <div class="service-icon">📅</div>
                        <h3 class="service-title">Book Appointment</h3>
                        <p class="service-description">Schedule appointments with top doctors and specialists. Easy booking, confirmed slots, and reminder notifications.</p>
                    </div>
                </a>
                
                <a href="Online_Appointments.html" class="service-card" onclick="handleBooking()">
                    <img src="https://i.pinimg.com/736x/fc/0f/89/fc0f899aa5a7b9ebdbc6df62865ec87a.jpg" style="width: 100%; height: 250px; object-fit: cover;" alt="Online Consultation">
                    <div class="service-content">
                        <div class="service-icon">💻</div>
                        <h3 class="service-title">Online Consultation</h3>
                        <p class="service-description">Online consultation through Google Meet with automatic email notifications for appointment confirmation and reminders.</p>
                    </div>
                </a>
                
                <a href="call_ambulance.php" class="service-card" onclick="handleAmbulance()">
                    <img src="https://i.pinimg.com/736x/6f/54/fe/6f54fe716a164d2bfb8010e7426eca45.jpg" style="width: 100%; height: 250px; object-fit: cover;" alt="Ambulance Services">
                    <div class="service-content">
                        <div class="service-icon">🚑</div>
                        <h3 class="service-title">Ambulance Services</h3>
                        <p class="service-description">Fast and reliable ambulance services with trained paramedics and advanced life support equipment.</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

  <section class="features-section" id="features">
    <div class="features-container">
      <h2 class="section-title">Why Choose Us</h2>
      <p class="section-subtitle">Experience healthcare like never before</p>
      
      <div class="features-content">
        <div class="features-image">
           <img src="https://i.pinimg.com/736x/c0/53/f3/c053f3e04716d662df3201d29ca3f461.jpg"  style="width: 100%; height: 400px; object-fit: cover;">
        </div> 
       

        <div class="features-grid">
          <div class="feature-card">
            <div class="feature-icon">⏱️</div>
            <div class="feature-info">
              <div class="feature-title">Real-Time Availability</div>
              <div class="feature-description">Instant updates on bed availability across hospitals, so you never face uncertainty in emergencies.</div>
            </div>
          </div>
          <div class="feature-card">
            <div class="feature-icon">📍</div>
            <div class="feature-info">
              <div class="feature-title">Location Based Search</div>
              <div class="feature-description">Find nearby hospitals and emergency services with precise location tracking and filtering options.</div>
            </div>
          </div>
          <div class="feature-card">
            <div class="feature-icon">🔔</div>
            <div class="feature-info">
              <div class="feature-title">Smart Alerts</div>
              <div class="feature-description">Get real-time notifications for appointment reminders, emergency updates, and follow-up care.</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <div class="footer-content">
      <div class="footer-section">
        <h4>About Instant Bed Reserver</h4>
        <p>We aim to revolutionize healthcare accessibility by providing real-time hospital bed booking and emergency care navigation, saving lives and time.</p>
        <div class="social-links">
          <a class="social-link" href="#">📘</a>
          <a class="social-link" href="#">🐦</a>
          <a class="social-link" href="#">📸</a>
        </div>
      </div>

      

      <div class="footer-section">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="doc_appointment.php">Book Now</a></li>
          <li><a href="call_ambulance.php">Emergency</a></li>
          <li><a href="#services">Services</a></li>
          <li><a href="aboutus.php">Why Us</a></li>
        </ul>
      </div>

      <div class="footer-section">
        <h4>Support</h4>
        <ul>
          <li><a href="#">Help Center</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms of Service</a></li>
        </ul>
      </div>

      <div class="footer-section">
        <h4>Contact Us</h4>
        <div class="contact-info">
          <div class="contact-item"><div class="contact-icon">📞</div>
          <div class="contact-item"><div class="contact-icon">✉️</div> support@instantbed.in</div>
          <div class="contact-item"><div class="contact-icon">📍</div> Pune, Maharashtra, India</div>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; 2025 Instant Bed Reserver. All rights reserved.</p>
      <div class="footer-links">
        <a href="#">Disclaimer</a>
        <a href="#">Feedback</a>
        <a href="#">Careers</a>
      </div>
    </div>
  </footer>

  
  <button class="scroll-top" onclick="scrollToTop()">↑</button>

  <script>
    
    // Disease data
    const diseases = [
      "Diabetes", "Hypertension", "Cancer", "Influenza",
      "COVID-19", "Asthma", "Heart Disease", "Stroke",
      "Arthritis", "COPD"
    ];
  
    function showSuggestions() {
      const input = document.getElementById("search-input").value.toLowerCase();
      const suggestions = document.getElementById("searchSuggestions");
      suggestions.innerHTML = '';
  
      if (input.length > 0) {
        const filtered = diseases.filter(disease => 
          disease.toLowerCase().includes(input)
        ).slice(0, 10);
  
        filtered.forEach(disease => {
          const div = document.createElement('div');
          div.className = 'suggestion-item';
          div.textContent = disease;
          div.onclick = () => selectDisease(disease);
          suggestions.appendChild(div);
        });
  
        suggestions.style.display = 'block';
      } else {
        suggestions.style.display = 'none';
      }
    }
  
    function selectDisease(disease) {
      document.getElementById("search-input").value = disease;
      document.getElementById("searchSuggestions").style.display = 'none';
      // Redirect to disease details page
      window.location.href = `disease_details.php?disease=${encodeURIComponent(disease)}`;
    }
  
    // Close suggestions when clicking outside
    document.addEventListener('click', (e) => {
      if (!e.target.closest('.search-bar')) {
        document.getElementById("searchSuggestions").style.display = 'none';
      }
    });

    const scrollTopBtn = document.querySelector('.scroll-top');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 200) {
        scrollTopBtn.classList.add('show');
      } else {
        scrollTopBtn.classList.remove('show');
      }
    });

    function scrollToTop() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function handleLogin() {
      //alert("Redirecting to login/signup page...");
    }

    function performSearch() {
      const query = document.getElementById('search-input').value;
      alert("Searching for: " + query);
    }

    function searchFunction() {
     
    }

    function handleEmergency() {
      //alert("Navigating to Emergency Services...");
    }

    function handleBooking() {
     // alert("Navigating to Appointment Booking...");
    }

    function handleAmbulance() {
      //alert("Calling Ambulance Service...");
    }
  </script>
</body>
</html>
