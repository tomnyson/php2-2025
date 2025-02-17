@extends('layouts.master')

@section('content')
<h2>Cart List</h2>
@if(count($carts) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carts as $cart)
                    <tr>
                        <td>{{ $cart['sku'] }}</td>
                        <td>{{ $cart['quantity'] }}</td>
                        <td>${{ number_format($cart['price'], 2) }}</td>
                        <td>${{ number_format($cart['price'] * $cart['quantity'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Your cart is empty.</p>
    @endif
@endsection