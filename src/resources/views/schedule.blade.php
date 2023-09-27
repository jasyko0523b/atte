@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/schedule.css') }}">
@endsection

@section('content')
<div class="schedule">
    <div class="user-select">
        @if($user['id']!=1)
            <a class="user-select__item" href='/schedule/{{ $user['id'] - 1 }}'><</a>
        @endif
        <h2 class="user-select__item">{{ $user['id'] }} : {{ $user['name'] }}</h2>
        <a class="user-select__item" href='/schedule/{{ $user['id'] + 1 }}'>></a>
    </div>
    <table class="schedule__table">
        <tr>
            <th class="schedule__table--header">日付</th>
            <th class="schedule__table--header">グラフ</th>
            <th class="schedule__table--header">勤務時間</th>
            <th class="schedule__table--header">休憩時間</th>
        </tr>
        @foreach($page as $date)
            <tr>
                <td class="schedule__table--item small">{{ $date[0]['date'] }}</td>
                <td class="schedule__table--item">
                    <svg class="graph"></svg>
                </td>
                <td class="schedule__table--item small">{{ $date['total'] }}</td>
                <td class="schedule__table--item small">{{ $date['break'] }}</td>
            <tr>
        @endforeach
            <tr>
                <td></td>
                <td><svg id="graph-info"></svg></td>
                <td></td>
                <td></td>
            <tr>
    </table>
    {{ $page->links('pagination::bootstrap-4') }}
</div>
@endsection

@section('js')
<?php $json_summary = json_encode($page->items()); ?>
<script>
    let js_summary =<?php echo $json_summary; ?>;
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://d3js.org/d3.v5.min.js"></script>
<script type="text/javascript" src="{{ asset('js/schedule.js') }}"></script>
@endsection