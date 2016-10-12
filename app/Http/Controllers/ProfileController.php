<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function store(Request $request){
        $user = $this->user?$this->user:Auth::user();
        $profile = $user->profile()->first();
        if($profile){
            $profile->image_url = $request->get('image_url');
            $profile->desc = $request->get('desc');
            $profile->save();
        }else{
            $profile = new Profile();
            $profile->image_url = $request->get('image_url');
            $profile->desc = $request->get('desc');
            $profile->user_id = $user->id;
            $profile->save();
        }
        return [
            'status'=>1,
            'msg'=>'修改成功'
        ];

    }
}
