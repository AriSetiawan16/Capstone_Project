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

    // Form submission handlers for loading state
    loginForm.addEventListener('submit', function(e) {
        const btn = this.querySelector('.submit-btn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Authenticating...';
        btn.disabled = true;
    });

    registerForm.addEventListener('submit', function(e) {
        const password = document.getElementById('register-password').value;
        const confirm = document.getElementById('register-confirm').value;

        if (password !== confirm) {
            e.preventDefault();
            alert('Passwords do not match!');
            return false;
        }

        const btn = this.querySelector('.submit-btn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';
        btn.disabled = true;
    });

    // Auto-hide success message after 5 seconds
    const successMessage = document.querySelector('.success-message');
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 5000);
    }
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
