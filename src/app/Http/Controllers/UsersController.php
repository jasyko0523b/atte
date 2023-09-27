<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AttendanceController;
use App\Models\User;
use App\Models\Transaction;

class UsersController extends Controller
{
    public function users(){
        $users = User::paginate(10);
        return view('users', compact('users'));
    }

    public function schedule($user_id = 1){

        $user = User::find($user_id);

        $summary = Transaction::GetSummary($user_id)->get();

        $collect = collect([]);
        $collect = $this->getCollect($summary, $collect);
        $collect = $collect->sortKeys();

        $collect = $this->getTotal($collect);

        $page = AttendanceController::paginate($collect, 7, null, ['path'=> '/schedule/'.$user_id]);

        return view('schedule', compact('page','user'));
    }

    private function getCollect($summary, $collect){
        foreach($summary as $data){
            $arr=[
                'type' => $data['type'],
                'date' => $data['time']->format('Y-m-d'),
                'time' => $data['time']->format('H:i:s')
            ];
            $collect->push($arr);
        }
        return $collect->groupBy('date')->map(function ($date) {
            $record = [];
            $arr=[];
            for($i=0; $i < $date->count(); $i++){
                if($date[$i]['type'] == 0){
                    for($j=$i+1; $j < $date->count(); $j++){
                        if($date[$j]['type']==1){
                            $arr=[
                                'date' => $date[$i]['date'],
                                'type' => 'Working',
                                'start' => $date[$i]['time'],
                                'finish' => $date[$j]['time'],
                                'total_working' => strtotime($date[$j]['time']) - strtotime($date[$i]['time'])
                            ];
                            array_push($record, $arr);
                            break 1;
                        }
                    }
                }elseif($date[$i]['type'] == 2){
                    for($j=$i+1; $j < $date->count(); $j++){
                        if($date[$j]['type']==3){
                            $arr=[
                                'date' => $date[$i]['date'],
                                'type' => 'Breaking',
                                'break_start' => $date[$i]['time'],
                                'break_finish'=> $date[$j]['time'],
                                'total_break' => strtotime($date[$j]['time']) - strtotime($date[$i]['time'])
                            ];
                            array_push($record, $arr);
                            break 1;
                        }
                    }
                }
            }
            return $record;
        });
    }

    private function getTotal($collect){
        return $collect->map(function (&$date){
            $total = 0;
            $break = 0;
            $arr = $date;
            for($i=0; $i<count($date); $i++){
                if (array_key_exists('total_working', $date[$i])){
                    $total += $date[$i]['total_working'];
                }
            }
            for($i=0; $i<count($date); $i++){
                if (array_key_exists('total_break', $date[$i])){
                    $break += $date[$i]['total_break'];
                }
            }
            $total = date('H:i:s', $total-$break + strtotime('00:00:00'));
            $break = date('H:i:s', $break + strtotime('00:00:00'));
            $arr = array_merge($date, array('total' => $total, 'break' => $break));
            return $arr;
        });
    }
}
