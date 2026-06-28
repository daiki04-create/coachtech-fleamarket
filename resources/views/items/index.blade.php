@extends('layouts.app')

@section('title', '商品一覧')

@section('content')
<style>
    .index-container { max-width: 1200px; margin: 0 auto; padding: 40px 20px; }
    .tabs { margin-bottom: 20px; display: flex; border-bottom: 1px solid #eee; }
    .tab { text-decoration: none; color: #aaa; margin-right: 30px; padding-bottom: 10px; font-weight: bold; }
    .tab.active { color: #ff4d4d; border-bottom: 2px solid #ff4d4d; }
    
    .item-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 30px; }
    .item-card { background: #fff; border: 1px solid #eee; border-radius: 4px; overflow: hidden; transition: 0.3s; position: relative; }
    .item-card:hover { border-color: #ff4d4d; }
    .item-card img { width: 100%; height: 240px; object-fit: cover; }
    
    .sold-label {position: absolute;top: 10px;left: 10px;background: #ff4d4d;color: #fff;padding: 4px 12px;font-weight: bold;border-radius: 4px;font-size: 14px;}
    
    .item-info { padding: 10px; }
    .item-card h3 { font-size: 15px; margin: 5px 0; color: #333; }
    .item-card p { font-size: 16px; color: #333; font-weight: bold; margin: 0; }
</style>

<div class="index-container">
    <div class="tabs">
        <a href="{{ route('items.index') }}" class="tab {{ request()->query('tab') !== 'mylist' ? 'active' : '' }}">おすすめ</a>
        <a href="{{ route('items.index', ['tab' => 'mylist']) }}" class="tab {{ request()->query('tab') === 'mylist' ? 'active' : '' }}">マイリスト</a>
    </div>

    <div class="item-grid">
        @forelse($items as $item)
            <a href="{{ route('items.show', $item->id) }}" style="text-decoration: none; color: inherit;">
                <div class="item-card">
                    <img src="{{ asset('storage/items/' . rawurlencode($item->img_url)) }}" alt="{{ $item->name }}">
                    
                    @if($item->is_sold)
                        <div class="sold-label">Sold</div>
                    @endif
                    
                    <div class="item-info">
                        <h3>{{ $item->name }}</h3>
                        <p>¥{{ number_format($item->price) }}</p>
                    </div>
                </div>
            </a>
        @empty
            <p style="grid-column: 1 / -1; text-align: center; color: #999; margin-top: 50px;">
                {{ request()->query('tab') === 'mylist' && !Auth::check() ? 'ログインするとマイリストが表示されます。' : '該当する商品が見つかりませんでした。' }}
            </p>
        @endforelse
    </div>
</div>
@endsection