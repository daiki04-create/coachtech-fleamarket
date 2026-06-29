@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
<style>
    .auth-wrapper { display: flex; justify-content: center; align-items: center; min-height: 80vh; }
    .login-container { background: #fff; padding: 40px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center; }
    h2 { margin-bottom: 30px; color: #333; }
    .form-group { margin-bottom: 20px; text-align: left; }
    .form-group label { display: block; margin-bottom: 5px; color: #666; font-size: 14px; }
    .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
    /* エラーメッセージ用のスタイル */
    .error-message { color: #a51d24; font-size: 12px; margin-top: 5px; }
    .submit-btn { width: 100%; padding: 12px; background: #ff4d4d; color: #fff; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; margin-top: 10px; }
    .register-link { display: block; margin-top: 20px; color: #0066cc; text-decoration: none; font-size: 14px; }
</style>

<div class="auth-wrapper">
    <div class="login-container">
        <h2>ログイン</h2>

        <form action="/login" method="POST" novalidate>
    @csrf
    <div class="form-group">
        <label for="email">メールアドレス</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}">
        {{-- ここで 'email' のバリデーションエラー(空欄チェック含む)を確実に表示 --}}
        @error('email')
            <div class="error-message" style="color: #a51d24;">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">パスワード</label>
        <input type="password" id="password" name="password">
        {{-- ここで 'password' のバリデーションエラーを確実に表示 --}}
        @error('password')
            <div class="error-message" style="color: #a51d24;">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="submit-btn">ログインする</button>
</form>

        <a href="/register" class="register-link">会員登録はこちら</a>
    </div>
</div>
@endsection