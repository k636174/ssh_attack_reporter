<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Auth;
use DB;

class ShowController extends Controller
{
    //
   public function index(Request $request)
   {

        $wf_date = $request->input('fdate');
        $wt_date = $request->input('tdate');
        if(empty($wf_date)) $wf_date = date("Y-m-d").' 00:00:00';
        if(empty($wt_date)) $wt_date = date("Y-m-d").' 23:59:59';

        $password_lists =  DB::table('auth')
            ->select(DB::raw('count(*) as cnt, username, password'))
            ->groupBy('username','password')
            ->orderby('cnt','desc')
            ->limit(50)
            ->get();
            //->toSql();
            //->orderby('timestamp','desc');

        $datetime_total =  DB::table('auth')
            ->select(DB::raw('count(*) as cnt, DATE_FORMAT(timestamp, \'%Y-%m-%d %H:00:00\') AS time'))
            ->where('timestamp','>=',$wf_date)
            ->where('timestamp','<=',$wt_date)
            ->groupBy('time')
            ->orderby('timestamp','asc')
            //->limit(24)
            ->get();

        $day_total =  DB::table('auth')
            ->select(DB::raw('count(*) as cnt, DATE_FORMAT(timestamp, \'%Y-%m-%d\') AS day'))
            ->groupBy('day')
            ->orderby('timestamp','asc')
            //->limit(24)
            ->get();


        //var_dump($password_lists);
        return view('show.index', [
            'password_lists' => $password_lists,
            'datetime_total' => $datetime_total,
            'day_total' => $day_total
            ]);
    }
}
