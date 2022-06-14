<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Timetable;
use App\Models\Timeslot;

class timetableController extends Controller
{
    public function addToTimetable(Request $req){
        //get all task in selected dateRange by userID
        $timetableInRange = Timetable::where('userID',$req->userID)
            ->whereBetween('date',[$req->dateRange[0],$req->dateRange[6]])
            ->get();

        //get all taskID involved
        $taskIDs = [];
        for($i=0; $i<count($timetableInRange); $i++){
            if(!in_array($timetableInRange[$i]['taskID'],$taskIDs)){
                $taskIDs[]=$timetableInRange[$i]['taskID'];
                sort($taskIDs);
            }
        }

        //add all task in all timetable into taskInvolved list
        $taskInvolved = [];
        for($i=0; $i<count($taskIDs); $i++){
            $task=Task::where('taskID',$taskIDs[$i])->get();
            $taskInvolved[]= $task[0];
        }

        //add new task to be rescheudle into taskInvolved list
        for($i=0; $i<count($req->taskList); $i++){
            $taskInvolved[]= $req->taskList[$i];
        }

        //delete old timetable of the selected date range
        $deleteOldTimetable = Timetable::where('userID',$req->userID)
            ->whereBetween('date',[$req->dateRange[0],$req->dateRange[6]])
            ->delete();
        
        //arrange tasks by descending order of priorityLevel
        array_multisort(array_column($taskInvolved, 'priorityLevel'), SORT_DESC, $taskInvolved);

        $this->validatePriorityLevel($taskInvolved, $req->dateRange);

        return ["Result"=>count($taskInvolved)];
    }

    private function validatePriorityLevel($taskList, $dateRange){

        for($i=0;$i<count($taskList);$i++){ 
            $updateTaskStatus = Task::where('taskID',$taskList[$i]['taskID'])
            ->update([
                'status'=>0,
            ]);

            if($taskList[$i]['priorityLevel']==5){
                $timeslotAmount=4;
                $this->allocateTimeslot($taskList[$i],$timeslotAmount,  $dateRange);
            }
            elseif($taskList[$i]['priorityLevel']==4||$taskList[$i]['priorityLevel']==3){
                
                $timeslotAmount=3;
                $this->allocateTimeslot($taskList[$i],$timeslotAmount,  $dateRange);
            }
            elseif($taskList[$i]['priorityLevel']==2||$taskList[$i]['priorityLevel']==1){
                
                $timeslotAmount=2;
                $this->allocateTimeslot($taskList[$i],$timeslotAmount,  $dateRange);
            }
        }
    }

    public function allocateTimeslot($taskList, $timeslotAmount, $dateRange){
        
        //if there is no preferred date, choose a random date
        $date='';
        if($taskList['preferredDate']==null){
            $date=$dateRange[array_rand($dateRange)];
        }else{
            $date=$taskList['preferredDate'];
        }

        $timeslot = $this->getAvailableTimeslot($taskList['userID'],$date);
        $timeslot = array_values($timeslot);


        //Get available timeslot, if not enough timeslot, forward date to next day
        $tempTimeslotList = $this->checkEnoughTimeslot($timeslot,$timeslotAmount);
        while(empty($tempTimeslotList)){
            $tempDate = explode("-",$date);
                $tempDay = (int)$tempDate[2]+1;
                $date=$tempDate[0].'-'.$tempDate[1].'-'.sprintf("%02d", $tempDay);
    
                $timeslot = $this->getAvailableTimeslot($taskList['userID'],$date);
                $timeslot = array_values($timeslot);

                $tempTimeslotList = $this->checkEnoughTimeslot($timeslot,$timeslotAmount);
        }
        $timeslot=$tempTimeslotList;
        


        $preferredTime='';
        $preferredTimeslot='';
        $availablePreferredTimeslot=[];



        //if the task has preferredTimeslot
        if(!empty(json_decode($taskList['preferredTime']))){
            $preferredTime= json_decode($taskList['preferredTime'],true);
            $temp = Timeslot::where('startTime', $preferredTime[0])->orWhere('endTime', $preferredTime[1])->get();
            if(count($temp)>1){
                $preferredTimeslot = Timeslot::whereBetween('timeslotID',[$temp[0]['timeslotID'],[$temp[1]['timeslotID']]])->get();
            }else{
                $preferredTimeslot=$temp;
            }
            
            // check for preferred timeslot availability
            for($j=0; $j<count($preferredTimeslot); $j++){ 
                for($i=0; $i<count($timeslot); $i++){ 
                    foreach($timeslot[$i] as $item){
                        if($preferredTimeslot[$j]['timeslotID']==$item['timeslotID']){
                            $availablePreferredTimeslot[]=$item;

                        }
                    }
                }
            }

            //assign task to timeslot
            //if the preferred timeslot is occupied
            if(count($availablePreferredTimeslot)==0||count($availablePreferredTimeslot)<count($preferredTimeslot)){
                $timeslot = array_values($timeslot);
                //random timeslot Set
                $random1=array_rand($timeslot);

                //remove last timeslotAmount-1 item
                $temp=$timeslot[$random1];
                $tempLength=count($temp);
                for($i=$tempLength-1;$i>=$tempLength-($timeslotAmount-1);$i--){
                    unset($temp[$i]);
                }
                
                //random starting timeslot
                $random2=array_rand($temp);

                for($i=0; $i<$timeslotAmount;$i++){
                    $timetable = Timetable::create([
                        'taskID'=>$taskList['taskID'],
                        'timeslotID'=>$timeslot[$random1][$random2+$i]['timeslotID'],
                        'userID'=>$taskList['userID'],
                        'date'=>$date,
                    ]);
                }
            }else{//if preferred timeslot is not occupied

                for($i=0; $i<count($availablePreferredTimeslot);$i++){
                    $timetable = Timetable::create([
                        'taskID'=>$taskList['taskID'],
                        'timeslotID'=>$availablePreferredTimeslot[$i]['timeslotID'],
                        'userID'=>$taskList['userID'],
                        'date'=>$date,
                    ]);
                }
            }
        }else{
            
           
            $timeslot = array_values($timeslot);
            //random timeslot Set
            $random1=array_rand($timeslot);

            //remove last timeslotAmount-1 item
            $temp=$timeslot[$random1];
            $tempLength=count($temp);
            for($i=$tempLength-1;$i>=$tempLength-($timeslotAmount-1);$i--){
                unset($temp[$i]);
            }
            
            //random starting timeslot
            $random2=array_rand($temp);

            for($i=0; $i<$timeslotAmount;$i++){
                $timetable = Timetable::create([
                    'taskID'=>$taskList['taskID'],
                    'timeslotID'=>$timeslot[$random1][$random2+$i]['timeslotID'],
                    'userID'=>$taskList['userID'],
                    'date'=>$date,
                ]);
            }
        }

    }


    public function getWeeklyTimetable(Request $req){
        $timetableList = Timetable::where('userID',$req->userID)
            ->whereBetween('date',[$req->weekDateRange[0],$req->weekDateRange[6]])
            ->get();
        $timetable = [];

        for($i = 0; $i < count($timetableList); $i++){
            $task = Task::where('taskID',$timetableList[$i]['taskID'])->get();
            
            $timetableList[$i]['taskDetails']=$task[0];
            $timetableList[$i]['taskDetails']['assignedDate']=$timetableList[$i]['date'];
            
            $taskTemp=[];
            for($j = 0; $j < count($timetableList);$j++){
                if($timetableList[$j]['taskID']==$timetableList[$i]['taskID']){
                    $taskTemp[]=$timetableList[$j]['timeslotID'];
                }
            }

            $startTimeslot = Timeslot::where('timeslotID',$taskTemp[0])->get();
            $endTimeslot = Timeslot::where('timeslotID',$taskTemp[count($taskTemp)-1])->get();
            $timetableList[$i]['taskDetails']['startTime']= $startTimeslot[0]['startTime'];
            $timetableList[$i]['taskDetails']['endTime']= $endTimeslot[0]['endTime'];
            
        }
        return $timetableList;
    }

    public function getDailyTimetable(Request $req){
        $timetableList = Timetable::where('userID',$req->userID)
            ->where('date',$req->date)->get();
        $timetable = [];

        for($i = 0; $i < count($timetableList); $i++){
            $task = Task::where('taskID',$timetableList[$i]['taskID'])->get();
            
            $timetableList[$i]['taskDetails']=$task[0];
            $timetableList[$i]['taskDetails']['assignedDate']=$timetableList[$i]['date'];
            
            $taskTemp=[];
            for($j = 0; $j < count($timetableList);$j++){
                if($timetableList[$j]['taskID']==$timetableList[$i]['taskID']){
                    $taskTemp[]=$timetableList[$j]['timeslotID'];
                }
            }

            $startTimeslot = Timeslot::where('timeslotID',$taskTemp[0])->get();
            $endTimeslot = Timeslot::where('timeslotID',$taskTemp[count($taskTemp)-1])->get();
            $timetableList[$i]['taskDetails']['startTime']= $startTimeslot[0]['startTime'];
            $timetableList[$i]['taskDetails']['endTime']= $endTimeslot[0]['endTime'];
            
        }
        return $timetableList;
    }

    private function getAvailableTimeslot($userID,$date ){
        //get available timeslot
        $timeslot=Timeslot::all()->toArray();
        $timeslotLength1 = count($timeslot);
        for($j=0; $j<$timeslotLength1; $j++){ 
            $checkAvailable = Timetable::where('timeslotID',$timeslot[$j]['timeslotID'])
                ->Where('userID', $userID)
                ->Where('date', $date)->get();

            if(count($checkAvailable)!=null){
                unset($timeslot[$j]);
            }
        }
        return $timeslot;
    }

    private function checkEnoughTimeslot($timeslot,$timeslotAmount){
        //check if there is suitable timeslot 
        $previous = $timeslot[0];
        $result = [];
        $consecutive = [];

        foreach($timeslot as $item){
            if($item['timeslotID']== $previous['timeslotID']+1){
                $consecutive[] = $item;
            }else{
                $result[]=$consecutive;
                $consecutive = array($item);
            }
            $previous = $item;
        }
        $result[]=$consecutive;
        unset($result[0]);
        $result = array_values($result);

        $resultLength=count($result);
        for($i=0;$i<$resultLength;$i++){

            if(count($result[$i])<$timeslotAmount){
                unset($result[$i]);
            }
        }
        $result = array_values($result);

        return $result;
    }
}
