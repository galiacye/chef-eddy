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

//Auth
$routes->get('login', 'Auth::login');//afiche le form
$routes->post('login', 'Auth::connect');
$routes->match(['get','post'], 'register', 'Auth::register');
$routes->post('logout', 'Auth::logout');
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

//PROFIL
$routes->match(['get', 'post'], 'profil/(:num)', 'User::profile/$1');
$routes->match(['get', 'post'], 'toy', 'User::');

//role
$routes->get('all-roles','Role::allRoles');
$routes->get('role','Role::getRole');
//user/recipe
$routes->get('recipe-index','Recipe::recipeIndex');
$routes->get('recipe/(:num)','Recipe::showRecipe/$1');
$routes->match(['get','post'],'add-recipe','Recipe::createRecipe');
$routes->match(['get','post'],'update-recipe/(:num)','Recipe::updateRecipe/$1');
$routes->get('edit-recipe','Recipe::editRecipe');//test 3 champs cachés
$routes->post('delete-recipe/(:num)', 'Recipe::deleteRecipe/$1');

//ingredients
$routes->get('Admin/ingredients/delete/(:num)', 'Ingredient::deleteIngredient/$1');
$routes->get('Admin/ing-index', 'Ingredient::ingIndex');
$routes->get('Admin/delete-ing/(:num)', 'Admin::deleteIngredient/$1');

//Api
$routes->get('recipesByCat', 'Api::recipesByCat');
$routes->get('recipesByNameJs','Api::recipesByName');

//categories et tags
// Routes.php
$routes->get('tag/index', 'Tag::index');
$routes->get('tag/(:num)', 'Tag::showRecipesByTag/$1');

$routes->get('category/index', 'Category::index');
$routes->get('category/(:num)', 'Category::showRecipesByCategory/$1');

//ingredients
$routes->get('Admin/ing-index', 'Ingredient::ingIndex');
$routes->get('Admin/delete/(:num)', 'Ingredient::deleteIngredient/$1');

//comments-user
$routes->get('add-comment/(:num)', 'Comment::addComment/$1');//form user
$routes->post('comment/save', 'Comment::saveComment');//mis en base en pending. id passé par post pas de num
//$routes->match(['get', 'post'], 'comment/update/(:num)', 'Comment::updateComment/$1');
$routes->get('comment/update/(:num)', 'Comment::updateComment/$1');
$routes->post('comment/update/(:num)', 'Comment::updateComment/$1');
//admin
$routes->get('Admin/comments', 'Comment::commentsIndex');
$routes->post('comment/status/(:num)', 'Comment::updateCommentStatus/$1');
$routes->post('comment/status/(:num)/(:alpha)', 'Comment::updateCommentStatus/$1/$2');
$routes->post('comment/delete/(:num)', 'Comment::deleteComment/$1');

$routes->post('comment/reply', 'Comment::replyComment');

