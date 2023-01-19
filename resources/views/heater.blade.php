@extends('layouts.main')
@section('content')
    <div id="heater">
        <main-block></main-block>
        <room-block></room-block>
    </div>
@endsection
@section('script')
    <script src="{{ mix('js/heater.js') }}"></script>
@endsection

