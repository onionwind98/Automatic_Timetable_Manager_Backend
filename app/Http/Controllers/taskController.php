<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Timetable;
use App\Models\Timeslot;

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
            'preferredDate'=>$req->preferredDate,
            'taskColor'=>$req->taskColor
        ]);

        if($task){
            return ["Result"=>'Data saved'];
        }else{
            return ["Result"=>"Data not saved!"];
        }

    }

    public function editTask(Request $req){
        $task = Task::where('taskID',$req->taskID)
        ->update([
            'title'=>$req->title,
            'priorityLevel'=>$req->priorityLevel,
            'description'=>$req->description,
            'preferredTime'=>$req->preferredTime,
            'preferredDate'=>$req->preferredDate,
            'taskColor'=>$req->taskColor
        ]);

        if($task){
            return ["Result"=>'Data saved'];
        }else{
            return ["Result"=>"Data not saved!"];
        }
    }

    public function viewTaskEdit(Request $req){
        $task = Task::where('taskID',$req->taskID)
        ->update([
            'title'=>$req->title,
            'priorityLevel'=>$req->priorityLevel,
            'description'=>$req->description,
            'taskColor'=>$req->taskColor
        ]);

        if($task){
            return ["Result"=>'Data saved'];
        }else{
            return ["Result"=>"Data not saved!"];
        }
    }

    public function getUnassignedTask(Request $req){
        $task = Task::where('userID',$req->userID)->where('status',1)->get();
        return $task;
    }

    public function getOngoingTask(Request $req){
        $task = Task::where('userID',$req->userID)->where('status',0)->get();
        for($i=0;$i<count($task);$i++){
            $timetable = Timetable::where('userID',$req->userID)
            ->where('taskID',$task[$i]['taskID'])->get();
            $task[$i]['assignedDate']=$timetable[0]['date'];

            $startTimeslot = Timeslot::where('timeslotID',$timetable[0]['timeslotID'])->get();
            $endTimeslot = Timeslot::where('timeslotID',$timetable[count($timetable)-1]['timeslotID'])->get();
            $task[$i]['startTime']= $startTimeslot[0]['startTime'];
            $task[$i]['endTime']= $endTimeslot[0]['endTime'];
            
        }
        return $task;
    }

    public function getHistoryTask(Request $req){
        $task = Task::where('userID',$req->userID)->where('status',2)->get();
        for($i=0;$i<count($task);$i++){
            $timetable = Timetable::where('userID',$req->userID)
            ->where('taskID',$task[$i]['taskID'])->get();
            $task[$i]['assignedDate']=$timetable[0]['date'];

            $startTimeslot = Timeslot::where('timeslotID',$timetable[0]['timeslotID'])->get();
            $endTimeslot = Timeslot::where('timeslotID',$timetable[count($timetable)-1]['timeslotID'])->get();
            $task[$i]['startTime']= $startTimeslot[0]['startTime'];
            $task[$i]['endTime']= $endTimeslot[0]['endTime'];
            

            
        }
        return $task;
    }

    public function getTodaySchedule(Request $req){
        $timetableList = Timetable::where('userID',$req->userID)->where('date',$req->today)->get();
        $taskIDList=[];
        for($i=0;$i<count($timetableList);$i++){
            if(!in_array($timetableList[$i]['taskID'],$taskIDList)){
                $taskIDList[]= $timetableList[$i]['taskID'];
            }
        }
        $task = [];
        
        for($i=0;$i<count($taskIDList);$i++){
            $timetable = Timetable::where('userID',$req->userID)
            ->where('taskID',$taskIDList[$i])->get();
            $temp = Task::where('taskID',$taskIDList[$i])->get();
            $task[$i] = $temp[0];
            $task[$i]['assignedDate']=$req->today;
            // echo $task[$i];

            $startTimeslot = Timeslot::where('timeslotID',$timetable[0]['timeslotID'])->get();
            $endTimeslot = Timeslot::where('timeslotID',$timetable[count($timetable)-1]['timeslotID'])->get();
            $task[$i]['startTime']= $startTimeslot[0]['startTime'];
            $task[$i]['endTime']= $endTimeslot[0]['endTime'];
            

            
        }
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

    public function removeTaskFromTimetable(Request $request){
        $timetable=Timetable::where('userID',$request->userID)
        ->where('taskID',$request->taskID)->delete();
        $result=Task::where('taskID',$request->taskID)
        ->update([
            'status'=>1,
        ]);
        if($result){
            return ["Result"=>"Task removed!"];
        }else{
            return ["Result"=>"Data not deleted!"];
        }
    }

    public function updateTaskStatus(Request $req){
        $task = Task::where('taskID',$req->taskID)
        ->update([
            'status'=>$req->status,
        ]);

        if($task){
            return ["Result"=>'Data saved'];
        }else{
            return ["Result"=>"Data not saved!"];
        }
    }

    public function updateListOfTaskStatus(Request $req){

        for($i=0;$i<count($req->taskList);$i++){ 
            $updateTaskStatus = Task::where('taskID',$req->taskList[$i]['taskID'])
            ->update([
                'status'=>$req->taskList[$i]['updateStatus'],
            ]);
        }
        

        return 0;
    }
}
