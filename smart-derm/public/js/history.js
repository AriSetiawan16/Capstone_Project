document.addEventListener('DOMContentLoaded', function() {
    // Add click effect to cards
    const cards = document.querySelectorAll('.history-card');
    
    cards.forEach(card => {
        card.addEventListener('click', function() {
            // You can add functionality here when a card is clicked
            // For example, show a modal with more details
            console.log('Card clicked:', this.querySelector('.patient-name').textContent);
        });
        
        // Add keyboard accessibility
        card.setAttribute('tabindex', '0');
        card.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.click();
            }
        });
    });
    
    // Animate confidence values
    const confidenceValues = document.querySelectorAll('.confidence-value');
    
    confidenceValues.forEach(value => {
        const confidence = parseFloat(value.textContent);
        
        // Add animation class based on confidence level
        if (confidence > 90) {
            value.classList.add('high-confidence');
        } else if (confidence > 70) {
            value.classList.add('medium-confidence');
        } else {
            value.classList.add('low-confidence');
        }
    });
    
    // Initialize tooltips if using any
    $('[data-toggle="tooltip"]').tooltip();
    
    // You can add more interactive features here
    console.log('History page initialized');
});