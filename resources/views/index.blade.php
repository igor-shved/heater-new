@extends('layouts.main')
@section('content')

    <div id="app">
        <menu_list></menu_list>
        <heater_list></heater_list>
    </div>

@endsection
@section('script')
    <script src="{{ mix('js/heater.js') }}"></script>
@endsection

