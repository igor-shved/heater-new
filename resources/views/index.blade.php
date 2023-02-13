@extends('layouts.main')
@section('content')

    <div id="app">
        <menu_block></menu_block>
        <heater_block></heater_block>
    </div>

@endsection
@section('script')
    <script src="{{ mix('js/heater.js') }}"></script>
@endsection

