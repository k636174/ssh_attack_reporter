@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">過去24時間の時間帯別攻撃</div>
                <div class="card-body">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">今年に入っての日別攻撃</div>
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
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">直近30件のパスワードリスト<span id="refreshing1" style="color:red"></span></div>
                <div class="card-body" id="recent_passlist">
                    <img src="{{ asset('images/loading.gif') }}" style="width:100%" />
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">今年に入って最も良く使われたユーザー名<span id="refreshing3" style="color:red"></span></div>
                <div class="card-body" id="user_list_year">
                    <img src="{{ asset('images/loading.gif') }}" style="width:100%" />
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">今年に入って最も良く使われたパスワード<span id="refreshing2" style="color:red"></span></div>
                <div class="card-body" id="password_list_year">
                    <img src="{{ asset('images/loading.gif') }}" style="width:100%" />
                </div>

            </div>
        </div>
    </div>
</div>


<hr/>



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">今年に入って最も良く使われたユーザー名とパスワードの組合せ<span id="refreshing4" style="color:red"></span></div>
                <div class="card-body" id="user_pass_list_year">
                    <img src="{{ asset('images/loading.gif') }}" style="width:100%" />
                </div>
            </div>
        </div>
    </div>
</div>


<!-- // 追加で使うJavaScript-->
<script>

    window.onload = function(){
        // グラフ描画
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($datetime_total as $item)
                        "{{$item->time}}",
                    @endforeach
                ],
                datasets: [
                    {
                        label: '観測拠点A',
                        backgroundColor: "rgba(130)",
                        data: [
                            @foreach($datetime_total as $item)
                            {{$item->cnt}},
                            @endforeach
                        ],
                    },
                ]
            },
        });





        var day_graph = document.getElementById("myChart2").getContext('2d');
        var myChart = new Chart(day_graph, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($day_total as $item)
                        "{{$item->day}}",
                    @endforeach
                ],
                datasets: [
                    {
                        label: '観測拠点A',
                        backgroundColor: "rgba(230)",
                        data: [
                            @foreach($day_total as $item)
                            {{$item->cnt}},
                            @endforeach
                        ]
                    }
                ]
            },
        });

        $("#recent_passlist").load("/ssh_attack_reporter/ajax_table");
        setInterval(function(){
            $("#refreshing1").html("最新データ取得中");
            $("#recent_passlist").load("/ssh_attack_reporter/ajax_table",function() {
                $("#refreshing1").html("");
            });
        },30000);

        $("#password_list_year").load("/ssh_attack_reporter/password_list_year");
        setInterval(function(){
            $("#refreshing2").html("最新データ取得中");
            $("#password_list_year").load("/ssh_attack_reporter/password_list_year",function() {
                $("#refreshing2").html("");
            });
        },30000);

        $("#user_list_year").load("/ssh_attack_reporter/user_list_year");
        setInterval(function(){
            $("#refreshing3").html("最新データ取得中");
            $("#user_list_year").load("/ssh_attack_reporter/user_list_year",function() {
                $("#refreshing3").html("");
            });
        },30000);

        $("#user_pass_list_year").load("/ssh_attack_reporter/user_pass_list_year");
        setInterval(function(){
            $("#refreshing4").html("最新データ取得中");
            $("#user_pass_list_year").load("/ssh_attack_reporter/user_pass_list_year",function() {
                $("#refreshing4").html("");
            });
        },300000);


    };
</script>

@endsection
