const quill = new Quill('#editor-reply', {
    modules: {toolbar: ' #toolbar-reply'},
    placeholder: 'Ecrivez votre réponse ici...',
    theme: 'snow',
    });

document.querySelector('.ql-bold').setAttribute('title','Gras');
document.querySelector('.ql-italic').setAttribute('title', 'Italique');
document.querySelector('.ql-underline').setAttribute('title', 'Souligner');

document.getElementById('form-reply').addEventListener('submit', (event) =>{
    //event ou e par convention représente l'évènement qui s'est produit, ici le submit.
    //par défaur submit envoie et recharge la page
    const text = quill.getText().trim();
    if(text.length === 0 ){
        event.preventDefault();//annule le comportement par défaut de submit pour vérif
        alert('Veuillez écrire une réponse avant d\'envoyer');
        return;
    }
    document.getElementById('content').value = quill.root.innerHTML;
})