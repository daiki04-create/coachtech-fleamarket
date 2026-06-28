<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'COACHTECH フリマ')</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 0; background: #fff; }
        .header { background: #000; padding: 15px 0; border-bottom: 1px solid #333; }
        .header-container {display: flex;justify-content: space-between;align-items: center;}
        .header-search {flex: 1;margin: 0 20px;text-align: center;}
        .header-search input {    width: 100%;max-width: 400px;padding: 8px;}
        .header-logo { height: 30px; display: block; }
        .nav-menu { display: flex; gap: 20px; align-items: center; }
        .nav-menu a { text-decoration: none; color: #fff; font-weight: bold; }
        .btn-sell { border: 1px solid #fff; padding: 5px 15px; border-radius: 4px; }
        .content { width: 100%; margin: 0; padding: 0; }
    </style>
</head>
<body>
<header class="header">
    <div class="header-container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; height: 60px;">
        <a href="{{ route('items.index') }}">
            <img src="{{ asset('storage/items/COACHTECHヘッダーロゴ.png') }}" alt="ロゴ" class="header-logo" style="height: 30px;">
        </a>

        <form action="{{ route('items.index') }}" method="GET" class="header-search" style="flex: 1; text-align: center;">
            <input type="text" name="keyword" value="{{ $keyword ?? '' }}" placeholder="なにをお探しですか？" style="width: 100%; max-width: 400px; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </form>
        
        <nav class="nav-menu" style="display: flex; gap: 20px; align-items: center;">
            @auth
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="text-decoration: none; color: #fff; font-weight: bold;">ログアウト</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                <a href="{{ route('mypage.profile') }}" style="text-decoration: none; color: #fff; font-weight: bold;">マイページ</a>
                <a href="{{ route('items.sell') }}" class="btn-sell" style="text-decoration: none; color: #fff; border: 1px solid #fff; padding: 5px 15px; border-radius: 4px;">出品</a>
            @else
                <a href="/login" style="text-decoration: none; color: #fff; font-weight: bold;">ログイン</a>
                <a href="/register" style="text-decoration: none; color: #fff; font-weight: bold;">会員登録</a>
            @endauth
        </nav>
    </div>
</header>

    <main class="content">
        @yield('content')
    </main>
</body>
</html>