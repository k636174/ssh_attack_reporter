@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">過去24時間の時間帯別攻撃</div>

                <div class="card-body">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">今年に入っての日別攻撃</div>

                <div class="card-body">

                    <canvas id="myChart2"></canvas>

                </div>
            </div>
        </div>
    </div>
</div>



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">今年に入って最も良く使われたユーザー名とパスワードの組合せ</div>

                <div class="card-body">


                    <table border="1" style="border:1">
                        <thead>
                        <tr>
                            <td>件数</td><td>ユーザー名</td><td>パスワード</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($password_lists as $password_list)
                            <tr>
                                <td>{{ $password_list->cnt}}</td>
                                <td>{{ $password_list->username }}</td>
                                <td>{{ $password_list->password }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">今年に入って最も良く使われたユーザー名</div>

                <div class="card-body">


                    <table border="1" style="border:1">
                        <thead>
                        <tr>
                            <td>件数</td><td>ユーザー名</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user_lists as $item)
                            <tr>
                                <td>{{ $item->cnt}}</td>
                                <td>{{ $item->username }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">今年に入って最も良く使われたパスワード</div>

                <div class="card-body">


                    <table border="1" style="border:1">
                        <thead>
                        <tr>
                            <td>件数</td><td>パスワード</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pass_lists as $item)
                            <tr>
                                <td>{{ $item->cnt}}</td>
                                <td>{{ $item->password }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">直近30件のパスワードリスト<span id="refreshing" style="color:red"></span></div>
                <div class="card-body" id="recent_passlist">
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
            $("#refreshing").html("最新データ取得中");
            $("#recent_passlist").load("/ssh_attack_reporter/ajax_table",function() {
                $("#refreshing").html("");
            });
        },30000);


    };
</script>

@endsection
