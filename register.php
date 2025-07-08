<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['Signup'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword =  $_POST['confirm_password'];

        // Check if email already exists
        $emailquery = "SELECT * FROM signin WHERE email='$email'";
        $query = mysqli_query($con, $emailquery);
        $emailcount = mysqli_num_rows($query);

        if ($emailcount > 0) {
            ?>
            <script>alert("Email already exists")</script>
         <?php   

        } else {
            if ($password === $cpassword) {
                $pass = password_hash($password, PASSWORD_BCRYPT);
                
                $insertquery = "INSERT INTO signin (email, password ,cpassword) VALUES ('$email', '$pass','$cpassword')";
                $check = mysqli_query($con, $insertquery);
                
                if ($check) {
                    
                    
                } else {
                    ?>
                    <script>alert('Error inserting data')</script>
                 <?php   
                    
                }
            } else {
                ?>
                <script>alert( "Passwords do not match")</script>
             <?php   
                
            }
        }
    }

    if (isset($_POST['Login'])) {
        $emaill = $_POST['email'];
        $passwordl =  $_POST['password'];
        $email_search = "SELECT * FROM signin WHERE email='$emaill'";
        $query = mysqli_query($con, $email_search);
        $email_pass=mysqli_fetch_assoc($query);
        $db_email=$email_pass['email'];
        $db_pass=$email_pass['password'];
        if ($emaill==$db_email){
            $_SESSION['email']=$db_email;
           if(password_verify($passwordl,$db_pass)){
          ?>
           <script>location.replace('index.php')</script>
         <?php
        } else {
            ?>
            <script>alert("Incorrect password")</script>
         <?php   
        }
    } else {
        ?>
        <script>alert("Invalid email")</script>
        <?php   
    }
  
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: "Inter", sans-serif;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .container {
        background: white;
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        width: 100%;
        max-width: 440px;
        position: relative;
    }

    .header {
        background: linear-gradient(135deg, #2742e0 0%, #1e3a8a 100%);
        padding: 40px 30px;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .header-content {
        position: relative;
        z-index: 2;
    }

    .logo {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        backdrop-filter: blur(10px);
    }

    .header h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
        opacity: 0;
        animation: slideUp 0.6s ease forwards;
    }

    .header p {
        font-size: 14px;
        opacity: 0.9;
        animation: slideUp 0.6s ease 0.2s forwards;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-container {
        padding: 40px 30px;
    }

    .tab-buttons {
        display: flex;
        background: #f8fafc;
        border-radius: 16px;
        padding: 6px;
        margin-bottom: 30px;
        position: relative;
    }

    .tab-button {
        flex: 1;
        padding: 12px 20px;
        border: none;
        background: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
    }

    .tab-button.active {
        color: white;
    }

    .tab-indicator {
        position: absolute;
        top: 6px;
        left: 6px;
        width: calc(50% - 6px);
        height: calc(100% - 12px);
        background: #2742e0;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(39, 66, 224, 0.3);
    }

    .tab-indicator.signup {
        left: calc(50% + 0px);
    }

    .form-content {
        position: relative;
        overflow: hidden;
    }

    .form-panel {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-panel.hidden {
        opacity: 0;
        transform: translateX(-20px);
        pointer-events: none;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
    }

    .input-group {
        margin-bottom: 24px;
        position: relative;
    }

    .input-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #374151;
        font-size: 14px;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 16px;
        z-index: 1;
    }

    .input {
        width: 100%;
        padding: 16px 16px 16px 48px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        outline: none;
        transition: all 0.3s ease;
        background: white;
        color: #374151;
    }

    .input::placeholder {
        color: #9ca3af;
    }

    .input:focus {
        border-color: #2742e0;
        box-shadow: 0 0 0 3px rgba(39, 66, 224, 0.1);
    }

    .input:focus + i {
        color: #2742e0;
    }

    .forgot-password {
        display: block;
        text-align: right;
        margin-bottom: 24px;
        font-size: 13px;
        color: #2742e0;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .forgot-password:hover {
        color: #1e3a8a;
    }

    .submit-btn {
        width: 100%;
        padding: 16px;
        background: #2742e0;
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }

    .submit-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .submit-btn:hover::before {
        left: 100%;
    }

    .submit-btn:hover {
        background: #1e3a8a;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(39, 66, 224, 0.3);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    .switch-form {
        text-align: center;
        font-size: 14px;
        color: #64748b;
    }

    .switch-form span {
        color: #2742e0;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .switch-form span:hover {
        color: #1e3a8a;
    }

    /* Responsive design */
    @media (max-width: 480px) {
        .container {
            margin: 10px;
        }
        
        .header {
            padding: 30px 20px;
        }
        
        .form-container {
            padding: 30px 20px;
        }
        
        .header h1 {
            font-size: 24px;
        }
    }

    /* Enhanced animations */
    .input-group {
        animation: slideUp 0.6s ease forwards;
    }

    .input-group:nth-child(2) {
        animation-delay: 0.1s;
    }

    .input-group:nth-child(3) {
        animation-delay: 0.2s;
    }

    .input-group:nth-child(4) {
        animation-delay: 0.3s;
    }

    .submit-btn {
        animation: slideUp 0.6s ease 0.4s forwards;
    }

    .switch-form {
        animation: slideUp 0.6s ease 0.5s forwards;
    }

    /* Loading state */
    .submit-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Success/Error states */
    .input.error {
        border-color: #ef4444;
    }

    .input.success {
        border-color: #10b981;
    }
</style>

<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <div class="logo">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h1 id="headerTitle">Welcome Back</h1>
                <p id="headerSubtitle">Sign in to your account</p>
            </div>
        </div>

        <div class="form-container">
            <div class="tab-buttons">
                <button class="tab-button active" id="loginTab">Sign In</button>
                <button class="tab-button" id="signupTab">Sign Up</button>
                <div class="tab-indicator" id="tabIndicator"></div>
            </div>

            <div class="form-content">
                <!-- Login Form -->
                <div class="form-panel" id="loginPanel">
                    <form method="post">
                        <div class="input-group">
                            <label for="login-email">Email Address</label>
                            <div class="input-wrapper">
                                <input type="email" name="email" id="login-email" class="input" placeholder="Enter your email" required>
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>
                        <div class="input-group">
                            <label for="login-password">Password</label>
                            <div class="input-wrapper">
                                <input type="password" name="password" id="login-password" class="input" placeholder="Enter your password" required>
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                        <a href="#" class="forgot-password" onclick="alert('Feature coming soon!')">Forgot Password?</a>
                        <button type="submit" class="submit-btn" name="Login">
                            Sign In
                        </button>
                        <div class="switch-form">
                            Don't have an account? <span id="switchToSignup">Sign up here</span>
                        </div>
                    </form>
                </div>

                <!-- Signup Form -->
                <div class="form-panel hidden" id="signupPanel">
                    <form method="post">
                        <div class="input-group">
                            <label for="signup-email">Email Address</label>
                            <div class="input-wrapper">
                                <input type="email" name="email" id="signup-email" class="input" placeholder="Enter your email" required>
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>
                        <div class="input-group">
                            <label for="signup-password">Password</label>
                            <div class="input-wrapper">
                                <input type="password" name="password" id="signup-password" class="input" placeholder="Create a password" required>
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                        <div class="input-group">
                            <label for="confirm-password">Confirm Password</label>
                            <div class="input-wrapper">
                                <input type="password" name="confirm_password" id="confirm-password" class="input" placeholder="Confirm your password" required>
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                        <button type="submit" class="submit-btn" name="Signup">
                            Create Account
                        </button>
                        <div class="switch-form">
                            Already have an account? <span id="switchToLogin">Sign in here</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const loginTab = document.getElementById('loginTab');
        const signupTab = document.getElementById('signupTab');
        const tabIndicator = document.getElementById('tabIndicator');
        const loginPanel = document.getElementById('loginPanel');
        const signupPanel = document.getElementById('signupPanel');
        const headerTitle = document.getElementById('headerTitle');
        const headerSubtitle = document.getElementById('headerSubtitle');
        const switchToSignup = document.getElementById('switchToSignup');
        const switchToLogin = document.getElementById('switchToLogin');

        function showLogin() {
            loginTab.classList.add('active');
            signupTab.classList.remove('active');
            tabIndicator.classList.remove('signup');
            loginPanel.classList.remove('hidden');
            signupPanel.classList.add('hidden');
            headerTitle.textContent = 'Welcome Back';
            headerSubtitle.textContent = 'Sign in to your account';
        }

        function showSignup() {
            signupTab.classList.add('active');
            loginTab.classList.remove('active');
            tabIndicator.classList.add('signup');
            signupPanel.classList.remove('hidden');
            loginPanel.classList.add('hidden');
            headerTitle.textContent = 'Create Account';
            headerSubtitle.textContent = 'Join us today';
        }

        loginTab.addEventListener('click', showLogin);
        signupTab.addEventListener('click', showSignup);
        switchToSignup.addEventListener('click', showSignup);
        switchToLogin.addEventListener('click', showLogin);

        // Add input focus effects
        document.querySelectorAll('.input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.parentElement.style.transform = 'translateY(0)';
            });
        });

        // Form validation
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('.submit-btn');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = submitBtn.name === 'Login' ? 'Sign In' : 'Create Account';
                }, 1000);
            });
        });
    </script>
</body>
</html>