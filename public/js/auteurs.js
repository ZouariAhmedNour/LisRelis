document.addEventListener('DOMContentLoaded', function () {
    // Ajouter un événement pour le formulaire de recherche
    const searchForm = document.querySelector('form');
    if (searchForm) {
        searchForm.addEventListener('submit', function (e) {
            const searchInput = searchForm.querySelector('input[name="search"]');
            if (searchInput.value.trim() === '') {
                e.preventDefault(); // Empêche la soumission si la recherche est vide
                Swal.fire({
                    icon: 'warning',
                    title: 'Attention',
                    text: 'Veuillez entrer un terme de recherche.',
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
    }

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
                    confirmButton: 'btn-primary',
                    cancelButton: 'btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        });
    });
});