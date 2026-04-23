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
    document.getElementById('contenu').value = html;
    
    // Vérifier que ce n'est pas vide
    const text = quill.getText().trim();
    if (text.length === 0) {
        e.preventDefault();//empêche l'envoi par défaut
        alert('Veuillez écrire un commentaire avant d\'envoyer',);
    }
});