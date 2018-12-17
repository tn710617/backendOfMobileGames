@extends('layout')
@section('content')
    @if(Auth::check())
        <h1>Hello {{ Auth::user()->name }}</span>! Welcome back </h1>
    @endif
    @if(Auth::check())
        <h1>Hello <span style="color:blue"> {{ Auth::user()->name }}</span>! Is there anything I can help?</h1>
    @endif
    @guest
        <h1>Hello! Please log in your account for more services</h1>
    @endguest
@stop
