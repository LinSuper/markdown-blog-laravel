<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Article;
use Illuminate\Support\Facades\Input;
use Validator;
use App\Http\Library\Transformer;

class ArticleController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
        parent::__construct();
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
        $user = $this->user?$this->user:Auth::user();
        if($follow){
            $followee_list = $user->followee()->get(['users.id'])->toArray();
            $followee_ids = array_column($followee_list, 'id');
            $articles = Article::whereIn('user_id', $followee_ids)->with('user')->withCount(['comment', 'like', 'backup'])
                ->orderBy('updated_at', -1)->paginate(20);
            return $articles;


        }else{
            $articles = Article::withCount(['comment', 'like', 'backup'])->with('user')
                ->orderBy('updated_at', -1)->paginate(20);
            $transfer = new Transformer($articles);
            return $transfer->transform()->json();
            return $articles;
        }
    }

    public function update(Request $request, $id){
        $user = $this->user?$this->user:Auth::user();
        if(!$user)
            return [
                'status'=>0,
                'msg'=>'无权限',
                'data'=>null
            ];
        $article = Article::find($id);
        if(!$article)
            return [
                'status'=>0,
                'msg'=>'找不到该文章',
                'data'=>null
            ];
        if($article->user_id!=$user->id)
            return [
                'status'=>0,
                'msg'=>'该用户无修改该文章的权限',
                'data'=>null
            ];
        $article->update($request->all());
        return [
            'status'=>1,
            'msg'=>'修改成功',
            'data'=>$article
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
                'msg'=>'发布失败',
                'data'=>null
            ];
        }
        $user = $this->user?$this->user:Auth::user();
        $article = new Article();
        $article->title = $request->get('title');
        $article->content = $request->get('content');
        if($user){
            $article->user_id = $user->id;
        }
        $article->save();
        return ['status' => 1, 'msg'=>'发布成功', 'data'=> $article];

    }
    public function destroy(Request $request, $id){
        $user = $this->user?$this->user:Auth::user();
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
    public function show($id){
        return [
            'status'=>1,
            'data'=>Article::with('user')->withCount(['comment', 'like', 'backup'])->find($id)
        ];
    }

    public function test(Request $request){
        return $request->all();
    }
}
