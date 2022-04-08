<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class taskController extends Controller
{
    public function addTask(Request $req){
        $task = Task::create([
            'userID'=>$req->userID,
            'title'=>$req->title,
            'priorityLevel'=>$req->priorityLevel,
            'description'=>$req->description,
            'status'=>$req->status,
            'preferredTime'=>$req->preferredTime,
            'repeatOn'=>$req->repeatOn
        ]);

        if($task){
            return ["Result"=>'Data saved'];
        }else{
            return ["Result"=>"Data not saved!"];
        }

    }

    public function getTask(){
        $task = Task::all();
        return $task;
    }

    public function deleteTask(Request $request){
        $result=Task::where('taskID',$request->taskID)->delete();
        if($result){
            return ["Result"=>"Data deleted!"];
        }else{
            return ["Result"=>"Data not deleted!"];
        }
    }
}
