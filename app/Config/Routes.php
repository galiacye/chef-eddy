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
$routes->get('delete-user/(:num)','Admin::deleteUser/$1');
// dans la vue : <a href="<?= base_url('delete-user/' . $user->id) >supp</a>

$routes->get('delete-recipe/(:num)','Admin::deleteRecipe/$1');

//search
$routes->get('search','Search::search');
//user
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
$routes->get('recipeIndex','Recipe::recipeIndex');
$routes->get('recipe/(:num)','Recipe::showRecipe/$1');
$routes->match(['get','post'],'add-recipe','Recipe::createRecipe');
$routes->get('update-recipe/(:num)','Recipe::updateRecipe');

//ingredients
$routes->get('all-ing','Ingredients::indexIngredients');
$routes->get('one-ing/(:num)','Ingredient::showIngredient/$1');
$routes->get('add-ing', 'Ingredient::createIngredient');

//Api
$routes->get('recipesByCat', 'Api::recipesByCat');
$routes->get('recipesByNameJs','Api::recipesByName');




