@extends('layouts.layout')
@section('content')
    @if(Auth::check())
        <h1>Please refer to transaction history as follows:</h1>
        <h2>email: {{ Auth::user()->email }}</h2>
        <hr>
        <ul class="text-left transactionHistory">
            @foreach ($details as $detail)
                <li>
                    <span
                        class="category badge badge-{{ ($detail->motion == 'add') ? 'primary' : 'danger' }}"> {{ ($detail->motion == 'add') ? 'Deposit' : 'Consume' }} </span> {{ $detail->created_at->addHour(8) }}
                    , {{$detail->motion}} <strong>{{$detail->amount}}</strong> points as {{$detail->item}}, and Remaining Points
                    are <strong>{{$detail->remainingPoints}}</strong> points
                </li>
            @endforeach
        </ul>

    @endif
    @guest
        <h1>Hello! Please log in your account for more services</h1>
    @endguest
@stop
