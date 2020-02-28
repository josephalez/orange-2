<?php namespace App\Helpers;

  use Mail;

  class MailHelper {

    public static function sendMail($user,$title="",$desc="",$files=[]){
      //var_dump($desc, $title); exit();
      //esto luego tiene que ser una constante global del laravel o una vaina asi del .env
      $frontendURL = 'https://orange.g9group.cl';
        Mail::send('email.message', ['user' => $user, "title"=>$title, "description"=>$desc,"frontendURL" => $frontendURL], function ($m)
        use ($user,$files,$title) {
            foreach($files as $file){
              $m->attach($file["path"], array(
                'as' => $file["name"],
                'mime' => $file["mime"])
              );
            }//verify_token
            $m->to($user->email, $user->name)->subject($title);
         });

    }

  }

?>
