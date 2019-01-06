@extends('layouts.ajax')
@section('content')
                    <table border="1" style="border:1">
                        <thead>
                        <tr>
                            <td>被害拠点名</td><td>ユーザー名</td><td>パスワード</td><td>タイムスタンプ</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($password_lists as $password_list)
                            <tr>
                                <td>観測拠点A<!--{{ $password_list->cnt}}--></td>
                                <td>{{ $password_list->username }}</td>
                                <td>{{ $password_list->password }}</td>
                                <td>{{ $password_list->timestamp }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
@endsection
