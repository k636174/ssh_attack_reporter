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
        return view('show.index');
   }

    public function user_passwd(Request $request)
    {
        // ユーザー名とパスワードリスト（トップ50)
        date_default_timezone_set('Asia/Tokyo');
        $password_lists =  DB::table('auth')
            ->select(DB::raw('count(*) as cnt, username, password,timestamp'))
            ->where('timestamp','>',date("Y-m-d H:00:00",strtotime("-1 day")))
            ->groupBy('username','password','timestamp')
            ->orderby('timestamp','desc')
            ->limit(30)
            ->get();

        return view('show.ajax', [
            'password_lists' => $password_lists
        ]);

    }

    public function password_list_year(Request $request)
    {
        // パスワードリスト（トップ50)
        $pass_lists =  DB::table('auth')
            ->select(DB::raw('count(*) as cnt, password'))
            ->groupBy('password')
            ->orderby('cnt','desc')
            ->limit(30)
            ->get();

        return view('show.password_list_year', [
            'pass_lists' => $pass_lists
        ]);

    }

    public function user_list_year(Request $request)
    {
        // ユーザー名リスト（トップ50)
        $user_lists =  DB::table('auth')
            ->select(DB::raw('count(*) as cnt, username'))
            ->groupBy('username')
            ->orderby('cnt','desc')
            ->limit(30)
            ->get();

        return view('show.user_list_year', [
            'user_lists' => $user_lists
        ]);

    }

    public function user_pass_list_year(Request $request)
    {
        // ユーザー名とパスワードリスト（トップ50)
        $password_lists =  DB::table('auth')
            ->select(DB::raw('count(*) as cnt, username, password'))
            ->groupBy('username','password')
            ->orderby('cnt','desc')
            ->limit(30)
            ->get();


        return view('show.user_pass_list_year', [
            'password_lists' => $password_lists
        ]);


    }

    public function ajax_daily_attack(Request $request)
    {
        // 日別攻撃件数
        $day_total =  DB::table('auth')
            ->select(DB::raw('count(*) as cnt, DATE_FORMAT(timestamp, \'%Y-%m-%d\') AS day'))
            ->groupBy('day')
            ->orderby('timestamp','asc')
            //->limit(24)
            ->get();

        $tmp_arr_cnt = array();
        $tmp_arr_day = array();
        foreach($day_total as $item){
            //$tmp_arr_cnt[] = '"'.$item->cnt.'"';
            $tmp_arr_cnt[] = $item->cnt;
            $tmp_arr_day[] = $item->day;
        }

        return response()->json(
                array(
                //'data' => array(
                    //'labels' => array(implode($tmp_arr_day,",")),
                    'labels' => $tmp_arr_day,
                    'datasets' => array(
                        'label' => 'hogehoge',
                        'data' =>  $tmp_arr_cnt,
                        'backgroundColor'=>'rgba(230)',
                        //'data' =>  array(implode($tmp_arr_cnt,","))
                        //'data' =>  implode($tmp_arr_cnt,",")
                        //'data' =>  $tmp_arr_cnt
                    )
                )
        );

    }


    public function ajax_datetime_total(Request $request)
    {

        date_default_timezone_set('Asia/Tokyo');
        $wf_date = $request->input('fdate');
        $wt_date = $request->input('tdate');

        if(empty($wf_date)) $wf_date = date("Y-m-d H:00:00",strtotime("-1 day"));

        // 時間別攻撃件数
        $datetime_total =  DB::table('auth')
            ->select(DB::raw('count(*) as cnt, DATE_FORMAT(timestamp, \'%Y-%m-%d %H:00:00\') AS time'))
            ->where('timestamp','>=',$wf_date)
            ->groupBy('time')
            ->orderby('timestamp','asc')
            ->get();

        $tmp_arr_cnt = array();
        $tmp_arr_time = array();
        foreach($datetime_total as $item){
            $tmp_arr_cnt[] = $item->cnt;
            $tmp_arr_time[] = $item->time;
        }

        return response()->json(
            array(
                'labels' => $tmp_arr_time,
                'datasets' => array(
                    'label' => 'hogehoge',
                    'data' =>  $tmp_arr_cnt,
                    'backgroundColor'=>'rgba(230)'
                )
            )
        );
    }

    public function today_attack_cnt(){
        date_default_timezone_set('Asia/Tokyo');


        $result_data =  DB::table('auth')
            ->select(DB::raw('count(*) as cnt'))
            ->where('timestamp','>=',date("Y-m-d"))
            ->get();

        foreach($result_data as $item){
            $tmp_arr_cnt[] = $item->cnt;
        }

            echo date("Y-m-d")."の辞書攻撃件数は：".$tmp_arr_cnt[0].'です';exit;
    }

    public function last_attack_datetime(){
        date_default_timezone_set('Asia/Tokyo');
        $result_data =  DB::table('auth')
            ->select(DB::raw('timestamp'))
            ->orderby('timestamp','desc')
	    ->limit(1)
            ->get();
	echo $result_data[0]->timestamp;
    }

}
