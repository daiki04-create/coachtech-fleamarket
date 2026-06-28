@extends('layouts.app')

@section('content')
<style>
    .container { display: flex; gap: 50px; max-width: 1000px; margin: 40px auto; padding: 0 20px; }
    .image-section { flex: 1; }
    .image-section img { width: 100%; border-radius: 8px; }
    .info-section { flex: 1; }
    .item-name { font-size: 24px; margin-bottom: 10px; }
    .item-brand { color: #888; margin-bottom: 20px; }
    .item-price { font-size: 28px; font-weight: bold; margin-bottom: 20px; }
    .actions { display: flex; gap: 20px; margin-bottom: 30px; }
    .action-btn { background: none; border: none; cursor: pointer; font-size: 16px; display: flex; align-items: center; gap: 5px; }
    .buy-btn { display: block; width: 100%; padding: 15px; background-color: #ff4d4d; color: #fff; text-align: center; text-decoration: none; font-weight: bold; border-radius: 4px; margin-bottom: 30px; }
</style>

@php
    $isLiked = auth()->check() && $item->likes->contains('user_id', auth()->id());
    $likeIcon = $isLiked ? 'storage/items/heart_pink.png' : 'storage/items/heart_default.png';
    $likeAction = auth()->check() ? route('items.like', $item->id) : route('login');
@endphp

<div class="container">
    <div class="image-section">
        <img src="{{ asset('storage/items/' . rawurlencode($item->img_url)) }}" alt="{{ $item->name }}">
    </div>

    <div class="info-section">
        <h1 class="item-name">{{ $item->name }}</h1>
        @if($item->brand) <div class="item-brand">{{ $item->brand }}</div> @endif
        <div class="item-price">¥{{ number_format($item->price) }} (税込)</div>

        <div class="actions">
            <form action="{{ $likeAction }}" method="POST">
                @csrf
                <button type="submit" class="action-btn">
                    <img src="{{ asset($likeIcon) }}" alt="いいね" style="width: 24px;">
                    {{ $item->likes->count() }}
                </button>
            </form>

            <button class="action-btn">
                <img src="{{ asset('storage/items/Comment.png') }}" alt="コメント" style="width: 24px;">
                {{ $item->comments->count() }}
            </button>
        </div>

        @if($item->is_sold)
            <button class="buy-btn" disabled>売り切れました</button>
        @else
            <a href="{{ route('purchase.show', $item->id) }}" class="buy-btn">購入手続きへ</a>
        @endif

        <h3>商品の説明</h3>
        <p>{{ $item->description }}</p>

        <h3>商品の情報</h3>
        @include('items._meta_table', ['item' => $item])

        @include('items._comment_list', ['comments' => $item->comments])
    </div>
</div>
@endsection