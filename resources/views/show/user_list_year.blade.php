@extends('layouts.ajax')
@section('content')
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
@endsection
