document.addEventListener('DOMContentLoaded', function() {
    // ===== MOBILE NAVIGATION =====
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');
    
    if (hamburger && navLinks) {
        hamburger.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            hamburger.classList.toggle('active');
            document.body.classList.toggle('no-scroll');
        });
    }

    // ===== STICKY NAVIGATION =====
    const navbar = document.querySelector('.navbar');
    
    if (navbar) {
        window.addEventListener('scroll', function() {
            navbar.classList.toggle('scrolled', window.scrollY > 100);
        });
    }

    // ===== SMOOTH SCROLLING =====
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            
            if (targetId === '#') return;
            
            e.preventDefault();
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                // Close mobile menu if open
                if (navLinks && navLinks.classList.contains('active')) {
                    navLinks.classList.remove('active');
                    hamburger.classList.remove('active');
                    document.body.classList.remove('no-scroll');
                }
                
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
                
                // Update URL without page jump
                if (history.pushState) {
                    history.pushState(null, null, targetId);
                }
            }
        });
    });

    // ===== TAB SYSTEM =====
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    if (tabBtns.length && tabContents.length) {
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                
                // Update active states
                tabBtns.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));
                
                this.classList.add('active');
                document.getElementById(tabId)?.classList.add('active');
            });
        });
        
        // Activate first tab by default
        tabBtns[0]?.click();
    }

    // ===== FORM HANDLING =====
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            submitBtn.disabled = true;
            
            try {
                // Simulate API call
                await new Promise(resolve => setTimeout(resolve, 1500));
                
                // Show success message
                const successMessages = {
                    'appointment-form': 'Appointment booked successfully! We will contact you shortly.',
                    'contact-form': 'Your message has been sent. Thank you!'
                };
                
                const message = successMessages[this.id] || 
                              (this.classList.contains('contact-form') ? successMessages['contact-form'] : 'Form submitted successfully!');
                
                showToast(message, 'success');
                
                // Reset form
                this.reset();
            } catch (error) {
                showToast('An error occurred. Please try again.', 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    });

    // ===== ANIMATIONS =====
    // Initialize animated elements
    const animatedElements = document.querySelectorAll(
        '.feature-card, .service-card, .contact-card, .visual-card, .about-item'
    );
    
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'all 0.6s ease';
    });

    // Scroll animation trigger
    const animateOnScroll = function() {
        animatedElements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (elementPosition < windowHeight - 100) {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }
        });
    };

    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll(); // Initial check

    // ===== STATS COUNTER =====
    const statValues = document.querySelectorAll('.stat-value');
    
    function animateStats() {
        statValues.forEach(stat => {
            const target = parseInt(stat.getAttribute('data-count'));
            const suffix = stat.nextElementSibling?.classList.contains('stat-suffix') ? 
                          stat.nextElementSibling.textContent : '';
            const duration = 2000;
            const start = 0;
            const increment = target / (duration / 16);
            
            let current = start;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    clearInterval(timer);
                    current = target;
                }
                stat.textContent = Math.floor(current).toLocaleString();
                if (suffix) stat.textContent += suffix;
            }, 16);
        });
    }

    // ===== INTERSECTION OBSERVERS =====
    document.addEventListener('DOMContentLoaded', function() {
    const aboutSection = document.querySelector('.about-section');
    const aboutCard = document.querySelector('.about-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                aboutCard.classList.add('animated');
                
                // Animate detail points with staggered delay
                const detailPoints = document.querySelectorAll('.detail-point');
                detailPoints.forEach((point, index) => {
                    setTimeout(() => {
                        point.style.opacity = '1';
                        point.style.transform = 'scale(1)';
                    }, index * 150 + 300); // Delay after card animation
                });
            }
        });
    }, { threshold: 0.1 });
    
    if (aboutSection) {
        observer.observe(aboutSection);
    }
});

    // ===== HELPER FUNCTIONS =====
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);
        }, 100);
    }
});

// ===== HERO IMAGE PARALLAX =====
const heroImage = document.querySelector('.hero-image img');
if (heroImage) {
    window.addEventListener('scroll', function() {
        const scrollPosition = window.scrollY;
        heroImage.style.transform = `translateY(${scrollPosition * 0.15}px)`;
    });
}
