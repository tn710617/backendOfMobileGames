@extends('layouts.layout')
@section('content')
    @if(Auth::check())
        <h1>Please refer to transaction history as follows:</h1>
            <h2>email: {{ Auth::user()->email }}</h2>
        <hr>
        @foreach ($details as $detail)
            <ul>
               <li>{{ $detail->created_at }}, {{$detail->motion}} {{$detail->amount}} points as {{$detail->item}}, and Remaining Points are  {{$detail->remainingPoints}} points </li>
            </ul>

            @endforeach

    @endif
    @guest
        <h1>Hello! Please log in your account for more services</h1>
    @endguest
@stop
