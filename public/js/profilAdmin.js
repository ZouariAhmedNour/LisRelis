document.addEventListener('DOMContentLoaded', function() {
    const alertButtons = document.querySelectorAll('.send-alert');
    
    alertButtons.forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            Swal.fire({
                icon: 'success',
                title: 'Alerte envoyée',
                text: 'Une notification par email a été envoyée.',
                confirmButtonColor: '#A65482'
            });
        });
    });
});