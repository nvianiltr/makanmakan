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
Route::get('/User','UserController@index');
Route::get('/User/{id}','UserController@show');
Route::get('/UserwithArticle/{id}','UserController@showWithArticle');
Route::get('/UserwithRecipe/{id}','UserController@showWithRecipe');
Route::get('/UserwithSavedArticle/{id}','UserController@showWithSavedArticle');

//Recipe
Route::get('/Recipe','RecipeController@index');
Route::get('/Recipe/{id}','RecipeController@show');
Route::get('/RecipeFK/{id}','RecipeController@showFK');
Route::get('/Recipe/search/{name}','RecipeController@search');

//Article
Route::get('/Article','ArticleController@index');
Route::get('/Article/{id}','ArticleController@show');
Route::get('/ArticleFK/{id}','ArticleController@showFK');

//Review
Route::get('/Review','ReviewController@index');
Route::get('/Review/{id}','ReviewController@show');
Route::get('/ReviewFK/{id}','ReviewController@showFK');

//ReportedReview
Route::get('/ReportedReview','ReportedReviewController@index');
Route::get('/ReportedReview/{id}','ReportedReviewController@show');


//Ingredient
Route::get('/Ingredient','IngredientController@index');
Route::get('/Ingredient/{id}','IngredientController@show');


//IngredientDetails
Route::get('/IngredientDetails','IngredientDetailsController@index');
Route::get('/IngredientDetails/{id}','IngredientDetailsController@show');


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
    Route::resource('/Payment','PaymentController');
    Route::resource('/TransactionHeader','TransactionHeaderController');
    Route::resource('/TransactionDetails','TransactionDetailsController');
//    Route::resource('/SavedArticle','SavedArticleController');
//    Route::resource('/SavedArticle','SavedArticleController');
//	Route::resource('/SavedRecipe','SavedRecipeController');

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
	Route::get('/SavedArticle/{id}','ArticleController@showPersonalArticle');

//Recipe
	Route::get('/SavedRecipe/{id}','RecipeController@showPersonalRecipe');


	//Review
	Route::post('/Review','ReviewController@store');
	Route::put('/Review/{id}','ReviewController@update');
	Route::delete('/Review/{id}','ReviewController@destroy');

	//ReportedReview
	Route::post('/ReportedReview','ReportedReviewController@store');
	Route::put('/ReportedReview/{id}','ReportedReviewController@update');
	Route::delete('/ReportedReview/{id}','ReportedReviewController@destroy');

	//Ingredient
	Route::post('/Ingredient','IngredientController@store');
	Route::put('/Ingredient/{id}','IngredientController@update');
	Route::delete('/Ingredient/{id}','IngredientController@destroy');

	//IngredientDetails
	Route::post('/IngredientDetails','IngredientDetailsController@store');
	Route::put('/IngredientDetails/{id}','IngredientDetailsController@update');
	Route::delete('/IngredientDetails/{id}','IngredientDetailsController@destroy');

	//TagDetails
	Route::post('/TagDetails','TagDetailsController@store');
	Route::put('/TagDetails/{id}','TagDetailsController@update');
	Route::delete('/TagDetails/{id}','TagDetailsController@destroy');

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
