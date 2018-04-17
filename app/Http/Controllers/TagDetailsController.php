<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TagDetails;
use Exception;

class TagDetailsController extends Controller
{
    protected $data;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(TagDetails $data){
        $this->data = $data;
    }

    public function index()
    {
        try {
            $data = $this->data->with('tagHeader')->get();
            return response()->json($data, 200);
        }
        catch (Exception $ex) {
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            "recipe_id" => $request->recipe_id,
            "tag_id" => $request->tag_id
        ];
        try { 
            $data = $this->data->create($data); 
            return response()->json(['message'=>'created'],201);
        } 
        catch(Exception $ex) {
            echo $ex; 
            return response()->json(['message'=>$ex], 400);
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
            $data = $this->data->where("recipe_id", "=", "$id")->get();
            return response()->json($data, 200);
        }
        catch (Exception $ex) {
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
        //
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
            $data = $this->data->where("tag_id", "=", "$id")->delete();
            return response()->json(['message'=>"deleted"], 200);
        }
        catch (Exception $ex) {
            echo $ex;
            return response()->json(['message'=>'failed'], 400);
        }
    }
}
