const quill = new Quill('#editor', {
    modules: { toolbar: '#toolbar' },
    placeholder: 'Écrivez votre recette ici...',
    theme: 'snow',
});

// Tooltips FR
document.querySelector('.ql-bold').setAttribute('title', 'Gras');
document.querySelector('.ql-italic').setAttribute('title', 'Italique');
document.querySelector('.ql-underline').setAttribute('title', 'Souligné');
document.querySelector('.ql-list[value="ordered"]').setAttribute('title', 'Liste numérotée');
document.querySelector('.ql-list[value="bullet"]').setAttribute('title', 'Liste à puces');

// Récupérer le contenu existant si retour de validation
const existingContent = document.getElementById('contenu').value;
if (existingContent) {
    quill.root.innerHTML = existingContent;
}

// Injecter le HTML Quill dans le champ caché au submit
document.getElementById('form').addEventListener('submit', (e) => {
    const text = quill.getText().trim();
    if (text.length === 0) {
        e.preventDefault();
        alert('Veuillez écrire votre recette avant d\'envoyer');
        return;
    }
    document.getElementById('contenu').value = quill.root.innerHTML;
});