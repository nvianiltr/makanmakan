<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedRecipe; 
use Exception;

class SavedRecipeController extends Controller
{
     protected $data;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(SavedRecipe $data){
        $this->data = $data;
    }

    public function index()
    {
        return SavedRecipe::all();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            "recipe_id" => $request->recipe_id,
            "user_id" => $request->user_id
        ];
        try { 
            $data = $this->data->create($data); 
            return response()->json(['msg'=>'Created'],201);
        } 
        catch(Exception $ex) {
            echo $ex;
            return response()->json(['msg'=>'Failed'],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $recipe = $this->data
                ->where("saved_recipes.user_id", "$id")
                ->join('recipes', 'recipes.id', 'saved_recipes.recipe_id')
                ->join('users', 'users.id', '=', 'recipes.user_id')
                ->select('recipes.id', 'recipes.title', 'recipes.user_id AS user_id', 'users.username', 'recipes.about', 'recipes.pictureURL','recipes.dateCreated')
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $recipe_id)
    {
        try {
            $data = $this->data
                ->where('user_id', $user_id)
                ->where('recipe_id',$recipe_id)
                ->delete();
            return response()->json(["status"=>"deleted"],201);
        }
        catch(Exception $ex) {
            return response($ex, 400);
        }
    }
}
