@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card" style="">
                <div class="card-header">過去24時間の時間帯別攻撃<span id="refreshing6" class="refreshing" style="color:red"></span></div>
                <div class="card-body">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card" style="">
                <div class="card-header">今年に入っての日別攻撃<span id="refreshing5" class="refreshing" style="color:red"></span></div>
                <div class="card-body">
                    <canvas id="myChart2"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<hr/>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card" style="">
                <div class="card-header">直近30件のパスワードリスト<span id="refreshing1" class="refreshing" style="color:red"></span></div>
                <div class="card-body" id="recent_passlist">
                    <img src="{{ asset('images/loading.gif') }}" style="width:100%" />
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" style="">
                <div class="card-header">今年に入って最も良く使われたユーザー名とパスワードの組合せ<span id="refreshing4" class="refreshing" style="color:red"></span></div>
                <div class="card-body" id="user_pass_list_year">
                    <img src="{{ asset('images/loading.gif') }}" style="width:100%" />
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card" style="">
                <div class="card-header">今年に入って最も良く使われたユーザー名<span id="refreshing3" class="refreshing" style="color:red"></span></div>
                <div class="card-body" id="user_list_year">
                    <img src="{{ asset('images/loading.gif') }}" style="width:100%" />
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card" style="">
                <div class="card-header">今年に入って最も良く使われたパスワード<span id="refreshing2" class="refreshing" style="color:red"></span></div>
                <div class="card-body" id="password_list_year">
                    <img src="{{ asset('images/loading.gif') }}" style="width:100%" />
                </div>
            </div>
        </div>
    </div>
</div>

<!-- // 追加で使うJavaScript-->
<script>


    window.onload = function(){

    	// データ再取得関数
        function refresh_data(){
  	          $(".refreshing").html("最新データ取得中");
  	          $("#recent_passlist").load("/ajax_table",function() { $("#refreshing1").html("");});
  	          $("#password_list_year").load("/password_list_year",function() { $("#refreshing2").html("");});
  	          $("#user_list_year").load("/user_list_year",function() { $("#refreshing3").html("");});
  	          $("#user_pass_list_year").load("/user_pass_list_year",function() { $("#refreshing4").html("");});
              $("#today_attack_cnt").load("/today_attack_cnt");

           	  // 今年に入っての日別攻撃件数グラフ
           	  $.ajax({
           	      type: 'GET',
           	      url: '/ajax_daily_attack',
           	      dataType: "json",
           	      success: function (result, textStatus, jqXHR)
           	      {
           	          var day_graph2 = document.getElementById("myChart2").getContext('2d');
           	          var myChart2 = new Chart(day_graph2,{
           	              type: "bar",
           	              data: {},
           	              option: {}
           	          });

           	          myChart2.data = {
           	              labels: result.labels,
           	              datasets: [
           	                  {
           	                      label: "観測拠点1",
           	                      backgroundColor : "rgba(230)",
           	                      data : result.datasets.data
           	                  }
           	              ]
           	          };
           	          myChart2.update();
           	          $("#refreshing5").html("");
           	      }
           	  });

	            // 過去24時間の攻撃集計グラフ
	            $.ajax({
	                type: 'GET',
	                url: '/ajax_datetime_total',
	                dataType: "json",
	                success: function (result, textStatus, jqXHR)
	                {
	                    var  twenty_four = document.getElementById("myChart").getContext('2d');
	                    var myChart = new Chart(twenty_four,{
	                        type: "bar",
	                        data: {},
	                        option: {}
	                    });
	
	                    myChart.data = {
	                        labels: result.labels,
	                        datasets: [
	                            {
	                                label: "観測拠点1",
	                                backgroundColor : "rgba(230)",
	                                data : result.datasets.data
	                            }
	                        ]
	                    };
	                    myChart.update();
	                    $("#refreshing6").html("");
	                }
	            });
	  	  }

        refresh_data();

        // 30秒毎に再取得
        setInterval(function(){
            refresh_data();
        },60000);

    };
</script>

@endsection
