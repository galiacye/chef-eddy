//console.log('js chargé');

document.addEventListener("DOMContentLoaded", () => {
  const quill = new Quill("#editor", {
    modules: { toolbar: "#toolbar" },
    theme: "snow",
  });
  //à garder pour faire plus tard create et update ds même vue
  const existingContent = document.getElementById("content").value;
  if (existingContent) {
    quill.root.innerHTML = existingContent;
  }
  // tooltips 
  document.querySelector(".ql-bold").setAttribute("title", "Gras");
  document.querySelector(".ql-italic").setAttribute("title", "Italique");
  document.querySelector(".ql-underline").setAttribute("title", "Souligné");
  document.querySelector('.ql-list[value="ordered"]').setAttribute("title", "Liste numérotée");
  document.querySelector('.ql-list[value="bullet"]').setAttribute("title", "Liste à puces");

  let index = 1;//pour numéroter les nouvelles lignes lignes dynamiques d'ingrédients

  document
    .getElementById("ajouter-ingredient")
    .addEventListener("click", () => {
      const container = document.getElementById("ingredients-container");

      //ajouter une ligne
      const row = document.createElement("div");//méthode native du DOM
      //créé l'elem qui sera injecté dans la page avec container.appendChild(row)
      row.classList.add("ingredient-row", "gap-2", "mb-2");//on lui ajoute des classes
//php passe du json à la vue: on en fait un select:
      const options = Object.entries(categoriesIngredient) //vient de la vue php->json
     // Object.entries transforme l'objet json en tab clé/valeur
        .map(([val, label]) => `<option value="${val}">${label}</option>`)
        //map sépare la paire en 2 var
        .join("");//transforme le tab en string

      row.innerHTML = `
    <input type="text"
        class="form-control ingredient-input"
        placeholder="Ex: 200g farine"
        data-index="${index}">

    <input type="hidden" name="ingredients[${index}][nom]" id="ing-nom-${index}">
    <input type="hidden" name="ingredients[${index}][quantite]" id="ing-qte-${index}">
    <input type="hidden" name="ingredients[${index}][unite]" id="ing-unite-${index}">

    <small class="text-muted parsing-preview w-100"></small>

    <select name="ingredients[${index}][categorie]" class="form-select w-25">
        ${options}
    </select>

    <button type="button" class="btn btn-danger supprimer-ligne">✕</button>
`;

      container.appendChild(row);//on insère les nouvelles lignes
      index++;
    });
//évènement attendu passé sur le container:
//délégation d'événement : au lieu de mettre un écouteur sur chaque bouton supp 
// (qui n'existent pas encore au chargement puisqu'ils sont créés dynamiquement), 
// on écoute les clics sur le container parent. Quand un clic arrive, e.target c'est
//  l'élément cliqué — on vérifie s'il a la classe supprimer-ligne.
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
    return str.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
  }

  function parseIngredient(texte) {
    const unitesEchappees = unites.map((u) => escapeRegex(u));
    const regex = new RegExp(
      `^(\\d+[.,]?\\d*)\\s*(${unitesEchappees.join("|")})?\\s*(.+)$`,
      "i",
    );
    const match = texte.trim().match(regex);
    if (match) {
      return {
        quantite: match[1],
        unite: match[2] || "",
        nom: match[3].trim(),
      };
    }
    // Pas de quantité ni unité (ex: "sel", "poivre")
    return { quantite: "", unite: "", nom: texte.trim() };
  }

  // Écoute ce que l'user tape et remplit les champs cachés
  document.addEventListener("input", function (e) {
    if (!e.target.classList.contains("ingredient-input")) return;
    const index = e.target.dataset.index;
    const parsed = parseIngredient(e.target.value);
    document.getElementById(`ing-nom-${index}`).value = parsed.nom;
    document.getElementById(`ing-qte-${index}`).value = parsed.quantite;
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

  // submit
  document.getElementById("form").addEventListener("submit", (e) => {
    const html = quill.root.innerHTML;
    document.getElementById("contenu").value = html;

    const text = quill.getText().trim();
    if (text.length === 0) {
      e.preventDefault();
      alert("Veuillez écrire une recette avant d'envoyer");
    }
  });
});
