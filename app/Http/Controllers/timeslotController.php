<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timeslot;

class timeslotController extends Controller
{
    public function getTimeslot(){
        $timeslot = Timeslot::all();
        return $timeslot;
    }
}
