document.addEventListener('DOMContentLoaded', () => {
const quill = new Quill('#editor', {
        modules: { //relie la toolbar qui est en dehors du form
            toolbar: '#toolbar'
        },
        placeholder: 'Écrivez votre recette ici...',
        theme: 'snow',
    });
    const existingContent = document.getElementById('contenu').value;
    if (existingContent) {
        quill.root.innerHTML = existingContent;
    }

    // Ajouter les tooltips en français
    document.querySelector('.ql-bold').setAttribute('title', 'Gras');
    document.querySelector('.ql-italic').setAttribute('title', 'Italique');
    document.querySelector('.ql-underline').setAttribute('title', 'Souligné');
    document.querySelector('.ql-list[value="ordered"]').setAttribute('title', 'Liste numérotée');
    document.querySelector('.ql-list[value="bullet"]').setAttribute('title', 'Liste à puces');

    //bouton ajouter un ing:

    document.getElementById('ajouter-ingredient').addEventListener('click', () => {
        const container = document.getElementById('ingredients-container');
        const row = document.createElement('div');
        row.classList.add('ingredients-row', 'gap-2', 'mb-2');

        const options = Object.entries(categoriesIngredient)
            .map(([val, label]) => `<option value="${val}">${label}</option>`)
            .join('');

        row.innerHTML = `
        <input type="text"   name="ingredients[${index}][nom]"      placeholder="Nom"            class="form-control">
        <input type="number" name="ingredients[${index}][quantite]" placeholder="Quantité"       class="form-control w-25">
        <input type="text"   name="ingredients[${index}][unite]"    placeholder="Unité (g, ml…)" class="form-control w-25">
        <select name="ingredients[${index}][categorie]" class="form-select w-25">${options}</select>
        <button type="button" class="btn btn-danger supprimer-ligne">✕</button>
    `;
        container.appendChild(row);
        index++;
    });

    document.getElementById('ingredients-container').addEventListener('click', (e) => {
        if (e.target.classList.contains('supprimer-ligne')) {
            const rows = document.querySelectorAll('.ingredients-row');
            if (rows.length > 1) {
                e.target.closest('.ingredients-row').remove();
            } else {
                alert('Il faut au moins un ingrédient !');
            }
        }
    });

    // Gestion de la soumission du formulaire
    document.getElementById('form').addEventListener('submit', (e) => {
        const html = quill.root.innerHTML;
        document.getElementById('contenu').value = html;

        // Vérifier que ce n'est pas vide
        const text = quill.getText().trim();
        if (text.length === 0) {
            e.preventDefault(); //empêche l'envoi par défaut
            alert('Veuillez remplir le formulaire avant d\'envoyer');
        }
    });
})
