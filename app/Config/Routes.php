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
//user
$routes->get('user/(:num)', 'User::showUser/$1');
$routes->match(['get', 'post'], 'add-user', 'User::createUser');
$routes->get('user/(:num)', 'User::cIdUser/$1');
$routes->get('user-chef/(:num)','User::userChef/$1');
$routes->get('all-users','User::UserIndex');
//recipe
$routes->get('all-recipes','Recipe::recipeIndex');
$routes->get('recipe/(:num)','Recipe::showRecipe/$1');
$routes->match(['get','post'],'add-recipe','Recipe::createRecipe');
$routes->get('update-recipe/(:num)','Recipe::updateRecipe');

//ingredients
$routes->get('all-ing','Ingredients::indexIngredients');
$routes->get('one-ing/(:num)','Ingredient::showIngredient/$1');
$routes->get('add-ing', 'Ingredient::createIngredient');


//

