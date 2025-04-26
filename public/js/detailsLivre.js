document.addEventListener('DOMContentLoaded', function () {
    // Vérifier si un message de succès est présent dans un data attribute
    const successMessage = document.querySelector('[data-success-message]');
    if (successMessage) {
        const message = successMessage.getAttribute('data-success-message');
        Swal.fire({
            icon: 'success',
            title: 'Succès',
            text: message,
            confirmButtonText: 'OK',
            customClass: {
                popup: 'swal2-custom-popup',
                title: 'swal2-custom-title',
                content: 'swal2-custom-content',
                confirmButton: 'btn-primary'
            }
        });
    }
});