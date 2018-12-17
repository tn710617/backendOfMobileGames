@extends('layouts.layout')
@section('content')
    @if(Auth::check())
        <ul>
            <li>email: {{ Auth::user()->email }}</li>
        </ul>
    @endif
    @guest
        <h1>Hello! Please log in your account for more services</h1>
    @endguest
@stop
