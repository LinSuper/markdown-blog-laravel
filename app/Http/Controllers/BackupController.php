<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Backup;
use App\Article;
use App\Http\Requests;

class BackupController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function backup(Request $request){
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
            $item = Backup::where('article_id', '=', $article_id)
                ->where('user_id', '=', $user_id)
                ->first();
            if($item){
                Backup::where('article_id', '=', $article_id)->where('user_id', '=', $user_id)->delete();
                return [
                    'status'=>1,
                    'msg'=>'取消收藏成功'
                ];
            }else{
                $backup = new Backup();
                $backup->user_id = $user_id;
                $backup->article_id = $article_id;
                $backup->save();
                return [
                    'status'=>1,
                    'msg'=>'收藏成功'
                ];
            }
        }else{
            return [
                'status'=>0,
                'msg'=>'缺少文章id'
            ];
        }
    }

    public function index(){
        $user = $this->user?$this->user:Auth::user();
        return $user->backup()->paginate(20);
    }
}
