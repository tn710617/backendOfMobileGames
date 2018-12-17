@extends('layouts.layout')
@section('content')
<form class="form-signin col-12"  action="/payments" method="POST">
    @csrf()
    <h1 class="h3 mb-3 font-weight-normal">Points</h1>
    <label for="unitPrice" class="sr-only"></label>
    <input name="unitPrice" id="unitPrice" class="form-control" placeholder="How many" required autofocus>
    {{--<label for="quantity" class="sr-only">Quantity</label>--}}
    {{--<input name="quantity" id="quantity" class="form-control" placeholder="quantity" required>--}}

    <button class="btn btn-lg btn-primary btn-block" type="submit">Purchasing now</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
</form>
    @stop
