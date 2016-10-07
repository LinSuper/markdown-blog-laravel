<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Article;

class ArticleController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function home(Request $request, $id=null){

        if($id){
            $article = Article::find($id);
            if(!$article)
                return abort(404);
            //if($article->user_id)
            return view('article.write', [
                'article'=>$article
            ]);
        }else{
            return view('article.write', [
                'article'=>null
            ]);
        }


    }
    public function update(Request $request, $id){
        return abort(403);
    }

    public function add(Request $request){
        $user = Auth::user();
        $article = new Article();
        $article->title = $request->get('title');
        $article->content = $request->get('content');
        if($user){
            $article->user_id = $user->id;
        }
        $article->save();
        return redirect('/home');

    }
}
