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

  let index = 1;//pour numéroter les nouvelles lignes dynamiques d'ingrédients
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

    <input type="hidden" name="ingredients[${index}][name]" id="ing-name-${index}">
    <input type="hidden" name="ingredients[${index}][quantity]" id="ing-qty-${index}">
    <input type="hidden" name="ingredients[${index}][unit]" id="ing-unit-${index}">

    <small class="text-muted parsing-preview w-100"></small>

    <select name="ingredients[${index}][category_id]" class="form-select w-25">
        ${options}
    </select>

    <button type="button" class="btn btn-danger supprimer-ligne">✕</button>
`;
  container.appendChild(row);//on insère les nouvelles lignes
      index++;
    });
  //évènement attendu passé sur le container:
  // délégation : on écoute le container car les boutons sont créés dynamiquement
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
  //échappe les caractères spéciaux de $units car il pourrait y avoir des points (gr.)
  // ou autres carac spé puisque c'est une string, et le regex serait perdue!
  function escapeRegex(str) {
    return str.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
  }
  //découpe la saisie en objet js { quantite, unite, nom }
  function parseIngredient(text) {
    const escapedUnits = units.map((u) => escapeRegex(u));
    const regex = new RegExp(
      `^(\\d+[.,]?\\d*)\\s*(${escapedUnits.join("|")})?\\s*(.+)$`,
      "i",
    );

    // ^(\d+[.,]?\d*)         groupe 1 : le nombre (200, 1.5 etc)
    // \s*(g|ml|kg|cl|...)? groupe 2 : l'unité optionnelle (vient de php $unit)
    // \s*(.+)$             groupe 3 : nom de l'ingrédient


    //verifier si saisie matche avec regex
    const match = text.trim().match(regex);//trim supp espaces
    if (match) {
      return {//match est un tab
        quantity: match[1],
        unit: match[2] || "",//peut être indéfini: 1 oeuf
        name: match[3].trim(),
      };
    }
    // si ni quantité ni unité (sel)
    return { quantity: "", unit: "", name: text.trim() };
  }

  // écoute ce que tape user et remplit les champs cachés
  document.addEventListener("input", function (e) {
    if (!e.target.classList.contains("ingredient-input")) return;
    const index = e.target.dataset.index;
    const parsed = parseIngredient(e.target.value);
    document.getElementById(`ing-name-${index}`).value = parsed.name;
    document.getElementById(`ing-qty-${index}`).value = parsed.quantity;
    document.getElementById(`ing-unit-${index}`).value = parsed.unit;
  });

  //  submit
  document.getElementById("form").addEventListener("submit", (e) => {
    const html = quill.root.innerHTML;
    document.getElementById("content").value = html;

    // vérifier que ce n'est pas vide
    const text = quill.getText().trim();
    if (text.length === 0) {
      e.preventDefault(); //empêche l'envoi par défaut
      alert("Veuillez écrire une recette avant d'envoyer");
    }
  });
});
