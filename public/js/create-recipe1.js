
document.addEventListener('DOMContentLoaded', () => {
    const quill = new Quill('#editor', {
        modules: { toolbar: '#toolbar' },
        theme: 'snow',
    });
});

const existingContent = document.getElementById("contenu").value;
//je le laisse si jamais plus tard je fait une seule vue pour create et update
if (existingContent) {
  quill.root.innerHTML = existingContent;
}

// Ajouter les tooltips en français
document.querySelector(".ql-bold").setAttribute("title", "Gras");
document.querySelector(".ql-italic").setAttribute("title", "Italique");
document.querySelector(".ql-underline").setAttribute("title", "Souligné");
document
  .querySelector('.ql-list[value="ordered"]')
  .setAttribute("title", "Liste numérotée");
document
  .querySelector('.ql-list[value="bullet"]')
  .setAttribute("title", "Liste à puces");

//bouton ajouter un ing:
let index = 1;

document.getElementById("ajouter-ingredient").addEventListener("click", () => {
  const container = document.getElementById("ingredients-container");

  //ajouter une ligne
  const row = document.createElement("div");
  row.classList.add("ingredient-row", "gap-2", "mb-2");

  const options = Object.entries(categoriesIngredient) //vient de la vue php->json
    .map(([val, label]) => `<option value="${val}">${label}</option>`)
    .join("");

  row.innerHTML = `
    <input type="text"
        class="form-control ingredient-input"
        placeholder="Ex: 200g farine"
        data-index="${index}">

    <input type="hidden" name="ingredients[${index}][nom]" id="ing-nom-${index}">
    <input type="hidden" name="ingredients[${index}][quantite]" id="ing-qte-${index}">
    <input type="hidden" name="ingredients[${index}][unite]" id="ing-unite-${index}">

    <small class="text-muted parsing-preview w-100"></small>

    <select name="ingredients[${index}][category]" class="form-select w-25">
        ${options}
    </select>

    <button type="button" class="btn btn-danger supprimer-ligne">✕</button>
`;

  container.appendChild(row);
  index++;
});

document
  .getElementById("ingredients-container")
  .addEventListener("click", (e) => {
    if (e.target.classList.contains("supprimer-ligne")) {
      const rows = document.querySelectorAll(".ingredient-row");
      if (rows.length > 1) {
        e.target.closest(".ingredient-row").remove();
      } else {
        alert("Il faut au moins un ingrédient !");
      }
    }
  });

  //parsing
  function escapeRegex(str) {
    return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

function parseIngredient(texte) {
    const unitesEchappees = unites.map(u => escapeRegex(u));
    const regex = new RegExp(
        `^(\\d+[.,]?\\d*)\\s*(${unitesEchappees.join('|')})?\\s*(.+)$`, 'i'
    );
    const match = texte.trim().match(regex);
    if (match) {
        return { quantite: match[1], unite: match[2] || '', nom: match[3].trim() };
    }
    // Pas de quantité ni unité (ex: "sel", "poivre")
    return { quantite: '', unite: '', nom: texte.trim() };
}

// Écoute ce que l'user tape et remplit les champs cachés
document.addEventListener('input', function(e) {
    if (!e.target.classList.contains('ingredient-input')) return;
    const index  = e.target.dataset.index;
    const parsed = parseIngredient(e.target.value);
    document.getElementById(`ing-nom-${index}`).value   = parsed.nom;
    document.getElementById(`ing-qte-${index}`).value   = parsed.quantite;
    document.getElementById(`ing-unite-${index}`).value = parsed.unite;
});

// Gestion de la soumission du formulaire
document.getElementById("form").addEventListener("submit", (e) => {
  const html = quill.root.innerHTML;
  document.getElementById("contenu").value = html;

  // Vérifier que ce n'est pas vide
  const text = quill.getText().trim();
  if (text.length === 0) {
    e.preventDefault(); //empêche l'envoi par défaut
    alert("Veuillez écrire une recette avant d'envoyer");
  }
});
