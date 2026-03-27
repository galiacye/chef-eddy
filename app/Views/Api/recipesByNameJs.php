<?= $this->extend('layout') ?>
<?= $this->section('body') ?>

<label for="recipesByName">Rechercher une recette avec son nom</label>
<input type="text" id="recipeName">
<button onclick="searchRecipesByName()">Rechercher</button>

<div id="results"></div>

<?= $this->section('custom-js') ?>
<script>
console.log("JS chargé");

function searchRecipesByName() {
    console.log('click OK');

    let recipe = document.getElementById('recipeName').value;

    if (!recipe) {
        alert("Tapez le nom d'une recette !");
        return;
    }

    fetch("https://www.themealdb.com/api/json/v1/1/search.php?s=" + recipe)
        .then(res => res.json())
        .then(data => {
            const resultsDiv = document.getElementById('results');
            resultsDiv.innerHTML = ""; // vide les résultats précédents

            if (data.meals) {
                data.meals.forEach(meal => {
                    resultsDiv.innerHTML += `
                    <div>
                        <h3>${meal.strMeal}</h3>
                        <img src="${meal.strMealThumb}" width="150">
                    </div>
                    `;
                });
            } else {
                resultsDiv.innerHTML = "<p>Aucune recette trouvée</p>";
            }
        });
}
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>