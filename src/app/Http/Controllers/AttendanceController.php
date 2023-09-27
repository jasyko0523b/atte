<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Transaction;

class AttendanceController extends Controller
{
    public function attendance($date = null){

        if($date == null){
            $date = date('Y-m-d');
        }

        $transactions = Transaction::with('user')->DateSearch($date)->get();

        $records=collect([]);
        $this->setRecords($transactions, $records);
        $summary = $this->getGrouped($records);

        $page = $this->paginate($summary, 5, null, ['path'=> '/attendance/'.$date]);
        return view('attendance', compact('page', 'date'));
    }


    public function paginate($items, $perPage = 1, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    private function setRecords($transactions, $records){
        foreach($transactions as $data){

            switch ($data['type']) {
                case '0':
                    $key='start';
                    break;
                case '1':
                    $key='finish';
                    break;
                case '2':
                    $key='break_start';
                    break;
                case '3':
                    $key='break_finish';
                    break;
                default:
                    $key='err';
                    break;
            }
            $record=[
                'user_id' => $data['user_id'],
                'date' => $data['time']->format('Y-m-d'),
                $key => $data['time']->format('H:i:s')
            ];
            $records->push($record);
        }
    }

    private function getGrouped($records){
        return $records->groupBy('user_id')->map(function ($users) {
            $arr=[
                'break' => 0,
                'total' => 0
            ];
            foreach($users as $user){
                if(array_key_exists('break_finish', $user)){
                    $arr['break'] += strtotime($user['break_finish']) - strtotime($arr['break_start']);
                }
                else
                {
                    $arr = array_merge($arr, $user);
                }
            }
            $arr['total'] += strtotime($arr['finish']) - strtotime($arr['start']) - $arr['break'];

            $arr['total'] = date("H:i:s", $arr['total'] + strtotime('00:00:00'));
            $arr['break'] = date("H:i:s", $arr['break'] + strtotime('00:00:00'));

            $user = User::where('id', $arr['user_id'])->first();
            $arr = array_merge($arr, ['name' => $user['name']]);
            return $arr;
        });
    }

}
