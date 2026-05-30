<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);

//home
$routes->get('/', 'Home::index');
$routes->get('test', 'Home::salut');
$routes->get('afficher','Home::afficher');
$routes->get('monpdf','Home::creerPdf');
$routes->get('upload','Article::upload');


// Auth
$routes->get('login', 'Auth::login'); // affiche le form
$routes->post('login', 'Auth::connect');
$routes->match(['get', 'post'], 'register', 'Auth::register');
$routes->get('logout', 'Auth::logout');
$routes->match(['get', 'post'], 'forgot-password', 'Auth::forgotPassword');
$routes->match(['get', 'post'], 'reset-password/(:any)', 'Auth::resetPassword/$1');

//Admin
$routes->get('dashboard', 'Admin::dashboard');
$routes->post('Admin/set-homepage-tag', 'Admin::setHomepageTag');

// Admin - users
$routes->get('Admin/users-index', 'Admin::usersIndex');
$routes->get('Admin/user-details/(:num)', 'Admin::userDetails/$1');
$routes->match(['get', 'post'], 'Admin/add-user', 'Admin::addUser');
$routes->post('Admin/changeUserRole/(:num)', 'Admin::changeUserRole/$1');
$routes->get('Admin/deleteUser/(:num)', 'Admin::deleteUser/$1');
$routes->get('delete-user/(:num)', 'Admin::deleteUser/$1'); 

// Admin - recipes
$routes->get('Admin/recipes-index', 'Admin::recipesIndex');
$routes->get('Admin/recipe-details/(:num)', 'Admin::recipeDetails/$1');
$routes->post('Admin/recipe/remove/(:num)', 'Admin::deleteRecipe/$1'); // pour rejeter une recette
$routes->post('Admin/recipe/save/(:num)', 'Admin::saveRecipe/$1'); // pour approuver une recette

// Admin - ingredients
$routes->get('Admin/ing-index', 'Ingredient::ingIndex');
$routes->get('Admin/ingredients/delete/(:num)', 'Ingredient::deleteIngredient/$1');

// Admin - comments
$routes->get('Admin/comments', 'Comment::commentsIndex');
$routes->post('comment/status/(:num)/(:alpha)', 'Comment::updateCommentStatus/$1/$2');
$routes->post('comment/delete/(:num)', 'Comment::deleteComment/$1');
$routes->post('comment/reply', 'Comment::replyComment');

// Search
$routes->get('search', 'Search::search');

// User
$routes->get('user/(:num)', 'User::showUser/$1');
$routes->get('user-chef/(:num)', 'User::userChef/$1');
$routes->get('all-users', 'User::userIndex');
$routes->match(['get', 'post'], 'update-user/(:num)', 'User::updateUser/$1');

// Profile : ?int $id = null signifie que le param est optionnel mais il faut les 2 routes pour cas où
$routes->match(['get', 'post'], 'profile', 'User::profile'); // id vient de la session
$routes->match(['get', 'post'], 'profile/(:num)', 'User::profile/$1'); // voir le profil d'un user en particulier

// Recipes
$routes->get('recipe-index', 'Recipe::recipeIndex');
$routes->get('recipe/(:num)', 'Recipe::showRecipe/$1');
$routes->match(['get', 'post'], 'add-recipe', 'Recipe::createRecipe');
$routes->match(['get', 'post'], 'update-recipe/(:num)', 'Recipe::updateRecipe/$1');
$routes->post('delete-recipe/(:num)', 'Recipe::deleteRecipe/$1');
$routes->get('edit-recipe', 'Recipe::editRecipe'); // test 3 champs cachés

// Categories
$routes->get('category/index', 'Category::index');
$routes->get('category/(:num)', 'Category::showRecipesByCategory/$1');

// Tags
$routes->get('tag/index', 'Tag::index');
$routes->get('tag/(:num)', 'Tag::showRecipesByTag/$1');

// Comments - user
$routes->get('add-comment/(:num)', 'Comment::addComment/$1'); // form user
$routes->post('comment/save', 'Comment::saveComment'); // mis en base en pending, id passé par post pas de num
$routes->get('comment/update/(:num)', 'Comment::updateComment/$1');
$routes->post('comment/update/(:num)', 'Comment::updateComment/$1');

// Favorites
$routes->post('favorites/toggle/(:num)', 'Favorite::toggle/$1');
$routes->get('favorites', 'Favorite::index');

// Roles
$routes->get('all-roles', 'Role::allRoles');
$routes->get('role', 'Role::getRole');

//password-forgot
$routes->match(['get', 'post'], 'forgot-password', 'Auth::forgotPassword');
$routes->match(['get', 'post'], 'reset-password/(:any)', 'Auth::resetPassword/$1');

