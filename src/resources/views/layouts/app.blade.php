<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')

</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                Atte
            </a>
            <nav>
                @auth
                <ul>
                    <li class="nav__item"><a href="/">ホーム</a></li>
                    <li class="nav__item"><a href="/attendance">日付一覧</a></li>
                    <li class="nav__item">
                        <form class="logout-form" action="/logout" method="post">
                            @csrf
                            <button class="logout-form__button">ログアウト</button>
                        </form>
                    </li>
                </ul>
                @endauth
            </nav>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <footer class="footer">
        <div class="footer__inner">
            <p class="footer__copyright">Atte,inc.</p>
        </div>
    </footer>
    @yield('js')
</body>
</html>