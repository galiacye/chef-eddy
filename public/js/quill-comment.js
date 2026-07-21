const quill = new Quill('#editor', {
    modules: { toolbar: '#toolbar' },
    placeholder: 'Écrivez votre commentaire ici...',
    theme: 'snow',
});

document.querySelector('.ql-bold').setAttribute('title', 'Gras');
document.querySelector('.ql-italic').setAttribute('title', 'Italique');
document.querySelector('.ql-underline').setAttribute('title', 'Souligné');
document.querySelector('.ql-list[value="ordered"]').setAttribute('title', 'Liste numérotée');
document.querySelector('.ql-list[value="bullet"]').setAttribute('title', 'Liste à puces');

document.getElementById('form').addEventListener('submit', (e) => {
    const html = quill.root.innerHTML;
    document.getElementById('content').value = html;
    const text = quill.getText().trim();
    if (text.length === 0) {
        e.preventDefault();
        alert('Veuillez écrire un commentaire avant d\'envoyer');
    }
});

// Étoiles: externes au submit
const stars = document.querySelectorAll('.star');
const selectedRating = document.getElementById('selected-rating');
let currentRating = 0;

stars.forEach((star, index) => {
    star.addEventListener('mouseenter', () => highlightStars(index + 1));
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
    });
});

function highlightStars(rating) {
    stars.forEach((star, index) => {
        star.classList.toggle('bi-star-fill', index < rating);
        star.classList.toggle('bi-star', index >= rating);
    });
}