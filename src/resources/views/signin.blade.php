@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/signin.css') }}">
@endsection

@section('content')
<div class="signin__content">
    <form class="signin-form" action="/confirm" method="post">
        @csrf
        <h2 class="signin-form__tytle">会員登録</h2>
        <div class="signin-form__item">
            <input class="signin-form__item--input" type="text" name="name" placeholder="名前" autocomplete="name" value="{{ old('name') }}"/>
            <p class="signin-form__item--error">
            @if( $errors->has('name') )
                {{$errors->first('name')}}
            @endif
            </p>
        </div>
        <div class="signin-form__item">
            <input class="signin-form__item--input" type="text" name="email" placeholder="メールアドレス" autocomplete="email" value="{{ old('email') }}"/>
            <p class="signin-form__item--error">
            @if( $errors->has('email') )
                {{$errors->first('email')}}
            @endif
            </p>
        </div>
        <div class="signin-form__item">
            <input class="signin-form__item--input" type="text" name="password"  placeholder="パスワード" value="{{ old('password') }}"/>
            <p class="signin-form__item--error">
                @if( $errors->has('password') )
                    {{$errors->first('password')}}
                @endif
            </p>
        </div>
        <div class="signin-form__item">
            <input class="signin-form__item--input" type="text" name="password_check"  placeholder="確認用パスワード" value="{{ old('password_check') }}"/>
            <p class="signin-form__item--error">
                @if( $errors->has('password_check') )
                    {{$errors->first('password_check')}}
                @endif
            </p>
        </div>
        <div class="signin-form__item">
            <button class="signin-form__button" type="submit">会員登録</button>
        </div>
        </form>
        <div class="login">
            <p class="login__message">アカウントをお持ちの方はこちらから</p>
            <a class="login__link" href="/">ログイン</a>
        </div>
</div>
@endsection