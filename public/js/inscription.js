document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded, script is running.');

    const form = document.getElementById('inscriptionForm');
    if (!form) {
        console.error('Form with ID "inscriptionForm" not found.');
        return;
    }

    form.addEventListener('submit', function(event) {
        console.log('Form submission triggered.');

        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('mot_de_passe_confirm').value;
        
        if (password !== confirmPassword) {
            console.log('Passwords do not match.');
            event.preventDefault();

            // Remove any existing alerts
            const existingAlert = form.parentNode.querySelector('.alert-danger');
            if (existingAlert) {
                existingAlert.remove();
            }

            // Create and display new alert
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger text-center';
            alertDiv.textContent = 'Les mots de passe ne correspondent pas.';
            form.parentNode.insertBefore(alertDiv, form);
            setTimeout(() => alertDiv.remove(), 3000);
        } else {
            console.log('Passwords match, proceeding with submission.');
        }
    });

    const inscrireBtn = document.getElementById('inscrireBtn');
    const connecterBtn = document.getElementById('connecterBtn');

    if (inscrireBtn) {
        inscrireBtn.addEventListener('mouseover', function() {
            this.style.color = '#FFD1DC';
        });
        inscrireBtn.addEventListener('mouseout', function() {
            this.style.color = 'white';
        });
    } else {
        console.error('Button with ID "inscrireBtn" not found.');
    }

    if (connecterBtn) {
        connecterBtn.addEventListener('mouseover', function() {
            this.style.color = '#FFD1DC';
        });
        connecterBtn.addEventListener('mouseout', function() {
            this.style.color = '#6b2077';
        });
    } else {
        console.error('Button with ID "connecterBtn" not found.');
    }
});