<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Relation;

class RelationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function follow(Request $request){
        $user = Auth::user();
        $user_id = $request->get('user_id', null);
        if($user && $user_id){
            $item = Relation::where('user_id', '=', $user->id)->where('follow_id', '=', $user_id)->first();
            if($item){
                return [
                    'status'=>0,
                    'msg'=>'已经关注'
                ];
            }

            else{
                $relation = new Relation();
                $relation->user_id = $user->id;
                $relation->follow_id = $user_id;
                $relation->save();
                return [
                    'status'=>1,
                    'msg'=>'关注成功'
                ];
            }

        }
        return [
            'status'=>0,
            'msg'=>'操作失败'
        ];
    }

    public function unfollow(Request $request){
        $user_id = $request->get('user_id', -1);
        $user = Auth::user();
        $user->follower()->detach($user_id);
        return [
            'status'=>1,
            'msg'=>'操作成功'
        ];
    }
}
