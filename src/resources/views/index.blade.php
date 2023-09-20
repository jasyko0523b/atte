@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="timestamp__content">
    <form class="timestamp-form" action="/" method="post">
        @csrf
        <h2 class="timestamp-form__tytle">{{ $user['name'] }}さんお疲れ様です！</h2>
        <div class="timestamp-form__wrapper">
            <button class="timestamp-form__button" type="submit" value="0" name="type" id="start">勤務開始</button>
            <button class="timestamp-form__button" type="submit" value="1" name="type" id="finish">勤務終了</button>
            <button class="timestamp-form__button" type="submit" value="2" name="type" id="break_start">休憩開始</button>
            <button class="timestamp-form__button" type="submit" value="3" name="type" id="break_finish">休憩終了</button>
        </div>
    </form>
</div>
@endsection

@section('js')
<script>
    let js_type =<?php echo $type; ?>;
</script>
<script type="text/javascript" src="{{ asset('js/buttonDisabled.js') }}"></script>
@endsection