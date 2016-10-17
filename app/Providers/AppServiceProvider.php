<?php

namespace App\Providers;

use App\User;
use App\Profile;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //用户注册后添加默认资料
        User::created(function ($user) {
            $profile = new Profile();
            $profile->image_url = "http://www.newasp.net/attachment/soft/2015/0713/085610_78002493.png";
            $profile->desc = "MARK, 简洁，舒适";
            $profile->user_id = $user->id;
            $profile->save();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
