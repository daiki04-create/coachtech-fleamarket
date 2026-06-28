@extends('layouts.app')

@section('title', 'マイページ')

@section('content')
<style>
    .mypage-container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }
    .user-info { 
        display: flex; align-items: center; gap: 40px;margin-bottom: 50px; padding: 20px 0;}
    .user-info h2 { margin: 0; font-size: 24px; flex-grow: 1;}
    
    .tabs { display: flex; gap: 40px; border-bottom: 2px solid #eee; margin-bottom: 30px; }
    .tabs a { text-decoration: none; color: #888; font-weight: bold; padding-bottom: 10px; border-bottom: 2px solid transparent; transition: 0.3s; }
    .tabs a.active { color: #ff4d4d; border-bottom: 2px solid #ff4d4d; }

    .item-list { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
    .item-card { width: 100%; aspect-ratio: 1 / 1; background: #f9f9f9; overflow: hidden; border: 1px solid #eee; }
    .item-card img { width: 100%; height: 100%; object-fit: cover; }
</style>

<div class="mypage-container">
    <div class="user-info">
        @if(auth()->user()->profile && auth()->user()->profile->img_url)
            <img src="{{ asset('storage/' . auth()->user()->profile->img_url) }}" alt="画像" style="width:120px; height:120px; border-radius:50%; object-fit:cover;">
        @else
            <div style="width:120px; height:120px; border-radius:50%; background:#eee; display:flex; align-items:center; justify-content:center; flex-shrink: 0;">未設定</div>
        @endif
        
        <h2>{{ auth()->user()->name }}</h2>
        
        <a href="{{ route('mypage.profile') }}" style="color: #ff4d4d; border: 1px solid #ff4d4d; padding: 10px 25px; text-decoration: none; border-radius: 4px; font-weight: bold;">プロフィールを編集</a>
    </div>

    <div class="tabs">
        <a href="{{ route('mypage.show_list', ['page' => 'sell']) }}" class="{{ $page === 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="{{ route('mypage.show_list', ['page' => 'buy']) }}" class="{{ $page === 'buy' ? 'active' : '' }}">購入した商品</a>
    </div>

    <div class="item-list">
        @forelse($items as $item)
            <div class="item-card">
                @if($item->img_url)
                    <img src="{{ asset('storage/' . $item->img_url) }}" alt="商品画像">
                @else
                    <div style="display:flex; align-items:center; justify-content:center; height:100%; color:#ccc;">No Image</div>
                @endif
            </div>
        @empty
            <p>表示する商品はありません。</p>
        @endforelse
    </div>
</div>
@endsection