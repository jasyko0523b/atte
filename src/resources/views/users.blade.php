@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endsection

@section('content')
<div class="users">
    <table class="users__table">
        <tr>
            <th class="users__table--header">ID</th>
            <th class="users__table--header">名前</th>
            <th class="users__table--header">メールアドレス</th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td class="users__table--item">{{ $user['id']}}</td>
                <td class="users__table--item">{{ $user['name'] }}</td>
                <td class="users__table--item">{{ $user['email'] }}</td>
                <td class="users__table--item">
                    <a href="/schedule/{{ $user['id']}}" class="schedule-link">勤怠一覧へ</a>
                </td>
            <tr>
        @endforeach
    </table>
    {{ $users->links('pagination::bootstrap-4') }}
</div>
@endsection
