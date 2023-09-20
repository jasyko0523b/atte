@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<div class="summary">
    <div class="date-select">
        <a class="date-select__item" href='/attendance/{{ date('Y-m-d', strtotime($date.'-1 day')) }}'><</a>
        <h2 class="date-select__item">{{ $date }}</h2>
        <a class="date-select__item" href='/attendance/{{ date('Y-m-d', strtotime($date.'+1 day')) }}'>></a>
    </div>
    <table class="summary__table">
        <tr>
            <th class="summary__table--header">名前</th>
            <th class="summary__table--header">勤務開始</th>
            <th class="summary__table--header">勤務終了</th>
            <th class="summary__table--header">休憩時間</th>
            <th class="summary__table--header">勤務時間</th>
        </tr>
        @foreach($page as $user)
            <tr>
                <td class="summary__table--item">{{ $user['name']}}</td>
                <td class="summary__table--item">{{ $user['start'] }}</td>
                <td class="summary__table--item">{{ $user['finish'] }}</td>
                <td class="summary__table--item">{{ $user['break'] }}</td>
                <td class="summary__table--item">{{ $user['total'] }}</td>
            <tr>
        @endforeach
    </table>
    {{ $page->links('pagination::bootstrap-4') }}
</div>
@endsection
