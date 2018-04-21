<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//User
//Route::get('/User','UserController@index');
//Route::get('/User/{id}','UserController@show');

//Recipe
Route::get('/Recipe','RecipeController@index');
Route::get('/Recipe/{id}','RecipeController@show');
Route::get('/Recipe/search/{name}','RecipeController@search');
Route::get('/Recipe/user/{name}', 'RecipeController@getUserRecipe');

//Article
Route::get('/Article','ArticleController@index');
Route::get('/Article/{id}','ArticleController@show');
Route::get('/Article/user/{name}', 'ArticleController@getUserArticle');

//Review
Route::get('/Review','ReviewController@index');
Route::get('/Review/{id}','ReviewController@show');

//ReportedReview
Route::get('/ReportedReview','ReportedReviewController@index');
Route::get('/ReportedReview/{id}','ReportedReviewController@show');

//Ingredient
Route::get('/Ingredient','IngredientController@index');
Route::get('/Ingredient/{id}','IngredientController@show');

//IngredientDetails
Route::get('/IngredientDetails','IngredientDetailsController@index');
Route::get('/Recipe/IngredientDetails/{id}','IngredientDetailsController@show');

//TagDetails
Route::get('/TagDetails','TagDetailsController@index');
Route::get('/TagDetails/{id}','TagDetailsController@show');

//TagHeader
Route::get('/TagHeader','TagHeaderController@index');
Route::get('/TagHeader/{id}','TagHeaderController@show');

//TagCategory
Route::get('/TagCategory','TagCategoryController@index');
Route::get('/TagCategory/{id}','TagCategoryController@show');

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('recover', 'AuthController@recover');

Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('logout', 'AuthController@logout');
    Route::get('test', function(){
        return response()->json(['foo'=>'bar']);
    });

	//User
	Route::put('/User/{id}','UserController@update');
	Route::delete('/User/{id}','UserController@destroy');

	//Recipe
	Route::post('/Recipe','RecipeController@store');
	Route::put('/Recipe/{id}','RecipeController@update');
	Route::delete('/Recipe/{id}','RecipeController@destroy');

	//Article
	Route::post('/Article','ArticleController@store');
	Route::put('/Article/{id}','ArticleController@update');
	Route::delete('/Article/{id}','ArticleController@destroy');
    Route::post('/Article/saved-article', 'SavedArticleController@store');
    Route::get('/Article/saved-article/{id}', 'SavedArticleController@show');
    Route::delete('/Article/saved-article/{user_id}/{article_id}','SavedArticleController@destroy');
    Route::get('/Article/personal-article/{id}', 'ArticleController@getPersonalArticle');

    //Recipe
    Route::post('/Recipe/saved-recipe', 'SavedRecipeController@store');
    Route::get('/Recipe/saved-recipe/{id}', 'SavedRecipeController@show');
    Route::delete('/Recipe/saved-recipe/{user_id}/{recipe_id}','SavedRecipeController@destroy');
    Route::get('/Recipe/personal-recipe/{id}','RecipeController@showPersonalRecipe');

	//Review
	Route::post('/Review','ReviewController@store');
	Route::put('/Review/{id}','ReviewController@update');
	Route::delete('/Review/{id}','ReviewController@destroy');

	//ReportedReview
	Route::post('/ReportedReview','ReportedReviewController@store');
	Route::put('/ReportedReview/{id}','ReportedReviewController@update');
	Route::delete('/ReportedReview/{id}','ReportedReviewController@destroy');

	//Ingredient
	Route::post('/Recipe/Ingredient','IngredientController@store');
	Route::put('/Recipe/Ingredient/{id}','IngredientController@update');
	Route::delete('/Recipe/Ingredient/{id}','IngredientController@destroy');

	//IngredientDetails
	Route::post('/Recipe/IngredientDetails','IngredientDetailsController@store');
	Route::put('/Recipe/IngredientDetails/{id}','IngredientDetailsController@update');
	Route::delete('/Recipe/IngredientDetails/{ingredient_id}/{recipe_id}','IngredientDetailsController@destroy');

	//TagDetails
	Route::post('/Recipe/TagDetails','TagDetailsController@store');
	Route::put('/Recipe/TagDetails/{id}','TagDetailsController@update');
	Route::delete('/Recipe/TagDetails/{tag_id}/{recipe_id}','TagDetailsController@destroy');

	//TagHeader
	Route::post('/TagHeader','TagHeaderController@store');
	Route::put('/TagHeader/{id}','TagHeaderController@update');
	Route::delete('/TagHeader/{id}','TagHeaderController@destroy');

	//TagCategory
	Route::post('/TagCategory','TagCategoryController@store');
	Route::put('/TagCategory/{id}','TagCategoryController@update');
	Route::delete('/TagCategory/{id}','TagCategoryController@destroy');
});

Route::get('user/verify/{verification_code}', 'AuthController@verifyUser');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');
