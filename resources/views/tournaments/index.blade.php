@extends('layouts.boss')
@section('sub-title')
    All User Inventory
@endsection
@section('content')
<tournaments-index></tournaments-index>
@endsection
@section('scripts')
        <script src="https://unpkg.com/vue@2.4.2"></script>
        <script src="{{ elixir('js/app.js') }}"></script>
@endsection
