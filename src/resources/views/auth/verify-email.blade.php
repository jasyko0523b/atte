@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<div class="sendMail__content">
    <p>登録したメールアドレスを確認して下さい</p>
    <form class="sendMail-form" method="post" action="/email/verification-notification">
        @method('post')
        @csrf
        <div>
            <button class="sendMail-form__button" type="submit">確認メールを再送信</button>
        </div>
    </form>
</div>
@endsection