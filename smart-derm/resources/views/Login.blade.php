<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDerm | Analitik Penyakit Kulit Berbasis AI</title>
    
   <link rel="icon" type="image/png" href="assets/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     

</head>
<body>
    <div class="background"></div>
    
    <div class="container">
        <div class="form-container">
            <div class="form-toggle">
                <button id="login-toggle" class="toggle-btn active">Login</button>
                <button id="register-toggle" class="toggle-btn">Register</button>
            </div>
            
            <div class="form-content">
                <!-- Login Form -->
                <form id="login-form" class="form active-form">
                    <div class="form-group">
                        <i class="fas fa-envelope icon"></i>
                        <input type="email" id="login-email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-lock icon"></i>
                        <input type="password" id="login-password" placeholder="Password" required>
                        <i class="fas fa-eye-slash toggle-password" onclick="togglePassword('login-password', this)"></i>
                    </div>
                    <button type="submit" class="submit-btn">Sign In</button>
                    <div class="form-footer">
                        <a href="#" class="forgot-password">Forgot password?</a>
                    </div>
                </form>
                
                <!-- Register Form -->
                <form id="register-form" class="form">
                    <div class="form-group">
                        <i class="fas fa-user icon"></i>
                        <input type="text" id="register-name" placeholder="Full Name" required>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-envelope icon"></i>
                        <input type="email" id="register-email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-lock icon"></i>
                        <input type="password" id="register-password" placeholder="Password" required>
                        <i class="fas fa-eye-slash toggle-password" onclick="togglePassword('register-password', this)"></i>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-lock icon"></i>
                        <input type="password" id="register-confirm" placeholder="Confirm Password" required>
                    </div>
                    <button type="submit" class="submit-btn">Create Account</button>
                </form>
            </div>
            
            <div class="health-icons">
                <i class="fas fa-heartbeat"></i>
                <i class="fas fa-apple-alt"></i>
                <i class="fas fa-running"></i>
                <i class="fas fa-prescription-bottle-alt"></i>
            </div>
        </div>
    </div>
        @vite('resources/css/Login.css')
        @vite('resources/js/Login.js')

</body>
</html>