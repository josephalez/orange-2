<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Auth;
use App\Helpers\MPage;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function paginate(Request $request){

      $events = DB::table('events')->where('trash', false)->where('for', Auth::user()->id );

      $events->select('events.*', DB::raw('concat(users.name, " ", users.last_name) as byName'))
      ->join('users', 'users.id', '=', 'events.by');

      $eventsPaginated = MPage::paginate($events, $request, 10,'','events');

      return response()->json($eventsPaginated,200);

    }
    protected function createEvent(Request $request){
        $_request = $request->all();

        $event = Event::createEvent($_request);
        if (!$event) return response()->json('Database Error',500);

        return response()->json('Event Succesfully Sended',200);
    }

    protected function getEvents(){
        $events = Event::get();
        if (!$events) return response()->json('Database Error',500);

        return $events;
    }

    protected function viewEvents(){
        $events = Event::viewEvents();
        if (!$events) return response()->json('Database Error',500);

        return response()->json('All Good',200);;
    }

    protected function eventState($id,Request $request){
        $_request = $request->all();
        $event = Event::eventState($id,$_request);
        if (!$event) return response()->json('Database Error',500);

        return response()->json('Event Succesfully Edited',200);
    }

    protected function removeEvent($id){
        $event = Event::removeEvent($id);
        if (!$event) return response()->json('Database Error',500);

        return response()->json('Event Succesfully Removed',200);
    }
}
