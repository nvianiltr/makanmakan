<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Recipe;
use JWTAuth;
use Exception;

class ReviewController extends Controller
{
    protected $data;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(Review $data){
        $this->data = $data;
    }

    public function index()
    {
        $reviews = Review::all();
        foreach($reviews as $review){
            $review->user;
        }

        return response()->json($reviews,200);

        // return Review::all();
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
        $user = JWTAuth::toUser();
        
         $data = [
            "recipe_id" => $request->recipe_id,
            "user_id" => $user->id,
            "content" => $request->content,
            "datePosted" => $request->datePosted
        ];
        try { 
            $data = $this->data->create($data); 
            return response(['msg' => 'Created'],201);
        } 
        catch(Exception $ex) {
            echo $ex; 
            return response(['msg' => 'Failed'], 400);
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
            // $data = $this->data->where("id", "=", "$id")->get();
            $res = Recipe::where('id',$id)->get();
            foreach($res as $single) {
                $single->reviews;
            }
            return response()->json($res, 200);
        }
        catch (Exception $ex) {
            echo $ex;
            return response(['msg' => 'Failed'], 400);
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
        try {
            $data = $this->data->find($id)->update([
                "recipe_id" => $request->recipe_id,
                "user_id" => $request->user_id,
                "content" => $request->content,
                "datePosted" => $request->datePosted
            ]);
            $data = $this->data->where("id", "=", $id)->get();

            return response()->json($data,200);
        }
        catch(Exception $ex) {
            return response()->json($ex, 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = $this->data->where("id", "=", "$id")->delete();
            return response('Deleted',200);
        }
        catch(Exception $ex) {
            return response($ex, 400);
        }
    }
}
