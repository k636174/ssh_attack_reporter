@extends('layouts.ajax')
@section('content')
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
@endsection
