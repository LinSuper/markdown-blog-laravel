<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function update(Request $request)
    {
        $path = $request->file('file')->storePublicly('file');

        return [
            'url'=>$path,
            'status'=>1

        ];
    }
}
