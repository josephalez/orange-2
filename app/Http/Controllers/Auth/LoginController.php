<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use JWTAuth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ResponseHelper;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function enter(Request $request)
    {
        $user = null;

        $validator = Validator::make($request->all(), [
          'username' => ['required','string', 'max:32', 'min:4'],
          'password' => ['required','string','max:180', 'min:4'],
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $_request = $request->all();
        $username = $_request['username'];
        $password = $_request['password'];

        if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $username, 'password' => $password];
            Auth::attempt($credentials);
        } else {
          $credentials = ['username' => $username, 'password' => $password];
          Auth::attempt($credentials);
        }

        /*SI TE LOGRASTE LOGUEAR TE AGARRA EL USUARIO*/
        if ( Auth::check() ) $user = Auth::user();
        /*GENERAMOS EL TOKEN*/
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return ResponseHelper::dinamicError($request, 'Credenciales invalidas', 400);
            }
        } catch (JWTException $e) {
          return ResponseHelper::dinamicError($request, 'No se pudo crear el token', 500);
        }
        $verified = $user->verifiedEmail;
        if (!$verified) return response()->json('Correo no confirmado', 400);

        if(!$request->ajax()) {
          Auth::login(User::find($user['id']));
          session(['JWT' => $token]);
        }

        return response()->json(['user'=>$user,'token'=>$token]);

    }

    public function logout()
    {
      Auth::logout();
      return back();
    }

}
