<?php

namespace App\Http\Controllers;

use App\Comments;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;

class CommentController extends Controller
{
    public static function store(Request $request, $sell){

        $_request = $request->all();

        $_request['sell'] = $sell;

        $validator=Validator::make($_request,[        
            'content' => 'required|string|min:1|max:500',
            'sell'    => 'required|exists:sales,id',
            'image'=>'max:5242880|mimes:png,jpg,jpeg'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        if(request()->hasFile('image')){
            request()->file('image');
            $file = request()->file('image');
            $folder = 'uploads\comments';
            $originalName = $file->getClientOriginalName();
            $filename = 'comment_'.uniqid().'_'.$originalName;
            $url = $file->move($folder,$filename);

            $_request["image"] = $url;
        }

        $_request['user'] = Auth::user()->id;
        
        $comment = Comments::createComment($_request);
        if(!$comment) return response()->json('Database Error',500);
        return response()->json('comentario creado con éxito',200);
    }

    public function getAll($sell){
        $comments = Comments::getAll($sell);
        return $comments;
    }

}
