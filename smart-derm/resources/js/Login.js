document.addEventListener('DOMContentLoaded', function() {
    // Toggle between login and register forms
    const loginToggle = document.getElementById('login-toggle');
    const registerToggle = document.getElementById('register-toggle');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const formContainer = document.querySelector('.form-container');
    
    loginToggle.addEventListener('click', function() {
        if (!this.classList.contains('active')) {
            this.classList.add('active');
            registerToggle.classList.remove('active');
            
            loginForm.classList.add('active-form');
            registerForm.classList.remove('active-form');
            
            // Animation effect
            formContainer.style.animation = 'none';
            void formContainer.offsetWidth; // Trigger reflow
            formContainer.style.animation = 'pulse 0.5s ease';
        }
    });
    
    registerToggle.addEventListener('click', function() {
        if (!this.classList.contains('active')) {
            this.classList.add('active');
            loginToggle.classList.remove('active');
            
            registerForm.classList.add('active-form');
            loginForm.classList.remove('active-form');
            
            // Animation effect
            formContainer.style.animation = 'none';
            void formContainer.offsetWidth; // Trigger reflow
            formContainer.style.animation = 'pulse 0.5s ease';
        }
    });
    
    // Form submission
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('login-email').value;
        const password = document.getElementById('login-password').value;
        
        // Here you would typically validate and send to server
        console.log('Login attempt with:', email, password);
        
        // Simulate loading
        const btn = this.querySelector('.submit-btn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Authenticating';
        btn.disabled = true;
        
        setTimeout(() => {
            btn.innerHTML = 'Sign In';
            btn.disabled = false;
            // Show success/error message here
        }, 2000);
    });
    
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const name = document.getElementById('register-name').value;
        const email = document.getElementById('register-email').value;
        const password = document.getElementById('register-password').value;
        const confirm = document.getElementById('register-confirm').value;
        
        if (password !== confirm) {
            alert('Passwords do not match!');
            return;
        }
        
        // Here you would typically validate and send to server
        console.log('Registration attempt:', name, email, password);
        
        // Simulate loading
        const btn = this.querySelector('.submit-btn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account';
        btn.disabled = true;
        
        setTimeout(() => {
            btn.innerHTML = 'Create Account';
            btn.disabled = false;
            // Show success/error message here
            // Then switch to login form
            loginToggle.click();
        }, 2000);
    });
});

// Toggle password visibility
function togglePassword(inputId, icon) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
}