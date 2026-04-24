1.input.addEventListener("input", () => {
    const resultat = parseIngredient(input.value);
    });

    input.addEventListener
        =>"l'evenement (par ex une fonction parseInt) se déclenche quand l'user tape dans l'input"
        "->pour prévisualiser: auto remplissage"

2.input.addEventListener("blur", () => {
    const resultat = parseIngredient(input.value);
});

        =>"plus fiable car user a fini de taper" 
        "->pour valider definitivement"