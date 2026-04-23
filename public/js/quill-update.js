//script update d'ou chargement et pré-remplissage


document.addEventListener("DOMContentLoaded", function () {
  const editorElement = document.querySelector("#editor");
  //console.log("Editor element:", editorElement);
  if (editorElement) {
    const quill = new Quill("#editor", {
      theme: "snow",
      placeholder: "Écrivez votre recette ici...",
    });

    const hiddenInput = document.querySelector("#contenu");//pont quill-serveur
    const form = document.querySelector("form");

    // Pré-remplissage: si on modifie une recette existante,
    // PHP a déjà mis le contenu dans le champ caché
    if (hiddenInput.value) {
      quill.root.innerHTML = hiddenInput.value;//=si le champ caché est rempli quill affiche sa valeur 
    }
    // Au submit : sens inverse, on copie Quill dans le champ caché
    // pour que le formulaire puisse envoyer le contenu au serveur
    // Quill -> champ caché -> PHP -> Base de données
    form.addEventListener("submit", function () {
      hiddenInput.value = quill.root.innerHTML;
      //clic submit->js s'exec(copie quill ds hidden input html)->puis form vers php
    });
  }
});
