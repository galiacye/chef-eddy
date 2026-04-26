<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//home
$routes->get('/', 'Home::index');
$routes->get('test', 'Home::salut');
$routes->get('afficher','Home::afficher');
$routes->get('monpdf','Home::creerPdf');
$routes->get('upload','Article::upload');

//Admin
$routes->get('dashboard','Admin::dashboard');
    //admin::user
$routes->get('Admin/users-index','Admin::usersIndex');
$routes->get('Admin/user-details/(:num)', 'Admin::userDetails/$1');
$routes->get('Admin/add-user','Admin::addUser');
$routes->post('register', 'Auth::saveUser');
$routes->post('Admin/changeUserRole/(:num)', 'Admin::changeUserRole/$1');
$routes->get('Admin/deleteUser/(:num)', 'Admin::deleteUser/$1');
    //admin::recipe
$routes->get('Admin/recipes-index','Admin::recipesIndex');
$routes->get('Admin/recipe-details/(:num)', 'Admin::recipeDetails/$1');
$routes->post('Admin/recipe/remove/(:num)', 'Admin::deleteRecipe/$1'); //pour rejeter une recette
$routes->post('Admin/recipe/save/(:num)', 'Admin::saveRecipe/$1'); //pour approuver une recette

$routes->get('delete-user/(:num)','Admin::deleteUser/$1');// dans la vue : <a href="<?= base_url('delete-user/' . $user->id)? >supp</a>
$routes->get('delete-recipe/(:num)','Admin::deleteRecipe/$1');

//Auth
$routes->post('login', 'Auth::connect');
$routes->get('auth/register', 'Auth::connect');

//search
$routes->get('search','Search::search');
//user
$routes->match(['get','post'],'User/register', 'User::register' );
$routes->get('user/(:num)', 'User::showUser/$1');
$routes->match(['get', 'post'], 'add-user', 'User::createUser');
$routes->get('user/(:num)', 'User::cIdUser/$1');
$routes->get('user-chef/(:num)','User::userChef/$1');
$routes->get('all-users','User::UserIndex');
$routes->match(['get','post'], 'update-user/(:num)','User::updateUser/$1');

//role
$routes->get('all-roles','Role::allRoles');
$routes->get('role','Role::getRole');
//recipe
$routes->get('recipe-index','Recipe::recipeIndex');
$routes->get('recipe/(:num)','Recipe::showRecipe/$1');
$routes->match(['get','post'],'add-recipe','Recipe::createRecipe');
$routes->match(['get','post'],'update-recipe/(:num)','Recipe::updateRecipe/$1');
$routes->get('edit-recipe','Recipe::editRecipe');//test 3 champs cachés
$routes->post('delete-recipe/(:num)', 'Recipe::deleteRecipe/$1');

//ingredients
$routes->get('all-ing','Ingredients::indexIngredients');
$routes->get('one-ing/(:num)','Ingredient::showIngredient/$1');
$routes->get('add-ing', 'Ingredient::createIngredient');

//Api
$routes->get('recipesByCat', 'Api::recipesByCat');
$routes->get('recipesByNameJs','Api::recipesByName');

//categories et tags
// Routes.php
$routes->get('tag/index', 'Tag::index');
$routes->get('tag/(:num)', 'Tag::showRecipesByTag/$1');

$routes->get('category/index', 'Category::index');
$routes->get('category/(:num)', 'Category::showRecipesByCategory/$1');


