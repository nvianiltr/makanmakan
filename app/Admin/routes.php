<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('/User',UserController::class);
    $router->resource('/Article',ArticleController::class);
    $router->resource('/Recipe',RecipeController::class);
    $router->resource('/Review',ReviewController::class);//here
    $router->resource('/Ingredient',IngredientController::class);
    $router->resource('/TagCategory',TagCategoryController::class);
    $router->resource('/IngredientDetail',IngredientDetailsController::class);
    $router->resource('/ReportedReview',ReportedReviewController::class);
    $router->resource('/TagDetail',TagDetailsController::class);	
    $router->resource('/TagHeader',TagHeaderController::class);



});
