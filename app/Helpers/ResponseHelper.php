<?php namespace App\Helpers;

  /*
  * Esta clase sirve para hacer respuestas de manera mas ordenada (el mismo laravel ya lo hace)
  */

  use Illuminate\Http\Request;

  class ResponseHelper {

    public static function response($code = 200,$message = 'api response!'){
      http_response_code ($code);
      return $message;
    }

    public static function error($message,$errorCode = 500){
      return $this->response($errorCode,$message);
    }

    public static function success($message){
      return $this->response(200,$message);
    }

    /*
    * Si es ajax muestra un error, si no, se devuelve a otra vista y muestra el mismo error
    */

    public static function dinamicError(Request $request, $error, $code){
      if ($request->ajax())
        return response()->json($error, $code);

      return back()->withErrors([$error]);
    }

  }

?>
