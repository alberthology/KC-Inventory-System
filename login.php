<?php
session_start();


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KC'Closet Inventory System</title>
    <link rel="icon" type="image/x-icon" href="assets/images/closet.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<!-- Add Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">


    <style type="text/css">
                * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }

   body {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #392614;
    position: relative;
    /* Remove overflow: hidden; to allow scrolling */
}


        .animated-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .gradient-sphere {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.5;
            animation: moveSphere 20s infinite ease-in-out;
        }

        .sphere-1 {
            width: 600px;
            height: 600px;
            background: linear-gradient(45deg, #dab659, #dab659);
            top: -300px;
            left: -300px;
            animation-delay: -5s;
        }

        .sphere-2 {
            width: 500px;
            height: 500px;
            background: linear-gradient(45deg, brown, yellow);
            bottom: -250px;
            right: -250px;
            animation-delay: -2s;
        }

        .sphere-3 {
            width: 400px;
            height: 400px;
            background: linear-gradient(45deg, white, gray);
            top: 50%;
            left: 30%;
            animation-delay: -8s;
        }

        @keyframes moveSphere {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg) scale(1);
            }
            25% {
                transform: translate(100px, 50px) rotate(90deg) scale(1.1);
            }
            50% {
                transform: translate(50px, 100px) rotate(180deg) scale(1);
            }
            75% {
                transform: translate(-50px, 50px) rotate(270deg) scale(0.9);
            }
        }

        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            animation: floatParticle 8s infinite linear;
        }

        @keyframes floatParticle {
            0% {
                transform: translateY(100vh) scale(0);
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) scale(1);
                opacity: 0;
            }
        }

.login-container {
    position: relative;
    z-index: 2;
    width: auto;      
    max-width: 400px;         
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 24px;
    padding: 3rem;
    color: white;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    overflow: hidden;
    transform: translateY(20px);
    opacity: 0;
    animation: slideIn 0.6s ease-out forwards;
}


        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 200%;
            height: 100%;
            background: linear-gradient(
                to right,
                transparent,
                rgba(255, 255, 255, 0.1),
                transparent
            );
            transform: skewX(-15deg);
            transition: 0.5s;
        }

        .login-container:hover::before {
            left: 100%;
        }

        @keyframes slideIn {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(45deg, #fff, #ccc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1rem;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            font-size: 1rem;
            color: white;
            transition: all 0.3s ease;
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .form-input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.05);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.4);
            transition: color 0.3s ease;
        }

        .form-input:focus + .input-icon {
            color: white;
        }

        .submit-button {
            width: 100%;
            padding: 1rem;
            background: white;
            color: black;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .submit-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                to right,
                transparent,
                rgba(255, 255, 255, 0.8),
                transparent
            );
            transition: 0.5s;
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .submit-button:hover::before {
            left: 100%;
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin: 2rem 0;
        }

        .social-button {
            width: 50px;
            height: 50px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.05);
            color: white;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .social-button::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(100%);
            transition: 0.3s ease;
        }

        .social-button:hover {
            transform: translateY(-3px);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .social-button:hover::before {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 2rem 0;
            color: rgba(255, 255, 255, 0.4);
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .divider span {
            padding: 0 1rem;
            font-size: 0.9rem;
        }

        .additional-options {
            text-align: center;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .additional-options a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s ease;
        }

        .additional-options a:hover {
            opacity: 0.8;
        }

        .error-message {
            color: #ff4477;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: none;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes ripple {
            to {
                width: 300px;
                height: 300px;
                opacity: 0;
            }
        }

        @media (max-width: 1280px) {
            .login-container {
                margin: 1rem;
                padding: 1rem;
                max-width: 300px;
                max-height: 1000px;
            }
            img{
                width: 50%;
            }

            .login-header h1 {
                font-size: 2rem;
            }
        }

    </style>
</head>
<body>

    <div class="animated-background">
        <div class="gradient-sphere sphere-1"></div>
        <div class="gradient-sphere sphere-2"></div>
        <div class="gradient-sphere sphere-3"></div>
        <div class="particles" id="particles"></div>
    </div>

    <div class="login-container">
        <div class="login-header">
            <!-- <h1>Welcome</h1> -->
            <img src="assets/images/closet.png"  alt="..." class="img-fluid img-circle">
        </div>

<!-- <form id="loginForm" onsubmit="return handleLogin(event)" method="POST" action="login.php"> -->
    <form id="loginForm" method="POST" action="login.php">
        <div class="form-group">
            <input 
                type="email" 
                class="form-input" 
                id="email" 
                name="email"
                placeholder="Email address"
                required
            >
            <i class="input-icon fas fa-envelope"></i>
            <span class="error-message" id="emailError"></span>
        </div>

        <div class="form-group">
            <input 
                type="password" 
                class="form-input" 
                id="password" 
                name="password"
                placeholder="Password"
                required
            >
            <i class="input-icon fas fa-lock"></i>
            <span class="error-message" id="passwordError"></span>
        </div>

        <input type="submit" value="Log In" name="login" class="submit-button">
    </form>

    <?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "inventory_db";

    // Database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize and retrieve user inputs
    $email = $conn->real_escape_string($_POST['email']);
    $pass = $conn->real_escape_string($_POST['password']);

    // Query to check user credentials
    $sqli = "SELECT * FROM user_table WHERE email=?";
    $stmt = $conn->prepare($sqli);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $results = $stmt->get_result();

    if ($results->num_rows > 0) {
        $user = $results->fetch_assoc();

        // Verify the password
        if (password_verify($pass, $user['password'])) {
            // Set session variables
            $_SESSION["Name"] = $user['full_name'];
            $_SESSION["email"] = $user['email'];
            $_SESSION["role"] = $user['role'];
            $_SESSION["username"] = $user['username'];
            $_SESSION["id"] = $user['user_id'];
            $_SESSION["created_at"] = $user['created_at'];

            // Toastr Success Message and Redirect
            echo "
            <script type='text/javascript'>
                toastr.options = {
                    'closeButton': true,              
                    'progressBar': true,              
                    'positionClass': 'toast-top-right', 
                    'timeOut': '5000',                 
                    'extendedTimeOut': '1000',         
                    'showEasing': 'swing',
                    'hideEasing': 'linear',
                    'showMethod': 'fadeIn',
                    'hideMethod': 'fadeOut'
                };
                toastr.success('Logged in successfully!', 'Success');
                setTimeout(function() {
                    window.location.replace('index.php'); // Redirect to dashboard
                }, 2000);
            </script>";
            exit;
        } else {
            $error_message = "Invalid email or password.";
        }
    } else {
        $error_message = "Invalid email or password.";
    }

    $conn->close();
}

    // Display error message if login failed
    if (!empty($error_message)) {
        echo "
        <script type='text/javascript'>
            Swal.fire({
                title: 'Login Failed',
                text: '$error_message',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
    }
    ?>

        <div class="additional-options">
            <hr>
            <!-- <a href="#" onclick="handleForgotPassword()">Forgot password?</a> -->
            <p style="margin-top: 1rem">
                Don't have an account or forgot password? 
            </p>
            <p style="margin-top: 1rem">
                Please refer to the  
                <a href="#" onclick="handleSignUp()">Admin</a>
            </p>
        </div>
    </div>
</body>
<script type="text/javascript">
            // Create floating particles
        function createParticles() {
            const container = document.getElementById('particles');
            const particleCount = 50;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 8 + 's';
                particle.style.opacity = Math.random() * 0.5 + 0.2;
                
                container.appendChild(particle);
            }
        }

        // Handle form submission
/*function handleLogin(event) {
    event.preventDefault(); // Prevent default form submission

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Validate inputs
    if (!isValidEmail(email)) {
        showError('emailError', 'Invalid email format');
        return;
    }
    if (password.trim() === '') {
        showError('passwordError', 'Password is required');
        return;
    }

    // Perform AJAX request
    fetch('login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect on success
            window.location.href = "index.php";
        } else {
            // Show error message
            Swal.fire({
                title: 'Login Failed',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => console.error('Error:', error));
}*/

// Helper functions
function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function showError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    errorElement.textContent = message;
    errorElement.style.display = 'block';
}


        // Handle social login buttons
        function handleSocialLogin(provider) {
            alert(`${provider} login would be implemented here`);
        }

        // Handle forgot password
        function handleForgotPassword() {
            alert('Password reset would be implemented here');
        }

        // Handle sign up
/*        function handleSignUp() {
            alert('Sign up would be implemented here');
        }*/

        function handleSignUp() {
            Swal.fire({
                title: "<h5>Contact Admin Via:</h5>",
                // text: "Contact Admin Through..",
                  html: `
                  <a href='https://www.facebook.com/profile.php?id=100090597152087' class='btn btn-dark' target="_blank"><i class="fab fa-facebook" ></i></a>
                  <a href="https://mail.google.com/mail/?view=cm&fs=1&to=dole10.markseneres@gmail.com" class="btn btn-dark" target="_blank"><i class="fab fa-google"></i></a>
  `,
              showClass: {
                popup: `
                  animate__animated
                  animate__fadeInUp
                  animate__faster
                `
              },
              hideClass: {
                popup: `
                  animate__animated
                  animate__fadeOutDown
                  animate__faster
                `
              },
              confirmButtonColor: "#737373"
            });
        }

        // Add mouse move effect for gradient spheres
        document.addEventListener('mousemove', (e) => {
            const spheres = document.querySelectorAll('.gradient-sphere');
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;
            
            spheres.forEach((sphere, index) => {
                const speed = (index + 1) * 20;
                const xOffset = (0.5 - x) * speed;
                const yOffset = (0.5 - y) * speed;
                
                sphere.style.transform = `translate(${xOffset}px, ${yOffset}px) scale(${1 + (index * 0.1)})`;
            });
        });

        // Add smooth reveal animation for form elements
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize particles
            createParticles();

            // Animate form elements
            const elements = document.querySelectorAll('.form-group, .submit-button, .divider, .social-login, .additional-options');
            elements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    element.style.transition = 'all 0.6s ease-out';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, 100 * index);
            });

            // Add input focus effects
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', () => {
                    input.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', () => {
                    if (!input.value) {
                        input.parentElement.classList.remove('focused');
                    }
                });
            });
        });

        // Add ripple effect to buttons
        document.querySelectorAll('.submit-button, .social-button').forEach(button => {
            button.addEventListener('click', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const ripple = document.createElement('div');
                ripple.style.position = 'absolute';
                ripple.style.width = '0';
                ripple.style.height = '0';
                ripple.style.background = 'rgba(255, 255, 255, 0.4)';
                ripple.style.borderRadius = '50%';
                ripple.style.transform = 'translate(-50%, -50%)';
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                ripple.style.animation = 'ripple 0.6s ease-out';

                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);

                setTimeout(() => ripple.remove(), 600);
            });
        });
</script>
</html>