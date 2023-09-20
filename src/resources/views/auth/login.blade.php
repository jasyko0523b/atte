@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login__content">
    <form class="login-form" action="/login" method="post">
        @csrf
        <h2 class="login-form__tytle">ログイン</h2>
        <div class="login-form__item">
            <input class="login-form__item--input" type="text" name="email" placeholder="メールアドレス" autocomplete="email" value="{{ old('email') }}"/>
            <p class="login-form__item--error">
            @if( $errors->has('email') )
                {{$errors->first('email')}}
            @endif
            </p>
        </div>
        <div class="login-form__item">
            <input class="login-form__item--input" type="password" name="password"  placeholder="パスワード" value="{{ old('password') }}"/>
            <p class="login-form__item--error">
                @if( $errors->has('password') )
                    {{$errors->first('password')}}
                @endif
            </p>
        </div>
        <div class="login-form__item">
            <button class="login-form__button" type="submit">ログイン</button>
        </div>
        </form>
        <div class="signin">
            <p class="signin__message">アカウントをお持ちでない方はこちらから</p>
            <a class="signin__link" href="/register">会員登録</a>
        </div>
</div>
@endsection