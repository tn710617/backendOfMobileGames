@extends('layouts.layout')
@section('content')
    @Auth
        <div>
            <H1 class="mb-4">Here are your Orders</H1>
        </div>
        <div class="card-group-container">
        @foreach($orders as $order)
            <div class="card-group">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Order Number: {{ $order->MerchantTradeNo}}</h5>
                        <p class="card-text">Item: {{ $order->ItemName}}</p>
                        <p class="card-text">Unit Price: {{ $order->UnitPrice }}</p>
                        @if ($order->Status == 1)
                            <p class="card-text">Payment Date: {{ $order->PaymentDate }}</p>

                        @endif
                        <p class="card-text">
                            Status: {{ ($order->Status == 1)
                            ? 'Paid'
                            : 'Not paid yet' }}
                        <p class="card-text">
                            <small class="text-muted">Quantity: {{ $order->Quantity }}</small>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
            </div>
    @endauth
    @guest
        <h1>Please login before any proceeding</h1>
    @endguest
@stop
