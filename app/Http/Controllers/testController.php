<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timeslot;
use App\Models\Task;
use App\Models\Timetable;

class testController extends Controller
{
    public function test(Request $req){
        // $temp=Task::all();
        // for($i=0; $i<count($temp);$i++){
        //     $task=Task::where('taskID',$temp[$i]['taskID'])
        //     ->update([
        //         'status'=>1
        //     ]);
        // }

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
            // echo $task[$i];

            if($task[$i]['priorityLevel']==5){
                $startTimeslot = Timeslot::where('timeslotID',$timetable[0]['timeslotID'])->get();
                $endTimeslot = Timeslot::where('timeslotID',$timetable[3]['timeslotID'])->get();
                $task[$i]['startTime']= $startTimeslot[0]['startTime'];
                $task[$i]['endTime']= $endTimeslot[0]['endTime'];
            }
            elseif($task[$i]['priorityLevel']==4||$task[$i]['priorityLevel']==3){
                $startTimeslot = Timeslot::where('timeslotID',$timetable[0]['timeslotID'])->get();
                $endTimeslot = Timeslot::where('timeslotID',$timetable[2]['timeslotID'])->get();
                $task[$i]['startTime']= $startTimeslot[0]['startTime'];
                $task[$i]['endTime']= $endTimeslot[0]['endTime'];
            }
            elseif($task[$i]['priorityLevel']==2||$task[$i]['priorityLevel']==1){
                $startTimeslot = Timeslot::where('timeslotID',$timetable[0]['timeslotID'])->get();
                $endTimeslot = Timeslot::where('timeslotID',$timetable[1]['timeslotID'])->get();
                $task[$i]['startTime']= $startTimeslot[0]['startTime'];
                $task[$i]['endTime']= $endTimeslot[0]['endTime'];
            }

            
        }
        return $task;

        // $timeslot=Timeslot::all()->toArray();
        // for($i=0; $i<count($timeslot);$i++){
        //     if($timeslot[$i]['timeslotID']==46||$timeslot[$i]['timeslotID']==47||$timeslot[$i]['timeslotID']==48){
        //         unset($timeslot[$i]);
        //     }
        // }
        // $timeslot = array_values($timeslot);
        // $randomTimeslot=array_rand($timeslot);

        // return $randomTimeslot;

        // $task = Task::where('userID',1)->where('status',0)->get();
        // for($i=0;$i<count($task);$i++){
        //     $timetable = Timetable::where('userID',1)
        //     ->where('taskID',$task[$i]['taskID'])->get();
        //     $task[$i]['assignedDate']=$timetable[0]['date'];

        //     if($task[$i]['priorityLevel']==5){
        //         $startTimeslot = Timeslot::where('timeslotID',$timetable[0]['timeslotID'])->get();
        //         $endTimeslot = Timeslot::where('timeslotID',$timetable[3]['timeslotID'])->get();
        //         $task[$i]['startTime']= $startTimeslot[0]['startTime'];
        //         $task[$i]['endTime']= $endTimeslot[0]['endTime'];
        //     }
        //     elseif($task[$i]['priorityLevel']==4||$task[$i]['priorityLevel']==3){
        //         $startTimeslot = Timeslot::where('timeslotID',$timetable[0]['timeslotID'])->get();
        //         $endTimeslot = Timeslot::where('timeslotID',$timetable[2]['timeslotID'])->get();
        //         $task[$i]['startTime']= $startTimeslot[0]['startTime'];
        //         $task[$i]['endTime']= $endTimeslot[0]['endTime'];
        //     }
        //     elseif($task[$i]['priorityLevel']==2||$task[$i]['priorityLevel']==1){
        //         $startTimeslot = Timeslot::where('timeslotID',$timetable[0]['timeslotID'])->get();
        //         $endTimeslot = Timeslot::where('timeslotID',$timetable[1]['timeslotID'])->get();
        //         $task[$i]['startTime']= $startTimeslot[0]['startTime'];
        //         $task[$i]['endTime']= $endTimeslot[0]['endTime'];
        //     }

            
        // }
        // return $task;
    }
}
