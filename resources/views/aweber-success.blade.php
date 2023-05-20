@extends('layouts.dashboard')

@section('content')

<!-- Main content -->
<div class="container">
    <h1>AWeber Accounts</h1>
    @if (!empty($accounts))
    <ul>
        @foreach ($accounts as $account)
        @if ($account !== null && isset($account['company']))
        <li>{{ $account['company'] }}</li>
        @else
        <li>{{ print_r($account) }}</li>
        @endif
        @endforeach
    </ul>
    @else
    <p>No AWeber Accounts Found</p>
    @endif
</div>

@endsection