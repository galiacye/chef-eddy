<?= $this->extend('layout') ?>
<?= $this->section('body') ?>

<label for="recipesByName">Rechercher une recette avec son nom</label>
<input type="text" id="recipeName">
<button onclick="searchRecipesByName()">Rechercher</button>

<div id="results"></div>

<?= $this->section('custom-js') ?>
<script>
  function searchRecipesByName() {
    console.log('click ok');
    let recipe = document.getElementById('recipeName').value;

    if (!recipe) {
      alert("Tapez le nom d'une recette !");
      return;
    }

    fetch("https://www.themealdb.com/api/json/v1/1/search.php?s=" + recipe)
      .then(res => res.json())
      .then(data => console.log(data));
  }

</script>
<script>
console.log("JS chargé");
function searchRecipesByName() {
  console.log("Fonction OK");
}
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>