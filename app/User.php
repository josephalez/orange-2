<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'id',
        'username',
        'password',
        'email',
        'name',
        'last_name',
        'last_name_2',
        'phone',
        'comuna',
        'address',
        'education_level',
        'birthday',
        'gender',
        'nationality',
        'civil_status',
        'rut',
        'assigned_to',
        'avatar',
        'role',
        'verify_token',
        'slug',
        'verifiedEmail'
    ];

    protected $hidden = ['password'];

    public function getNombreAttribute() {

      $strName = '';

      $strName .= $this->name;

      if ($this->last_name)
        $strName .= ' '.$this->last_name;

      if ($this->last_name_2)
        $strName .= ' '.$this->last_name_2;

      return $strName;

    }

    public static function slugify($string){
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
    }

    public static function createUser($request){

        $token = sha1(uniqid(date("today")).uniqid(time()));
        $token = strtoupper(substr ( $token , 1 , 8 ));

        while (User::where('verify_token','=',$token)->first()) {
          $token = sha1(uniqid(date("today")).uniqid(time()));
          $token = strtoupper(substr ( $token , 1 , 8 ));
        }

        $fullName = '';
        $fullName = (isset($request['name'])) ? $request['name'] : '';

        if (isset($request['last_name']))
          $fullName .= ' '. $request['last_name'];

        if (isset($request['last_name_2']))
          $fullName .= ' '. $request['last_name_2'];

        $slugOrigin = User::slugify($fullName);
        $slug = $slugOrigin;
        $i = 0;
        while (User::where('slug','=',$slug)->first()) {
          $i++;
          $slug = $slugOrigin.'-'.$i;
        }

        if (isset($request['role']) && $request['role'] == 'usuario'){
          $request['avatar'] = 'uploads/users/user.jpg';
        }

        if (isset($request['role']) && $request['role'] == 'ejecutivo'){
          $request['avatar'] = 'uploads/users/ejecutivo.jpg';
        }

        if (isset($request['role']) && $request['role'] == 'supervisor'){
          $request['avatar'] = 'uploads/users/supervisor.jpg';
        }

        if (isset($request['role']) && $request['role'] == 'backoffice'){
          $request['avatar'] = 'uploads/users/backoffice.jpg';
        }

        if (isset($request['role']) && $request['role'] == 'bodega'){
          $request['avatar'] = 'uploads/users/bodega.jpg';
        }

        if (isset($request['role']) && $request['role'] == 'backoffice_general'){
          $request['avatar'] = 'uploads/users/backoffice_general.jpg';
        }

        if (isset($request['role']) && $request['role'] == 'rrhh'){
          $request['avatar'] = 'uploads/users/rrhh.jpg';
        }

        if (isset($request['role']) && $request['role'] == 'mapa'){
          $request['avatar'] = 'uploads/users/mapa.jpg';
        }

        if (isset($request['role']) && $request['role'] == 'motorista'){
          $request['avatar'] = 'uploads/users/motorista.jpg';
        }

        if (isset($request['role']) && $request['role'] == 'bct'){
          $request['avatar'] = 'uploads/users/bct.jpg';
        }

        if (isset($request['role']) && $request['role'] == 'lavadora'){
          $request['avatar'] = 'uploads/users/lavadora.jpg';
        }

        if (isset($request['role']) && $request['role'] == 'admin'){
          $request['avatar'] = 'uploads/users/admin.jpg';
        }

        return User::create([
            "username" => $request["username"],
            "password" => Hash::make($request['password']),
            "email" => $request["email"],
            "name" => (isset($request['name'])) ? $request['name'] : null,
            "last_name" => (isset($request['last_name'])) ? $request['last_name'] : null,
            "last_name_2" => (isset($request['last_name_2'])) ? $request['last_name_2'] : null,
            "phone" => (isset($request['phone'])) ? $request['phone'] : null,
            "rut" => (isset($request['rut'])) ? $request['rut'] : null,
            "comuna" => (isset($request['comuna'])) ? $request['comuna'] : null,
            "address" => (isset($request['address'])) ? $request['address'] : null,
            "education_level" => (isset($request['education_level'])) ? $request['education_level'] : null,
            "birthday" => (isset($request['birthday'])) ? $request['birthday'] : null,
            "gender" => (isset($request['gender'])) ? $request['gender'] : null,
            "nationality" => (isset($request['nationality'])) ? $request['nationality'] : null,
            "civil_status" => (isset($request['civil_status'])) ? $request['civil_status'] : null,
            "assigned_to" => (isset($request['assigned_to'])) ? $request['assigned_to'] : null,
            "role" => (isset($request['role'])) ? $request['role'] : 1,
            "verifiedEmail" => (isset($request['verifiedEmail'])) ? $request['verifiedEmail'] : 0,
            "verify_token" => $token,
            'slug' => $slug,
            'avatar' => $request['avatar']
        ]);

    }

    public static function editUser($request){

      if (isset($request['user_id'])){
        $user = User::find($request['user_id']);
      }else{
        $user = Auth::user();
        $user = User::find($user->id);
      }

      if (!$user) return response()->json('User not found', 404);
      if (isset($request['avatar'])){
        $file = $request['avatar'];
        $carpetaDestino = 'uploads/users';
        $nombreArchivo = 'file_'.uniqid().'_'.$file->getClientOriginalName();
        $urlPhoto = $file->move($carpetaDestino,$nombreArchivo);
        $user->avatar = $urlPhoto;
      }
      if (isset($request['email'])) $user->email = $request['email'];
      if (isset($request['password'])) $user->password = Hash::make($request['password']);
      if (isset($request['name'])) $user->name = $request['name'];
      if (isset($request['last_name'])) $user->last_name = $request['last_name'];
      if (isset($request['last_name_2'])) $user->last_name_2 = $request['last_name_2'];
      if (isset($request['phone'])) $user->phone = $request['phone'];
      if (isset($request['rut'])) $user->rut = $request['rut'];
      if (isset($request['role'])) $user->role = $request['role'];
      if (isset($request['assigned_to'])) $user->assigned_to = $request['assigned_to'];
      if (isset($request['comuna'])) $user->comuna = $request['comuna'];
      if (isset($request['address'])) $user->address = $request['address'];
      if (isset($request['education_level'])) $user->education_level = $request['education_level'];
      if (isset($request['birthday'])) $user->birthday = $request['birthday'];
      if (isset($request['gender'])) $user->gender = $request['gender'];
      if (isset($request['nationality'])) $user->nationality = $request['nationality'];
      if (isset($request['civil_status'])) $user->civil_status = $request['civil_status'];
      $user->save();
    }

    public static function getAll($role = null,$limit = null){
      $query = DB::table('users');

      if ($role) $query->where('role','=',$role);

      if(!empty($query)){
        $data = array_map(function($user){
          return [
            "id"=>$user->id,
            "name"=>$user->name,
            "last_name"=>$user->last_name,
            "fullName"=> ($user->last_name) ? $user->name.' '.$user->last_name : $user->name,
            "role"=>$user->role,
            "slug"=>$user->slug,
            "avatar"=>$user->avatar,
          ];
        },$query->get()->toArray());
      }else{
        return [];
      }

      if (!$limit) return $data;

      return array_slice($data,0,$limit);
    }

    public static function getUser($slug){
      $query = DB::table('users')->where('slug',$slug);
      return $query->get();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }



}
