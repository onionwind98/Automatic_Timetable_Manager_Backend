<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timeslot;
use App\Models\Task;
use App\Models\Timetable;

class testController extends Controller
{
    public function test(Request $req){
        // // if there is enough timeslot available for the day
        // $timeslot=Timeslot::all()->toArray();
        // $timeslotLength1 = count($timeslot);
        // for($j=0; $j<$timeslotLength1; $j++){ 
        //     $checkAvailable = Timetable::where('timeslotID',$timeslot[$j]['timeslotID'])
        //         ->Where('userID', 1)
        //         ->Where('date', '2022-06-13')->get();

        //     if(count($checkAvailable)!=null){
        //         unset($timeslot[$j]);
        //     }
        // }
        // $timeslot = array_values($timeslot);

        // //check if there is suitable timeslot 
        // $previous = $timeslot[0];
        // $result = [];
        // $consecutive = [];

        // foreach($timeslot as $item){
        //     if($item['timeslotID']== $previous['timeslotID']+1){
        //         $consecutive[] = $item;
        //     }else{
        //         $result[]=$consecutive;
        //         $consecutive = array($item);
        //     }
        //     $previous = $item;
        // }
        // $result[]=$consecutive;
        // unset($result[0]);
        // $result = array_values($result);

        // $timeslotAmount=3;
        // $resultLength=count($result);
        // for($i=0;$i<$resultLength;$i++){
        //     foreach($result[$i] as $test){
        //     }
        //     if(count($result[$i])<$timeslotAmount){
        //         unset($result[$i]);
        //     }
        // }
        // $result = array_values($result);



        // // return $result;
        // if (empty($result)){
        //     return 'No suitable timeslot today';
        // }else{
        //     //first timeslot Set
        //     $random1=array_rand($result);
        //     //remove last timeslotAmount-1 item
        //     $temp=$result[$random1];
        //     $tempLength=count($temp);
        //     for($i=$tempLength-1;$i>=$tempLength-($timeslotAmount-1);$i--){
        //         unset($temp[$i]);
        //     }
        //     //random starting timeslot
        //     $random2=array_rand($temp);

        //     $final=[];
        //     for($i=0;$i<$timeslotAmount;$i++){
        //         $final[]= $result[$random1][$random2+$i];
        //     }
        //     return $result;
        // }
        



        // $timeslotLength2 = count($timeslot);
        // for($i=0; $i<$timeslotLength2;$i++){
        //     if($timeslot[$i]['timeslotID']==46||$timeslot[$i]['timeslotID']==47||$timeslot[$i]['timeslotID']==48){

        //         unset($timeslot[$i]);
        //     }
        // }
        // $timeslot = array_values($timeslot);

        // for($i=0; $i<count($timeslot);$i++){
        //     echo $i;
        //     if($timeslot[$i]['timeslotID']==46||$timeslot[$i]['timeslotID']==47||$timeslot[$i]['timeslotID']==48){
        //         unset($timeslot[$i]);
        //     }
        // }
        // $random=array_rand($timeslot,3);
        // echo implode(" ",$random);
        // $timeslotAmount=3;
        // for($i=0;$i<$timeslotAmount;$i++){
        //     echo $timeslot[$random+$i]['timeslotID'];
        // }
        

        $temp=Task::where('userID',1)->get();
        for($i=0; $i<count($temp);$i++){
            $task=Task::where('taskID',$temp[$i]['taskID'])
            ->update([
                'status'=>1
            ]);
        }

        // $tempDate = explode("-",'2022-06-06');
        // $tempDay = (int)$tempDate[2]+1;
        // $date=$tempDate[0].'-'.$tempDate[1].'-'.sprintf("%02d", $tempDay);
        // return $date;

        // $timetableList = Timetable::where('userID',$req->userID)->where('date',$req->today)->get();
        // $taskIDList=[];
        // for($i=0;$i<count($timetableList);$i++){
        //     if(!in_array($timetableList[$i]['taskID'],$taskIDList)){
        //         $taskIDList[]= $timetableList[$i]['taskID'];
        //     }
        // }
        // $task = [];
        
        // for($i=0;$i<count($taskIDList);$i++){
        //     $timetable = Timetable::where('userID',$req->userID)
        //     ->where('taskID',$taskIDList[$i])->get();
        //     $temp = Task::where('taskID',$taskIDList[$i])->get();
        //     $task[$i] = $temp[0];
        //     // echo $task[$i];

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

// public function allocateTimeslot($taskList, $timeslotAmount, $dateRange){
        
//     //if there is no preferred date, choose a random date
//     $date='';
//     if($taskList['preferredDate']==null){
//         $date=$dateRange[array_rand($dateRange)];
//     }else{
//         $date=$taskList['preferredDate'];
//     }

//     // get available timeslot
//     // $timeslot=Timeslot::all()->toArray();
//     // $timeslotLength1 = count($timeslot);
//     // for($j=0; $j<$timeslotLength1; $j++){ 
//     //     $checkAvailable = Timetable::where('timeslotID',$timeslot[$j]['timeslotID'])
//     //         ->Where('userID', $taskList['userID'])
//     //         ->Where('date', $date)->get();

//     //     if(count($checkAvailable)!=null){
//     //         unset($timeslot[$j]);
//     //     }
//     // }

//     $timeslot = $this->getAvailableTimeslot($taskList['userID'],$date);
//     $timeslot = array_values($timeslot);

//     // if there is enough timeslot available for the day
//     // while(count($timeslot)<$timeslotAmount){
//     //     $tempDate = explode("-",$date);
//     //     $tempDay = (int)$tempDate[2]+1;
//     //     $date=$tempDate[0].'-'.$tempDate[1].'-'.sprintf("%02d", $tempDay);

//     //     $timeslot = $this->getAvailableTimeslot($taskList['userID'],$date);
//     //     $timeslot = array_values($timeslot);
//     // }


//     //TESTINGGGGGGGGG
//     $tempTimeslotList = $this->checkEnoughTimeslot($timeslot);
//     while(empty($tempTimeslotList)){
//         $tempDate = explode("-",$date);
//             $tempDay = (int)$tempDate[2]+1;
//             $date=$tempDate[0].'-'.$tempDate[1].'-'.sprintf("%02d", $tempDay);

//             $timeslot = $this->getAvailableTimeslot($taskList['userID'],$date);
//             $timeslot = array_values($timeslot);

//             $tempTimeslotList = $this->checkEnoughTimeslot($timeslot);
//     }
//     $timeslot=$tempTimeslotList;
//     //TESTINGGGGGGGGG


//     $preferredTime='';
//     $preferredTimeslot='';
//     $availablePreferredTimeslot=[];



//     //if the task has preferredTimeslot
//     if(!empty(json_decode($taskList['preferredTime']))){
//         $preferredTime= json_decode($taskList['preferredTime'],true);
//         $temp = Timeslot::where('startTime', $preferredTime[0])->orWhere('endTime', $preferredTime[1])->get();
//         if(count($temp)>1){
//             $preferredTimeslot = Timeslot::whereBetween('timeslotID',[$temp[0]['timeslotID'],[$temp[1]['timeslotID']]])->get();
//         }else{
//             $preferredTimeslot=$temp;
//         }
        
//         // check for preferred timeslot availability
//         for($j=0; $j<count($preferredTimeslot); $j++){ 
//             // $checkAvailable = Timetable::where('timeslotID',$preferredTimeslot[$j]['timeslotID'])
//             // ->Where('userID', $taskList['userID'])
//             // ->Where('date', $date)->get();
//             for($i=0; $i<count($timeslot); $i++){ 
//                 if(array_key_exists($i,$timeslot)){
//                     if($preferredTimeslot[$j]['timeslotID']==$timeslot[$i]['timeslotID']){
//                         $availablePreferredTimeslot[]=$timeslot[$i];
//                     }
//                 }
//             }
//         }

//         //assign task to timeslot
//         //if the preferred timeslot is occupied

//         if(count($availablePreferredTimeslot)==0||count($availablePreferredTimeslot)<$timeslotAmount){
//             //exclude timslot id 46-48 for random assignment of task
//             $timeslotLength=count($timeslot);
//             for($i=0; $i<$timeslotLength;$i++){
//                 if($timeslot[$i]['timeslotID']==46||$timeslot[$i]['timeslotID']==47||$timeslot[$i]['timeslotID']==48){
//                     unset($timeslot[$i]);
//                 }
//             }

//             // $temp=[];
//             // for($i=0; $i<count($timeslot);$i++){
//             //     // echo $i;
//             //     echo count($timeslot);
//             // }

//             $timeslot = array_values($timeslot);
//             $randomTimeslotKey=array_rand($timeslot);
//             for($i=0; $i<$timeslotAmount;$i++){
//                 $timetable = Timetable::create([
//                     'taskID'=>$taskList['taskID'],
//                     'timeslotID'=>$timeslot[$randomTimeslotKey+$i]['timeslotID'],
//                     'userID'=>$taskList['userID'],
//                     'date'=>$date,
//                 ]);
//             }
//         }else{//if preferred timeslot is not occupied

//             for($i=0; $i<$timeslotAmount;$i++){
//                 $timetable = Timetable::create([
//                     'taskID'=>$taskList['taskID'],
//                     'timeslotID'=> $availablePreferredTimeslot[$i]['timeslotID'],
//                     'userID'=>$taskList['userID'],
//                     'date'=>$date,
//                 ]);
//             }
//         }
//     }else{
//         //exclude timeslot id 46-48 for random assignment of task
//         $timeslotLength=count($timeslot);
//         for($i=0; $i<$timeslotLength;$i++){
//             if($timeslot[$i]['timeslotID']==46||$timeslot[$i]['timeslotID']==47||$timeslot[$i]['timeslotID']==48){
//                 unset($timeslot[$i]);
//             }
//         }

//         // $temp=[];
//         // for($i=0; $i<count($timeslot);$i++){
//         //     echo count($timeslot);
//         // }

//         $timeslot = array_values($timeslot);
//         $randomTimeslotKey=array_rand($timeslot);
//         for($i=0; $i<$timeslotAmount;$i++){
//             $timetable = Timetable::create([
//                 'taskID'=>$taskList['taskID'],
//                 'timeslotID'=>$timeslot[$randomTimeslotKey+$i]['timeslotID'],
//                 'userID'=>$taskList['userID'],
//                 'date'=>$date,
//             ]);
//         }
//     }

// }