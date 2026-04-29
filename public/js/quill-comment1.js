 const quill = new Quill('#editor', {
    modules: {
        toolbar: '#toolbar'
    },
    placeholder: 'Écrivez votre commentaire ici...',
    theme: 'snow',
});

// Ajouter les tooltips en français
document.querySelector('.ql-bold').setAttribute('title', 'Gras');
document.querySelector('.ql-italic').setAttribute('title', 'Italique');
document.querySelector('.ql-underline').setAttribute('title', 'Souligné');
document.querySelector('.ql-list[value="ordered"]').setAttribute('title', 'Liste numérotée');
document.querySelector('.ql-list[value="bullet"]').setAttribute('title', 'Liste à puces');

// Gestion de la soumission du formulaire
document.getElementById('form').addEventListener('submit', (e) => {
    const html = quill.root.innerHTML;
    document.getElementById('content').value = html;
    
    // Vérifier que ce n'est pas vide
    const text = quill.getText().trim();
    if (text.length === 0) {
        e.preventDefault();//empêche l'envoi par défaut
        alert('Veuillez écrire un commentaire avant d\'envoyer',);
    }

     // Étoiles
    const stars = document.querySelectorAll('.star');
    const selectedRating = document.getElementById('selected-rating');
    let currentRating = 0;

    stars.forEach((star, index) => {
        star.addEventListener('mouseenter', () => {
            highlightStars(index + 1);
        });
    });

    document.querySelector('.rating-stars').addEventListener('mouseleave', () => {
        highlightStars(currentRating);
    });

    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            currentRating = index + 1;
            selectedRating.textContent = currentRating;
            document.getElementById('rating').value = currentRating;
            highlightStars(currentRating);
            console.log('Note sélectionnée:', currentRating);
        });
    });

    function highlightStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('bi-star');
                star.classList.add('bi-star-fill');
            } else {
                star.classList.remove('bi-star-fill');
                star.classList.add('bi-star');
            }
        });
    }
});