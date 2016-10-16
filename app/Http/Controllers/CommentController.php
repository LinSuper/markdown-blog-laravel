<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Article;

class CommentController extends Controller
{
    public function store(Request $request, $id){
        $user = $this->user?$this->user:Auth::user();
        $user_id = $user->id;
        //$article_id = $request->get('article_id');
        $content = $request->get('content');
        $reply_user_id = $request->get('reply_user_id');
        $comment = new Comment();
        $comment->user_id = $user_id;
        $comment->article_id = $id;
        $comment->content = $content;
        $comment->reply_user_id = $reply_user_id;
        $comment->save();
        return [
            'status'=>1,
            'msg'=>'评论成功'
        ];
    }

    public function index(Request $request, $id){
        $article = Article::find($id);
        return $article->comment()->paginate(10);
    }
}
