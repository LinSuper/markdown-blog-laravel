<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use App\Article;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;


class LikeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function like(Request $request){
        $user = $this->user?$this->user:Auth::user();
        if(!$user){
            return [
                'status'=>0,
                'msg'=>'未登陆'
            ];
        }
        $article_id = $request->get('article_id');
        $article = Article::find($article_id);
        if(!$article){
            return [
                'status'=>0,
                'msg'=>'该文章不存在'
            ];
        }
        if($article_id){
            $user_id = $user->id;
            $item = Like::where('article_id', '=', $article_id)
                        ->where('user_id', '=', $user_id)
                        ->first();
            if($item){
                Like::where('article_id', '=', $article_id)->where('user_id', '=', $user_id)->delete();
                return [
                    'status'=>1,
                    'msg'=>'取消点赞成功'
                ];
            }else{
                $like = new Like();
                $like->user_id = $user_id;
                $like->article_id = $article_id;
                $like->save();
                return [
                    'status'=>1,
                    'msg'=>'点赞成功'
                ];
            }
        }else{
            return [
                'status'=>0,
                'msg'=>'缺少文章id'
            ];
        }
    }

}
