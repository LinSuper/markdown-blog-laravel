<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Article;
use Validator;

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

    public function index(Request $request){
        $follow = $request->get('follow', 0);
        if($follow){

        }
    }

    public function update(Request $request, $id){
        $user = Auth::user();
        if(!$user)
            return [
                'status'=>0,
                'msg'=>'无权限'
            ];
        $article = Article::find($id);
        if(!$article)
            return [
                'status'=>0,
                'msg'=>'找不到该文章'
            ];
        if($article->user_id!=$user->id)
            return [
                'status'=>0,
                'msg'=>'该用户无修改该文章的权限'
            ];
        $article->update($request->all());
        return [
            'status'=>1,
            'msg'=>'修改成功'
        ];
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status'=>0,
                'msg'=>'发布失败'
            ];
        }
        $user = Auth::user();
        $article = new Article();
        $article->title = $request->get('title');
        $article->content = $request->get('content');
        if($user){
            $article->user_id = $user->id;
        }
        $article->save();
        return ['status' => 1, 'msg'=>'发布成功'];

    }
    public function del(Request $request, $id){
        $user = Auth::user();
        $article = Article::find($id);
        if(!$article)
            return [
                'status'=>0,
                'msg'=>'找不到对应资源'
            ];
        if($user->id!=$article->user_id)
            return [
                'status'=>0,
                'msg'=>'无权限'
            ];
        $article->delete();
        return [
            'status'=>1,
            'msg'=>'删除成功'
        ];
    }
}
