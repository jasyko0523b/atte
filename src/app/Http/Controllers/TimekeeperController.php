<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Auth;

class TimekeeperController extends Controller
{
    public function index(){
        $user = Auth::user();
        $section = Transaction::getLastSection($user['id'])->get();
        if(!$section->isEmpty()){
            $type = $section[0]['type'];
        }else{
            $type = 1;
        }
        return view('index', compact('user', 'type'));
    }

    public function store(Request $request){
        $id = (string)Auth::id();
        $type = $request['type'];
        $transaction=[
            "user_id" => $id,
            "type" => $type,
            "time" => date('Y-m-d H:i:s')
        ];
        Transaction::create($transaction);
        return redirect('/');
    }

}
