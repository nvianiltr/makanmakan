<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedArticle;
use Exception;

class SavedArticleController extends Controller
{
    protected $data;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(SavedArticle $data){
        $this->data = $data;
    }

    public function index()
    {
        return SavedArticle::all();
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
            "article_id" => $request->article_id,
            "user_id" => $request->user_id
        ];
        try { 
            $data = $this->data->create($data); 
            return response()->json(['msg'=>'Created'],201);
        } 
        catch(Exception $ex) {
            echo $ex; 
            return response('Failed', 400);
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
                ->where("saved_articles.user_id", "$id")
                ->join('articles', 'articles.id', 'saved_articles.article_id')
                ->join('users', 'users.id', '=', 'articles.user_id')
                ->select('articles.id', 'articles.title', 'articles.user_id AS user_id', 'users.username','articles.imageURL')
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
        // try {
        //     $data = $this->data->find($id)->update([
        //         "article_id" => $request->article_id,
        //         "user_id" => $request->user_id
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
    public function destroy($user_id,$article_id)
    {
        try {
            $data = $this->data
                ->where('user_id', $user_id)
                ->where('article_id',$article_id)
                ->delete();
            return response()->json(["status"=>"deleted"],201);
        }
        catch(Exception $ex) {
            return response($ex, 400);
        }
    }
}
