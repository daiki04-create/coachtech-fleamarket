<h3 class="section-title">コメント一覧</h3>
<div style="margin-bottom: 20px;">
    @foreach($comments as $c)
        <div style="padding: 10px; border-bottom: 1px solid #eee;">
            <strong>{{ $c->user->name }}</strong>: {{ $c->comment }}
        </div>
    @endforeach
</div>

<h3 class="section-title">コメントを送信する</h3>
<form action="{{ route('items.comment', $item->id) }}" method="POST">
    @csrf
    
    @error('comment')
        <div style="color: #a51d24; font-size: 12px; margin-bottom: 10px; font-weight: bold;">
            {{ $message }}
        </div>
    @enderror

    <textarea name="comment" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ccc; box-sizing: border-box;"></textarea>
    
    <button type="submit" style="display: block; width: 100%; padding: 10px; background: #ff4d4d; color: #fff; border: none; margin-top: 10px; cursor: pointer; font-weight: bold;">
        コメントを送信する
    </button>
</form>