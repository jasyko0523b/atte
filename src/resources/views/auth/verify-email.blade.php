@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login__content">
    <p>登録したメールアドレスを確認して下さい</p>
    <form method="post" action="/email/verification-notification">
        @method('post')
        @csrf
        <div>
            <button type="submit">確認メールを再送信</button>
        </div>
    </form>
</div>
@endsection