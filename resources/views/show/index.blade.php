@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">今日の時間帯別攻撃</div>

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
                    /*
                    {
                        label: 'B店 来客数',
                        data: [55, 45, 73, 75, 41, 45, 58],
                        backgroundColor: "rgba(130,201,169,0.5)"
                    },
                    {
                        label: 'C店 来客数',
                        data: [33, 45, 62, 55, 31, 45, 38],
                        backgroundColor: "rgba(255,183,76,0.5)"
                    }
                    */
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





    };
</script>

@endsection
