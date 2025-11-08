@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Mount the Transaction Livewire component --}}
        @livewire('transaction-livewire')
    </div>
@endsection
