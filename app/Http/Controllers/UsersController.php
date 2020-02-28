<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Helpers\MPage;

use App\Helpers\Request as ReqHelper;

class UsersController extends Controller
{

    protected function createUser(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users|min:2|max:24',
            'password' => 'required|string|min:5|max:48',
            'email' => 'required|string|unique:users|min:4|max:180',
            'phone' => 'string|min:10|max:16',
            'name' => 'required|string|min:2|max:24',
            'last_name' => 'required|string|min:2|max:16',
            'rut' => 'string|min:9|max:12',
            'assigned_to' => 'exists:users,id',
            'role' => 'required|in:ejecutivo,supervisor,backoffice,backoffice_general,lavadora,motorista,usuario,mapa,bodega,bct'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $_request = $request->all();

        $_request['verifiedEmail'] = 1;
        $user = User::createUser($_request);
        if(!$user) return response()->json("Database Error",500);

        return response()->json(['User Succesfully Created'],200);
    }

    protected function profileEdit(Request $request){

        $validator = Validator::make($request->all(), [
            'username' => 'string|unique:users|min:2|max:24',
            'password' => 'string|min:5|max:48',
            'email' => 'string|unique:users|min:4|max:180',
            'phone' => 'string|min:10|max:16',
            'name' => 'string|min:2|max:24',
            'last_name' => 'string|min:2|max:16',
            'last_name_2' => 'string|min:2|max:16',
            'rut' => 'string|min:9|max:12',

        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $_request = $request->all();

        //Seguridad... el usuario normal no puede modificar estas cosas
        unset($_request['user_id']);
        unset($_request['assigned_to']);
        unset($_request['slug']);
        unset($_request['verifiedEmail']);
        unset($_request['verify_token']);
        unset($_request['role']);

        $user = User::editUser($_request);

        $user = User::find(Auth::user()->id);

        return response()->json(['message' => 'Tu perfil ha sido actualizado con exito','user' => $user],200);
    }

    protected function editUserRRHH($id,Request $request){

        $validator = Validator::make($request->all(), [
            'username' => 'string|min:2|max:24',
            'password' => 'string|min:5|max:48',
            'email' => 'string|min:4|max:180',
            'phone' => 'string|min:10|max:16',
            'name' => 'string|min:2|max:24',
            'last_name' => 'string|min:2|max:16',
            'last_name_2' => 'string|min:2|max:16',
            'rut' => 'string|min:9|max:12',
            'assigned_to' => 'exists:users,id',
            'role' => 'required|in:ejecutivo,supervisor,backoffice,backoffice_general,lavadora,motorista,usuario,mapa,bodega,bct'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $_request = $request->all();
        //var_dump($_request);exit();
        $_request['user_id'] = $id;

        $user = User::editUser($_request);

        $user = User::find($id);

        return response()->json(['message' => 'User Succesfully Updated','user' => $user],200);
    }

    public function verifyEmail($verifyToken){
        $user=DB::table("users")->where("verify_token",$verifyToken);
        $currentUser = $user->first();

        if (!$currentUser) return response()->json("Token invalido!",404);

        if($currentUser->verifiedEmail==true) return response()->json("El email ya ha sido confirmado",400);

        if(!$user->update(["verifiedEmail"=>true])) return response()->json("Error al confirmar email",500);


        return response()->json($currentUser,200);
    }

    public function getAll(Request $request){
      $users = User::getAll($request->input('role'), 200);
      if (!$users) return response()->json('Error Interno del Servidor', 500);
      return $users;
    }

    public function me(){
      /*if (Auth::user()->role != 'ejecutivo' || Auth::user()->role != '' || Auth::user()->role != '' || Auth::user()->role != ''){

      }*/
      $me = DB::table('users')->where('id', Auth::user()->id )->first();

      $father = null;
      $grandfather = null;
      $childs = null;

      if ($me->role == 'ejecutivo'){

        $father = DB::table('users')->where('id', $me->assigned_to )->first();
        $grandfather = DB::table('users')->where('id', $father->assigned_to )->first();

        if(!$father) $father = null;

        if(!$grandfather) $grandfather = null;

        $grandfather = [[
          "id"=>$grandfather->id,
          "fullName"=> ($grandfather->last_name) ? $grandfather->name.' '.$grandfather->last_name : $grandfather->name,
          "role"=>$grandfather->role,
        ]];

        $father = [[
          "id"=>$father->id,
          "fullName"=> ($father->last_name) ? $father->name.' '.$father->last_name : $father->name,
          "role"=>$father->role,
        ]];

      }

      if ($me->role == 'supervisor'){
        $father = [[
          "id"=>$me->id,
          "fullName"=> ($me->last_name) ? $me->name.' '.$me->last_name : $me->name,
          "role"=>$me->role,
        ]];

        $grandfather = DB::table('users')->where('id', $me->assigned_to )->first();
        if(!$grandfather) $grandfather = null;
        $grandfather = [[
          "id"=>$grandfather->id,
          "fullName"=> ($grandfather->last_name) ? $grandfather->name.' '.$grandfather->last_name : $grandfather->name,
          "role"=>$grandfather->role,
        ]];
      }

      if ($me->role == 'backoffice'){
        $father = [
          "id"=>$me->id,
          "fullName"=> ($me->last_name) ? $me->name.' '.$me->last_name : $me->name,
          "role"=>$me->role,
        ];

        $grandfatherData = DB::table('users')->where('role', 'backoffice' );
        if(!empty($grandfatherData)) $grandfather = array_map(function($grandf){
          return [
            "id"=>$grandf->id,
            "fullName"=> ($grandf->last_name) ? $grandf->name.' '.$grandf->last_name : $grandf->name,
            "role"=>$grandf->role,
          ];
        },$grandfatherData->get()->toArray());
        if(!$grandfather) $grandfather = null;
      }

      if ($me->role == 'backoffice_general'){
        $supervisors = DB::table('users')->where('role', 'supervisor');
        $fatherData = DB::table('users')->where('role', 'backoffice')->union($supervisors);
        if(!empty($fatherData)) $father = array_map(function($fath){
          return [
            "id"=>$fath->id,
            "fullName"=> ($fath->last_name) ? $fath->name.' '.$fath->last_name : $fath->name,
            "role"=>$fath->role,
          ];
        },$fatherData->get()->toArray());
        if(!$father) $father = null;

        $grandfatherData = DB::table('users')->where('role', 'backoffice' );
        if(!empty($grandfatherData)) $grandfather = array_map(function($grandf){
          return [
            "id"=>$grandf->id,
            "fullName"=> ($grandf->last_name) ? $grandf->name.' '.$grandf->last_name : $grandf->name,
            "role"=>$grandf->role,
          ];
        },$grandfatherData->get()->toArray());
        if(!$grandfather) $grandfather = null;
      }

      if ($me->role == 'backoffice'){
        $myself = DB::table('users')->where('id', $me->id );
        $childsData =  DB::table('users')->where('assigned_to', $me->id )->union($myself);

        if(!empty($childsData)) $childs = array_map(function($child){
          return [
            "id"=>$child->id,
            "fullName"=> ($child->last_name) ? $child->name.' '.$child->last_name : $child->name,
            "role"=>$child->role,
          ];
        },$childsData->get()->toArray());
        //la cague, aqui lo cambio negrisimo pero que flojera
        $father = $childs;
      }else {

        $childsData =  DB::table('users')->where('assigned_to', $me->id );

        if(!empty($childsData)) $childs = array_map(function($child){
          return [
            "id"=>$child->id,
            "fullName"=> ($child->last_name) ? $child->name.' '.$child->last_name : $child->name,
            "role"=>$child->role,
          ];
        },$childsData->get()->toArray());

      }

      return [
          "id"=>$me->id,
          "username"=> $me->username,
          "email"=> $me->email,
          "phone"=> $me->phone,
          "comuna"=> $me->comuna,
          "address"=> $me->address,
          "education_level"=> $me->education_level,
          "birthday"=> $me->birthday,
          "gender"=> $me->gender,
          "nationality"=> $me->nationality,
          "civil_status"=> $me->civil_status,
          "rut"=> $me->rut,
          "assigned_to"=> $me->assigned_to,
          "avatar"=> $me->avatar,
          "slug"=> $me->slug,
          "name"=> $me->name,
          "last_name"=> $me->last_name,
          "last_name_2"=> $me->last_name_2,
          "fullName"=> ($me->last_name) ? $me->name.' '.$me->last_name : $me->name,
          "role"=>$me->role,
          "father"=> ($father) ? $father : null,
          "grandfather"=>  ($grandfather) ? $grandfather : null,
          "childs"=> ($childs) ? $childs : null,
      ];
    }


    public function getUser($slug){
      $user = User::getUser($slug);
      if (!$user) return response()->json('Database Error', 500);
      return $user;
    }

    public function getOne($id){
        $user = User::find($id);
        if (!$user) return response()->json('Database Error', 500);
        return [
            "id"=>$user->id,
            "name"=>$user->name,
            "last_name"=>$user->last_name,
            "fullName"=> ($user->last_name) ? $user->name.' '.$user->last_name : $user->name,
            "role"=>$user->role,
            "slug"=>$user->slug,
            "avatar"=>$user->avatar,
        ];
    }

    public function usersList(Request $request){
        /*$page = ReqHelper::Get('page',1);
        $pquery = DB::table('users');
        $pquery->select('users.*');

        /*if ( !is_null($orderby) && ($orderby == 'desc' || $orderby == 'asc'))
          $pquery->orderBy('users.'.$field, $orderby);*/

        $pquery = DB::table('users');
        $pquery->select('users.*');

        $usersList = MPage::paginate($pquery, $request);

        if(!empty($usersList)){
          $users = array_map(function($user){
            unset($user->verify_token);
            unset($user->password);

            return $user;
          },$usersList);
        }else{
          return [];
        }

        return response()->json($users,200);
    }
}
