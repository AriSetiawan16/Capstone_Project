document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('detectionForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah form submit default

            const fileInput = document.getElementById('image');
            const file = fileInput.files[0]; // Ambil file yang di-upload

            if (!file) {
                alert('Harap pilih gambar terlebih dahulu.');
                return;
            }

            const formData = new FormData();
            formData.append('image', file); 

            fetch('/predict', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Full Response:', data); 
                const resultDiv = document.getElementById('result');
                if (resultDiv) {
                    resultDiv.style.display = 'block';
                    const prediction = data.predicted_class;
                    const confidence = (data.confidence * 100).toFixed(2); // jadi persen

                    // Update prediction text dan recommendation
                    document.getElementById('predictionText').innerHTML = `
                        <strong>Prediction:</strong> ${prediction}<br>
                        <strong>Confidence:</strong> ${confidence}%<br>
                        <strong>Recommendation:</strong> ${data.recommendation}
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const resultDiv = document.getElementById('result');
                if (resultDiv) {
                    resultDiv.style.display = 'block';
                    document.getElementById('predictionText').innerText = 'Error: Unable to get prediction.';
                }
            });
        });
    } else {
        console.error("Form with ID 'detectionForm' not found!");
    }
});
