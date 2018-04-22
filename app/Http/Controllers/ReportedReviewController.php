<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportedReview;
use Exception;
use Validator;
class ReportedReviewController extends Controller
{
    protected $data;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(ReportedReview $data){
        $this->data = $data;
    }

    public function index()
    {
        return ReportedReview::all();
    }

    /**
     * Show the form for creating a new .
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
        $credentials = $request->only('reason');

        $rules = [
            'reason' => 'required'
        ];
        $validator = Validator::make($credentials,$rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()->first()],422);
        }
         $data = [
            "review_id" => $request->review_id,
            "user_id" => $request->user_id,
            "reason" => $request->reason,
            "dateReported" => $request->dateReported
        ];
        try { 
            $data = $this->data->create($data); 
            return response()->json(['msg'=>'Created'],201);
        } 
        catch(Exception $ex) {
            return response(['msg'=>'You may only send report once.'], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Show the reports the user has given
    public function show($id)
    {
        try {
            $data = $this->data->where("user_id", "=", "$id")->get();
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
        // try {
        //     $data = $this->data->find($id)->update([
        //         "review_id" => $request->review_id,
        //         "user_id" => $request->user_id,
        //         "reason" => $request->content,
        //         "dateReported" => $request->dateReported
        //     ]);
        //     $data = $this->data->where("id", "=", $id)->get();

        //     return response()->json($data,200);
        // }
        // catch(Exception $ex) {
        //     return response()->json($ex, 400);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
