<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function login (Request $request) {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['name'] = $user->name;
            return response()->json(['success'=>$success],200);
        }
    }

    public function register (Request $request) {
        $validator = Validator::make($request->all(),[
            'name'=> 'required',
            'email'=> 'required',
            'password'=> 'required',
            'c_password'=> 'required|same:password',
        ]);

        $input = $request->all();
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

        return response()->json(['success'=>$success],200);
    }

    public function user () {
        $user = Auth::user();
        return response()->json(['success'=>$user],200);
    }
}
