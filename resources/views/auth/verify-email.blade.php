@extends('layouts.app')

@section('content')
<div class="verify-container" style="text-align: center; margin-top: 50px;">
    <h2>メール認証</h2>
    <p>登録していただいたメールアドレスに認証メールを送付しました。<br>メール認証を完了してください。</p>
    
    <div style="margin: 20px 0;">
        <a href="https://mailtrap.io/" target="_blank" class="btn-verify" 
           style="display: inline-block; padding: 15px 40px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold;">
           認証メールを確認する（Mailtrapを開く）
        </a>
    </div>

    <form action="{{ route('verification.send') }}" method="POST">
        @csrf
        <p>メールが届かない場合はこちら</p>
        <button type="submit" style="background: none; border: none; color: #007bff; cursor: pointer; text-decoration: underline;">
            認証メールを再送する
        </button>
    </form>
</div>
@endsection