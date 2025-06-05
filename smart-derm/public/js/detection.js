document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const detectionForm = document.getElementById('detectionForm');
    const imageInput = document.getElementById('image');
    const previewImg = document.getElementById('previewImg');
    const imagePreview = document.getElementById('imagePreview');
    const removeImageBtn = document.getElementById('removeImage');
    const submitBtn = document.getElementById('submitBtn');
    const loadingContainer = document.getElementById('loadingContainer');
    const resultContainer = document.getElementById('resultContainer');
    const resultPreview = document.getElementById('resultPreview');
    const predictionText = document.getElementById('predictionText');
    const progressBar = document.getElementById('progressBar');
    const progressPercent = document.getElementById('progressPercent');
    const confidenceFill = document.getElementById('confidenceFill');
    const confidencePercent = document.getElementById('confidencePercent');
    const recommendationText = document.getElementById('recommendationText');
    const closeResultBtn = document.getElementById('closeResult');
    const newAnalysisBtn = document.getElementById('newAnalysisBtn');
    const saveResultBtn = document.getElementById('saveResultBtn');

    // Image Upload Preview
    if (imageInput && previewImg) {
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // Remove Image
    if (removeImageBtn) {
        removeImageBtn.addEventListener('click', function() {
            imageInput.value = '';
            previewImg.src = '';
            imagePreview.style.display = 'none';
        });
    }

    // Form Submission
    if (detectionForm) {
        detectionForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!imageInput.files || !imageInput.files[0]) {
                alert('Silakan upload gambar terlebih dahulu');
                return;
            }
            
            // Show loading animation
            loadingContainer.style.display = 'flex';
            submitBtn.disabled = true;
            
            // Simulate upload progress (remove this in production)
            let progress = 0;
            const progressInterval = setInterval(() => {
                progress += Math.random() * 10;
                if (progress > 90) progress = 90; // Leave 10% for actual processing
                progressBar.style.width = progress + '%';
                progressPercent.textContent = Math.floor(progress);
            }, 200);

            // Prepare form data
            const formData = new FormData();
            formData.append('image', imageInput.files[0]);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            // Make API request
            fetch('/predict', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                clearInterval(progressInterval);
                progressBar.style.width = '100%';
                progressPercent.textContent = '100';
                
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('API Response:', data);
                
                // Hide loading and show results
                loadingContainer.style.display = 'none';
                resultContainer.style.display = 'flex';
                
                // Display the uploaded image
                const reader = new FileReader();
                reader.onload = function(e) {
                    resultPreview.src = e.target.result;
                }
                reader.readAsDataURL(imageInput.files[0]);
                
                // Process API response
                const prediction = data.predicted_class || 'Tidak dapat menentukan';
                const confidence = data.confidence ? (data.confidence * 100).toFixed(2) : 0;
                
                // Animate confidence meter
                let currentConfidence = 0;
                const confidenceInterval = setInterval(() => {
                    currentConfidence += 2;
                    if (currentConfidence > confidence) {
                        currentConfidence = confidence;
                        clearInterval(confidenceInterval);
                    }
                    confidenceFill.style.width = currentConfidence + '%';
                    confidencePercent.textContent = currentConfidence + '%';
                }, 20);
                
                // Update prediction text
                predictionText.textContent = prediction;
                
                // Update recommendations
                let recommendations = data.recommendation || 'Tidak ada rekomendasi tersedia';
                
                // Format recommendations if they come as an array
                if (Array.isArray(recommendations)) {
                    recommendations = recommendations.map(rec => `<li>${rec}</li>`).join('');
                    recommendations = `<ul>${recommendations}</ul>`;
                }
                
                recommendationText.innerHTML = recommendations;
            })
            .catch(error => {
                console.error('Error:', error);
                loadingContainer.style.display = 'none';
                
                // Show error in results container
                resultContainer.style.display = 'flex';
                predictionText.textContent = 'Terjadi kesalahan dalam analisis';
                confidenceFill.style.width = '0%';
                confidencePercent.textContent = '0%';
                recommendationText.innerHTML = 'Silakan coba lagi atau upload gambar yang lebih jelas.';
            })
            .finally(() => {
                submitBtn.disabled = false;
            });
        });
    }

    // Close results
    if (closeResultBtn) {
        closeResultBtn.addEventListener('click', function() {
            resultContainer.style.display = 'none';
        });
    }

    // New analysis
    if (newAnalysisBtn) {
        newAnalysisBtn.addEventListener('click', function() {
            resultContainer.style.display = 'none';
            // Optionally reset the form here if needed
        });
    }

});