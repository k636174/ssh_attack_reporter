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

       date_default_timezone_set('Asia/Tokyo');
        $wf_date = $request->input('fdate');
        $wt_date = $request->input('tdate');

        if(empty($wf_date)) $wf_date = date("Y-m-d H:00:00",strtotime("-1 day"));
        if(empty($wt_date)) $wt_date =  date("Y-m-d H:00:00" );

        // ユーザー名とパスワードリスト（トップ50)
        $password_lists =  DB::table('auth')
            ->select(DB::raw('count(*) as cnt, username, password'))
            ->groupBy('username','password')
            ->orderby('cnt','desc')
            ->limit(50)
            ->get();

        // パスワードリスト（トップ50)
        $pass_lists =  DB::table('auth')
            ->select(DB::raw('count(*) as cnt, password'))
            ->groupBy('password')
            ->orderby('cnt','desc')
            ->limit(50)
            ->get();

        // ユーザー名リスト（トップ50)
        $user_lists =  DB::table('auth')
            ->select(DB::raw('count(*) as cnt, username'))
            ->groupBy('username')
            ->orderby('cnt','desc')
            ->limit(50)
            ->get();

        // 時間別攻撃件数
        $datetime_total =  DB::table('auth')
            ->select(DB::raw('count(*) as cnt, DATE_FORMAT(timestamp, \'%Y-%m-%d %H:00:00\') AS time'))
            ->where('timestamp','>=',$wf_date)
            ->where('timestamp','<=',$wt_date)
            ->groupBy('time')
            ->orderby('timestamp','asc')
            //->limit(24)
            ->get();

        // 日別攻撃件数
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
            'day_total' => $day_total,
            'pass_lists' => $pass_lists,
            'user_lists' => $user_lists
            ]);
    }

    public function user_passwd(Request $request)
    {
        // ユーザー名とパスワードリスト（トップ50)
        $password_lists =  DB::table('auth')
            ->select(DB::raw('count(*) as cnt, username, password,timestamp'))
            ->groupBy('username','password','timestamp')
            ->orderby('timestamp','desc')
            ->limit(30)
            ->get();

        return view('show.ajax', [
            'password_lists' => $password_lists
        ]);

    }

}
