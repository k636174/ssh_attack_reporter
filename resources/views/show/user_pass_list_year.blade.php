@extends('layouts.ajax')
@section('content')
    <table border="1" style="border:1">
        <thead>
        <tr>
            <td>件数</td><td>ユーザー名</td><td>パスワード</td>
        </tr>
        </thead>
        <tbody>
        @foreach($password_lists as $item)
            <tr>
                <td style="font-color:#59f5ff">{{ $item->cnt}}</td>
                <td style="font-color:#59f5ff">{{ $item->username }}</td>
                <td style="font-color:#59f5ff">{{ $item->password }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
