@extends('layouts.master')
@section('title')

@endsection
@section('header')
        @include('layouts.partials.header')
@endsection
<div id="mainContent">
    @yield('content')
    <div id="app">
        
    </div>
</div>
@section('footer')
@endsection
@section('scripts')
@endsection
