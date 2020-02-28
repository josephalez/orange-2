<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Helpers\MailHelper;
use Illuminate\Foundation\Auth\RegistersUsers;
use JWTAuth;

class RegisterController extends Controller
{
    use RegistersUsers;


    protected function create(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users|min:2|max:24',
            'password' => 'required' ,'string', 'min:5', 'max:48',
            'email' => 'required|string|unique:users|min:4|max:180',
            'phone' => 'string', 'min:10', 'max:16',
            'name' => 'required', 'string', 'min:2', 'max:24',
            'last_name' => 'required', 'string', 'min:2', 'max:32',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $_request = $request->all();
        $lastname = explode(" ",$_request['last_name']);
        if(isset($lastname[0])) {
          $_request['last_name'] = $lastname[0];
        }else {
          $_request['last_name'] = null;
        };
        if(isset($lastname[1])) {
          $_request['last_name_2'] = $lastname[1];
        }else {
          $_request['last_name_2'] = null;
        };
        unset($_request['assigned_to']);
        unset($_request['role']);
        unset($_request['verifiedEmail']);

        $user = User::createUser($_request);
        if(!$user) return response()->json("Database Error",500);

        $token=JWTAuth::fromUser($user);
        if (isset($request['rrhh'])) return response()->json(['User Succesfully Created'],200);
        MailHelper::sendMail($user,"Confirmacion de Correo");

        return response()->json(['User Succesfully Created'],200);
    }
}
