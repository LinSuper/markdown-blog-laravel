<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Relation;
use App\User;

class RelationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function follow(Request $request){
        $user = $this->user?$this->user:Auth::user();
        $user_id = $request->get('user_id', null);
        $person = User::find($user_id);
        if(!$person){
            return [
                'status'=>0,
                'msg'=>'找不到对应的用户'
            ];
        }
        if($user and $user_id){
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
        $user = $this->user?$this->user:Auth::user();
        $user->followee()->detach($user_id);
        return [
            'status'=>1,
            'msg'=>'操作成功'
        ];
    }

    public function followerList(Request $request){
        $user = $this->user?$this->user:Auth::user();
        $res = $user->follower()->with('profile')->paginate(20);
        return $res;
    }

    public function followeeList(Request $request){
        $user = $this->user?$this->user:Auth::user();
        $res = $user->followee()->with('profile')->paginate(20);
        return $res;
    }
}
