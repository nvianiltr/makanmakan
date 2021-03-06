<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\User;
use App\Models\TagDetails;
use App\Models\TagHeader;
use App\Models\TagCategory;
use Validator;
use Exception;

class RecipeController extends Controller
{
    protected $recipe;

    public function __construct(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }

    //show all recipe
    public function index()
    {
        try {
            $recipe = $this->recipe
                ->latest('recipes.dateCreated')
                ->with('tagDetails.tagHeader', 'ingredientDetails.ingredient', 'reviews.user')
                ->join('users', 'users.id', '=', 'recipes.user_id')
                ->select('recipes.id', 'recipes.title', 'users.id AS user_id', 'users.username', 'recipes.about', 'recipes.pictureURL',
                    'recipes.servingQty', 'recipes.servingUnit', 'recipes.preparation', 'recipes.dateCreated')
                ->get();
            return response()->json($recipe, 200);
        } catch (Exception $ex) {
            echo $ex;
            return response('Failed', 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    //create a new recipe
    public function store(Request $request)
    {
        $credentials = $request->only('title', 'preparation');

        $rules = [
            'title' => 'required',
            'preparation' => 'required'
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()->first()], 422);
        }

        $recipe = [
            "user_id" => $request->user_id,
            "title" => $request->title,
            "about" => $request->about,
            "pictureURL" => $request->pictureURL,
            "servingQty" => $request->servingQty,
            "servingUnit" => $request->servingUnit,
            "preparation" => $request->preparation,
            "dateCreated" => $request->dateCreated
        ];
        try {
            $recipe = $this->recipe->create($recipe);
            return response()->json($recipe, 201);
        } catch (Exception $ex) {
            echo $ex;
            return response()->json(['success' => false, 'error' => $validator->messages()->first()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $recipe = $this->recipe
                ->where("recipes.id", "=", "$id")
                ->with(array('ingredientDetails' => function ($query) {
                    $query
                        ->join('ingredients', 'ingredients.id', '=', 'ingredient_details.ingredient_id')
                        ->get();
                }))
                ->with('tagDetails.tagHeader', 'reviews.user')
                ->join('users', 'users.id', '=', 'recipes.user_id')
                ->select('recipes.id', 'recipes.title', 'users.id AS user_id', 'users.username', 'recipes.about', 'recipes.pictureURL',
                    'recipes.servingQty', 'recipes.servingUnit', 'recipes.preparation', 'recipes.dateCreated')
                ->first();
            return response()->json($recipe, 200);
        } catch (Exception $ex) {
            echo $ex;
            return response('Failed', 400);
        }
    }

    public function showPersonalRecipe($id)
    {
        try {
            $recipe = $this->recipe
                ->latest('recipes.dateCreated')
                ->where("recipes.user_id", "=", "$id")
                ->join('users', 'users.id', '=', 'recipes.user_id')
                ->select('recipes.id', 'recipes.title', 'users.id AS user_id', 'users.username', 'recipes.about', 'recipes.pictureURL','recipes.dateCreated')
                ->get();
            return response()->json($recipe, 200);
        } catch (Exception $ex) {
            echo $ex;
            return response('Failed', 400);
        }
    }

    public function getUserRecipe($username)
    {
        try {
            $recipe = $this->recipe
                ->latest('recipes.dateCreated')
                ->where("users.username", "=", "$username")
                ->join('users', 'users.id', '=', 'recipes.user_id')
                ->select('recipes.id', 'recipes.title', 'users.id AS user_id', 'users.username', 'recipes.about', 'recipes.pictureURL','recipes.dateCreated')
                ->get();
            return response()->json($recipe, 200);
        } catch (Exception $ex) {
            echo $ex;
            return response('Failed', 400);
        }
    }

    public function search($name)
    {
        try {
            $recipe = $this->recipe->where('recipes.title', 'LIKE', "%$name%")
                ->orWhereHas('tagDetails.tagHeader', function ($query) use ($name) {
                    $query->where('name', $name);
                })
                ->orWhere('users.username', 'LIKE', "%$name%")
                ->with('tagDetails.tagHeader', 'ingredientDetails.ingredient', 'reviews.user')
                ->join('users', 'users.id', '=', 'recipes.user_id')
                ->select('recipes.id', 'recipes.title', 'users.id AS user_id', 'users.username', 'recipes.about', 'recipes.pictureURL',
                    'recipes.servingQty', 'recipes.servingUnit', 'recipes.preparation', 'recipes.dateCreated')
                ->get();
            return response()->json($recipe, 200);
        } catch (Exception $ex) {
            echo $ex;
            return response('Failed', 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $credentials = $request->only('title', 'preparation');

        $rules = [
            'title' => 'required',
            'preparation' => 'required'
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()->first()], 422);
        }

        try {
            $recipe = $this->recipe->find($id)->update([
                "user_id" => $request->user_id,
                "title" => $request->title,
                "about" => $request->about,
                "pictureURL" => $request->pictureURL,
                "servingQty" => $request->servingQty,
                "servingUnit" => $request->servingUnit,
                "preparation" => $request->preparation,
                "dateCreated" => $request->dateCreated
            ]);

            return response()->json($this->show($id)->original, 200);
        } catch (Exception $ex) {
            return response()->json($ex, 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

//            $recipe = $this->recipe->where("id", "=", "$id")->update(['isDeleted' => true]);;
//            return response('Deleted',200);
            $recipe = $this->recipe->where("id", "=", "$id")->delete();
            return response()->json([], 201);
        } catch (Exception $ex) {
            return response($ex, 400);
        }
    }
}
