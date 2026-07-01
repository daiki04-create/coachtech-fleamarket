@extends('layouts.app')

@section('title', '会員登録')

@section('content')
<style>
    .auth-wrapper { display: flex; justify-content: center; align-items: center; min-height: 80vh; }
    .register-container { background: #fff; padding: 40px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center; }
    h2 { margin-bottom: 30px; color: #333; }
    .form-group { margin-bottom: 20px; text-align: left; }
    .form-group label { display: block; margin-bottom: 5px; color: #666; font-size: 14px; }
    .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
    .error-message { color: #a51d24; font-size: 12px; margin-top: 5px; }
    .submit-btn { width: 100%; padding: 12px; background: #ff4d4d; color: #fff; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; margin-top: 10px; }
    .login-link { display: block; margin-top: 20px; color: #0066cc; text-decoration: none; font-size: 14px; }
</style>

<div class="auth-wrapper">
    <div class="register-container">
        <h2>会員登録</h2>

        <form action="/register" method="POST" novalidate>
            @csrf
            <div class="form-group">
                <label for="name">ユーザー名</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" autofocus>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password">
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">パスワード確認</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
                @error('password_confirmation')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="submit-btn">登録する</button>
        </form>

        <a href="/login" class="login-link">ログインはこちら</a>
    </div>
</div>
@endsection