<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use Exception;

class IngredientController extends Controller
{
    protected $data;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(Ingredient $data){
        $this->data = $data;
    }

    public function index()
    {
        return Ingredient::all();
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
        $data = $this->data->where("name", "=", $request->name)->first();
        if($data == null) {
            $data = [
                "name" => $request->name
            ];
            try {
                $data = $this->data->create($data);
                return response()->json($data->id,201);
            }
            catch(Exception $ex) {
                echo $ex;
                return response('Failed', 400);
            }
        }
        else {
            return response()->json($data->id,200);
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
            $data = $this->data->where("id", "=", "$id")->get();
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
         try {
            $data = $this->data->find($id)->update([
                "name" => $request->name
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
