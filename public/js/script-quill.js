document.addEventListener("DOMContentLoaded", function () {

    var editorElement = document.querySelector('#editor');
console.log('Editor element:', editorElement);
    if (editorElement) {

        var quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: "Écrivez votre recette ici..."
        });

        var hiddenInput = document.querySelector('#contenu');
        var form = document.querySelector('form');

        // Pré-remplissage
        if (hiddenInput.value) {
            quill.root.innerHTML = hiddenInput.value;
        }

        form.addEventListener('submit', function () {
            hiddenInput.value = quill.root.innerHTML;
        });
    }
});