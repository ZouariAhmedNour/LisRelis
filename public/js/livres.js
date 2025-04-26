document.addEventListener('DOMContentLoaded', function () {
    // Ajouter un événement pour les boutons de suppression
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const deleteUrl = this.getAttribute('href');
            
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: 'Vous ne pourrez pas revenir en arrière !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler',
                customClass: {
                    popup: 'swal2-custom-popup',
                    title: 'swal2-custom-title',
                    content: 'swal2-custom-content',
                    confirmButton: 'btn-primary', // Suppression de l'espace
                    cancelButton: 'btn-secondary' // Suppression de l'espace
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        });
    });
});