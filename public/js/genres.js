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
                    confirmButton: 'btn-primary',
                    cancelButton: 'btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Effectuer la suppression via une requête fetch
                    fetch(deleteUrl, { method: 'GET' })
                        .then(response => {
                            if (response.ok) {
                                // Afficher une notification de succès
                                Swal.fire({
                                    title: 'Supprimé !',
                                    text: 'Le genre a été supprimé avec succès.',
                                    icon: 'success',
                                    customClass: {
                                        popup: 'swal2-custom-popup',
                                        title: 'swal2-custom-title',
                                        content: 'swal2-custom-content',
                                        confirmButton: 'btn-primary'
                                    }
                                }).then(() => {
                                    // Recharger la page pour mettre à jour la liste
                                    window.location.reload();
                                });
                            } else {
                                // Afficher une erreur si la suppression échoue
                                Swal.fire({
                                    title: 'Erreur',
                                    text: 'Une erreur s\'est produite lors de la suppression.',
                                    icon: 'error',
                                    customClass: {
                                        popup: 'swal2-custom-popup',
                                        title: 'swal2-custom-title',
                                        content: 'swal2-custom-content',
                                        confirmButton: 'btn-primary'
                                    }
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                            Swal.fire({
                                title: 'Erreur',
                                text: 'Une erreur s\'est produite lors de la suppression.',
                                icon: 'error',
                                customClass: {
                                    popup: 'swal2-custom-popup',
                                    title: 'swal2-custom-title',
                                    content: 'swal2-custom-content',
                                    confirmButton: 'btn-primary'
                                }
                            });
                        });
                }
            });
        });
    });
});