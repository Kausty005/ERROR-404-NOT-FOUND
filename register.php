<?php
session_start();
// Database connection
$host = "localhost";
$user = "root";
$pass = ""; // Set your DB password
$db = "User";
$conn = new mysqli($host, $user, $pass, $db);

// Error/success messages
$err = "";
$success = "";

// SIGN UP
if (isset($_POST['signup'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ($password !== $cpassword) {
        $err = "Passwords do not match!";
    } elseif (strlen($password) < 6) {
        $err = "Password must be at least 6 characters.";
    } else {
        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM signin WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $err = "Email already registered!";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO signin (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hash);
            if ($stmt->execute()) {
                $success = "Registration successful! Please sign in.";
            } else {
                $err = "Error occurred. Try again!";
            }
        }
        $stmt->close();
    }
}

// SIGN IN
if (isset($_POST['signin'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT id, name, password FROM signin WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $name, $hash);
        $stmt->fetch();
        if (password_verify($password, $hash)) {
            
            $_SESSION['email'] = $email;
            header("Location: index.php"); // Go to front page after login
            exit();
        } else {
            $err = "Incorrect password!";
        }
    } else {
        $err = "No account found with this email!";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In / Sign Up - Instant Bed Reserver</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: linear-gradient(135deg, #3333cf 0%, #053bc2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #042d67;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-container {
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 10px 40px rgba(6,60,142,0.15);
            max-width: 410px;
            width: 100%;
            padding: 40px 32px 32px 32px;
            animation: fadeInUp 0.7s;
        }
        .auth-title {
            text-align: center;
            font-size: 29px;
            font-weight: 700;
            color: #3333cf;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        .toggle-link {
            text-align: center;
            margin-bottom: 22px;
            color: #0a3d89;
            cursor: pointer;
            font-size: 15px;
            transition: color 0.2s;
        }
        .toggle-link:hover { color: #14be9a; }
        .auth-form {
            display: none;
            flex-direction: column;
            gap: 18px;
        }
        .auth-form.active {
            display: flex;
        }
        .auth-form input {
            padding: 13px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: border 0.3s;
            background: #f8fafc;
        }
        .auth-form input:focus {
            border-color: #3333cf;
        }
        .auth-btn {
            background: linear-gradient(135deg, #14be9a, #0f9b7a);
            color: white;
            padding: 13px 0;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            font-size: 17px;
            cursor: pointer;
            transition: background 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 15px rgba(65, 65, 70, 0.1);
        }
        .auth-btn:hover {
            background: linear-gradient(135deg, #043476, #3b3bed);
            box-shadow: 0 6px 20px rgba(65, 65, 70, 0.2);
        }
        .auth-message {
            text-align: center;
            color: #d90429;
            margin-bottom: 10px;
            font-size: 15px;
        }
        .auth-success {
            color: #14be9a;
        }
        .auth-container .logo {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 38px;
            margin-bottom: 18px;
        }
        .auth-container .logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #14be9a, #0f9b7a);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            font-weight: bold;
            margin-right: 12px;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px);}
            to { opacity: 1; transform: translateY(0);}
        }
        @media (max-width: 500px) {
            .auth-container { padding: 25px 7vw; }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="logo">
            <span class="logo-icon">🏥</span>
            <span style="font-weight:700;color:#4e4ef0;font-size:22px;">INSTANT BED RESERVER</span>
        </div>
        <div class="auth-title">Account Access</div>
        <?php if ($err): ?>
            <div class="auth-message"><?= htmlspecialchars($err) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="auth-message auth-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <div class="toggle-link" id="show-signin">Already have an account? <b>Sign In</b></div>
        <form class="auth-form" id="signin-form" method="post" autocomplete="off" style="display: none;">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button class="auth-btn" type="submit" name="signin">Sign In</button>
        </form>
        <div class="toggle-link" id="show-signup">Don't have an account? <b>Sign Up</b></div>
        <form class="auth-form" id="signup-form" method="post" autocomplete="off">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password (min 6 chars)" required minlength="6">
            <input type="password" name="cpassword" placeholder="Confirm Password" required minlength="6">
            <button class="auth-btn" type="submit" name="signup">Sign Up</button>
        </form>
    </div>
    <script>
        // Toggle between forms
        const signinForm = document.getElementById('signin-form');
        const signupForm = document.getElementById('signup-form');
        const showSignin = document.getElementById('show-signin');
        const showSignup = document.getElementById('show-signup');

        function showForm(form) {
            signinForm.style.display = form === 'signin' ? 'flex' : 'none';
            signupForm.style.display = form === 'signup' ? 'flex' : 'none';
        }
        // Default to signup if just registered, else signin
        <?php if($success): ?>
            showForm('signin');
        <?php else: ?>
            showForm('signup');
        <?php endif; ?>
        showSignin.onclick = () => showForm('signin');
        showSignup.onclick = () => showForm('signup');
    </script>
</body>
</html>