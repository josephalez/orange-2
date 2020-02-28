<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Substate;

class SubstateController extends Controller
{
    public function get() {
      return Substate::all();
    }
}
